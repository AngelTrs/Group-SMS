<?php
require_once 'config.php';
require_once 'db.php';

// post from TwilioException
$status = $_POST['MessageStatus'];
$error_code = $_POST['ErrorCode'];
$error_message = $_POST['ErrorMessage'];
$from = $_POST['From'];
$to = $_POST['To'];

if ($status == 'sent') {
    $stmt = $pdo->prepare('UPDATE subscribers SET VALIDATED=1 WHERE MOBILE_NUMBER=:mobileNumber');
    $stmt->execute(['mobileNumber' => $to]);
}

if ($error_code != "") {

    $stmt = $pdo->prepare('UPDATE subscribers SET ACTIVE=0, ERROR=1 WHERE MOBILE_NUMBER=:mobileNumber');
    $stmt->execute(['mobileNumber' => $to]);
}
