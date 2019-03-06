<?php
require_once 'config.php';
require_once 'db.php';

$id = $_GET['mid'];

// post from TwilioException
$status = $_POST['MessageStatus'];
$error_code = $_POST['ErrorCode'];
$error_message = $_POST['ErrorMessage'];
$from = $_POST['From'];
$to = $_POST['To'];

if ($status == 'sent') {
    $stmt = $pdo->prepare('UPDATE messages SET NUM_SUCCESS=NUM_SUCCESS+1 WHERE ID=:id');
    $stmt->execute(['id' => $id]);
}

if ($error_code == "21610") {

    // You have attempted to send to a 'To' number that has replied with "STOP" to one of your previous messages. You will not be able to send to the phone number specified in the 'To' parameter until the subscriber identified by the phone number has responded with "START".

    $stmt = $pdo->prepare('UPDATE subscribers SET ACTIVE=0, STOP=1 WHERE MOBILE_NUMBER=:mobileNumber');
    $stmt->execute(['mobileNumber' => $to]);

} else if ($error_code != "") {

}
