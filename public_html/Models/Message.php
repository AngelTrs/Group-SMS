<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 12/19/2018
 * Time: 8:49 PM
 */

namespace Models;

use Twilio\Rest\Client;

class Message
{
    private $pdo;

    // simple message
    private $mClient;
    private $mFrom;
    private $mBody;

    // blast
    private $mId;
    private $mAdminId;
    private $mRecipientGroup; // all or admin
    private $mRecipients; // array of the actual phone numbers
    private $mDateSent;
    private $mNumberSent;
    private $mNumberSuccess;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;

        $sid = TWILIO['sid'];
        $token = TWILIO['token'];
        $this->mClient = new Client($sid, $token);
        $this->mFrom = TWILIO['fromNumber'];
    }

    public function sendWelcome($to, $body)
    {

        try {
            $this->mClient->messages
                ->create(
                    $to,
                    array(
                        "from" => $this->mFrom,
                        "body" => $body,
                        "statusCallback" => APP_DOMAIN . "/webhooks/twilio_sms_outgoing_welcome.php"
                        //"mediaUrl" => "http://www.example.com/cheeseburger.png"
                    )
                );
        } catch (Twilio\Exceptions\RestException $e) {
            //$e->getMessage();
            throw $e;
        }
    }

    public function setBlast($adminId, $recGroup, $recipients, $body)
    {
        $this->mAdminId = $adminId;
        $this->mRecipientGroup = $recGroup;
        $this->mRecipients = $recipients;
        $this->mBody = $body;
        $this->mNumberSent = 0;
        $this->mNumberSuccess = 0;
    }

    public function sendBlast()
    {
        foreach ($this->mRecipients as $to) {
            try {
                $this->mClient->messages
                    ->create(
                        $to,
                        array(
                            "from" => $this->mFrom,
                            "body" => $this->mBody,
                            "statusCallback" => APP_DOMAIN . "/webhooks/twilio_sms_outgoing.php?mid=" . $this->mId
                        )
                    );
                $this->mNumberSent++;
            } catch (Twilio\Exceptions\RestException $e) {
                throw $e;
            }
        }

        $stmt = $this->pdo->prepare('UPDATE messages SET NUM_SENT=:numSent WHERE ID=:id');
        $stmt->execute([
            'numSent' => $this->mNumberSent,
            'id' => $this->mId
        ]);
    }

    public static function readAll($pdo)
    {
        $stmt = $pdo->query('SELECT ID as id, RECIPIENT_GROUP as recGroup, BODY as body, DATE_SENT as dateSent, NUM_SENT as numSent, NUM_SUCCESS as numSuccess  FROM messages ORDER BY ID DESC');
        $messages = $stmt->fetchAll();
        return $messages;
    }

    public function create()
    {
        $stmt = $this->pdo->prepare('INSERT INTO messages(ADMIN_USER_ID, RECIPIENT_GROUP, BODY, NUM_SENT, NUM_SUCCESS) VALUES (:adminId, :recGroup, :body, :numSent, :numSuccess)');
        $stmt->execute([
            'adminId' => $this->mAdminId,
            'recGroup' => $this->mRecipientGroup,
            'body' => $this->mBody,
            'numSent' => $this->mNumberSent,
            'numSuccess' => $this->mNumberSuccess
        ]);
        $this->mId = $this->pdo->lastInsertId();
    }



    // helpers

    /*https://stackoverflow.com/questions/8349831/best-way-to-detect-number-of-sms-needed-to-send-a-text*/
    public static function count_gsm_string($str)
    {

        $str = utf8_encode($str);

        // Basic GSM character set (one 7-bit encoded char each)
        $gsm_7bit_basic = utf8_encode("@£\$¥èéùìòÇ\nØø\rÅåΔ_ΦΓΛΩΠΨΣΘΞÆæßÉ !\"#¤%&'()*+,-./0123456789:;<=>?¡ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÑÜ§¿abcdefghijklmnopqrstuvwxyzäöñüà");

        // Extended set (requires escape code before character thus 2x7-bit encodings per)
        $gsm_7bit_extended = utf8_encode("^{}\\[~]|€");

        $len = 0;

        for ($i = 0; $i < mb_strlen($str); $i++) {
            if (mb_strpos($gsm_7bit_basic, $str[$i]) !== FALSE) {
                $len++;
            } else if (mb_strpos($gsm_7bit_extended, $str[$i]) !== FALSE) {
                $len += 2;
            } else {
                return -1; // cannot be encoded as GSM, immediately return -1
            }
        }

        return $len;
    }

// Internal encoding must be set to UTF-8,
// and the input string must be UTF-8 encoded for this to work correctly
    public static function count_ucs2_string($str)
    {
        $utf16str = mb_convert_encoding($str, 'UTF-16', 'UTF-8');
        // C* option gives an unsigned 16-bit integer representation of each byte
        // which option you choose doesn't actually matter as long as you get one value per byte
        $byteArray = unpack('C*', $utf16str);
        return count($byteArray) / 2;
    }

    public static function multipart_count($str)
    {
        $one_part_limit = 160; // use a constant i.e. GSM::SMS_SINGLE_7BIT
        $multi_limit = 153; // again, use a constant
        $max_parts = 3; // ... constant

        $str_length = Message::count_gsm_string($str);

        if ($str_length === -1) {
            $one_part_limit = 70; // ... constant
            $multi_limit = 67; // ... constant
            $str_length = count_ucs2_string($str);
        }

        if ($str_length <= $one_part_limit) {
            // fits in one part
            return 1;
        } else if ($str_length > ($max_parts * $multi_limit)) {
            // too long
            return -1; // or throw exception, or false, etc.
        } else {
            // divide the string length by multi_limit and round up to get number of parts
            return ceil($str_length / $multi_limit);
        }
    }
}
