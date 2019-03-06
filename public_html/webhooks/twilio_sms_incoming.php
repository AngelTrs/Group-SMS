<?php
require_once 'config.php';
require_once 'db.php';


// post from Twilio
$from = $_POST['From'];
$body = $_POST['Body'];

if ($from != "") {

    if (strtoupper($body) == "STOP") {
        // You have attempted to send to a 'To' number that has replied with "STOP" to one of your previous messages. You will not be able to send to the phone number specified in the 'To' parameter until the subscriber identified by the phone number has responded with "START".

        $stmt = $pdo->prepare('UPDATE subscribers SET ACTIVE=0, STOP=1 WHERE MOBILE_NUMBER=:mobileNumber');
        $stmt->execute(['mobileNumber' => $from]);
        $body .= " [cms: auto unsubscribed]";
    }

    if (strtoupper($body) == "START") {
        // You have attempted to send to a 'To' number that has replied with "STOP" to one of your previous messages. You will not be able to send to the phone number specified in the 'To' parameter until the subscriber identified by the phone number has responded with "START".

        $stmt = $pdo->prepare('UPDATE subscribers SET ACTIVE=1, STOP=0 WHERE MOBILE_NUMBER=:mobileNumber');
        $stmt->execute(['mobileNumber' => $from]);
        $body .= " [cms: auto re-subscribed]";
    }


    $stmt = $pdo->prepare('INSERT INTO incoming_sms (FROM_NUMBER, BODY) VALUES (:from, :body)');
    $stmt->execute(['from' => $from, 'body'=> $body]);

    $filedate = date("Ym");

}
