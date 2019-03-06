<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 11/13/2018
 * Time: 1:17 PM
 */

namespace client\Controllers;

use Models\Message;
use Models\Subscriber;

class PostController
{
    private $pdo;

    public function __construct()
    {
        if (!isset($_POST['submit'])) {
            header('Location: /');
            exit();
        }

        //establish DB connection
        require 'db.php';
        $this->pdo = $pdo;

        $stmt = $this->pdo->prepare('INSERT INTO brute_protection (IP_ADDRESS) VALUES (:ip)');
        $stmt->execute(['ip' => $_SERVER['REMOTE_ADDR']]);

        $stmt = $this->pdo->prepare('SELECT count(1) FROM brute_protection WHERE IP_ADDRESS=:ip');
        $stmt->execute(['ip' => $_SERVER['REMOTE_ADDR']]);
        $count = $stmt->fetchColumn();

        if ($count > BRUTE_MAX_ATTEMPTS) {
            $_SESSION['errors'] = ["Too many attempts from this IP. Please try again after 24 hours."];
            header('Location: /');
            exit();
        }
    }

    public function subscribe()
    {
        $inputs = array(
            'email' => $_POST['email'],
            'firstName' => strtoupper($_POST['firstName']),
            'lastName' => strtoupper($_POST['lastName']),
            'mobileNumber' => $_POST['mobileNumber'],
            'zipCode' => $_POST['zipCode']
        );

        $errors = $this->validateSubscribe($inputs);

        if (sizeof($errors) > 0) {
            $_SESSION['errors'] = $errors;
            header('Location: /');
            exit();
        }

        // SUBSCRIBER CREATE
        $subscriber = Subscriber::newFromClient($this->pdo, $inputs);

        $message = new Message($this->pdo);
        try {
            $message->sendWelcome(Subscriber::numberE164($inputs['mobileNumber']), WELCOME_MESSAGE_TEXT);
        } catch (Exception $e) {

            $subscriber->setActive(0);
            $subscriber->setError(1);
            $subscriber->create();

            $_SESSION['errors'] = ["not able to validate your mobile number. Try again or contact us."];
            header('Location: /');
            exit();
        }
        $subscriber->setActive(1);
        $subscriber->setError(0);
        $subscriber->create();

        header("Location: /welcome");
        exit();
    }

    public function unsubscribe() {

        $inputs = array(
            'mobileNumber' => $_POST['mobileNumber']
        );

        $errors = array();

        if (strlen($inputs['mobileNumber']) != 12) {
            $errors[] = "Please enter mobile number in correct format.";
        }

        if (sizeof($errors) > 0) {
            $_SESSION['errors'] = $errors;
            header('Location: /unsubscribe');
            exit();
        }

        $subscriber = new Subscriber($this->pdo);
        try {
            $subscriber->readByMobile($inputs['mobileNumber']);
        } catch (\Exception $e) {
            $_SESSION['errors'] = ["mobile number not found."];
            header('Location: /unsubscribe');
            exit();
        }

        if ($subscriber->getActive() == 0) {
            $_SESSION['errors'] = ["mobile number already unsubscribed."];
            header('Location: /unsubscribe');
            exit();
        }

        $subscriber->setActive(0);
        $subscriber->update();

        header("Location: /bye");
        exit();
    }


    // Validation Methods
    private function validateSubscribe($inputs)
    {
        $errors = array();

        foreach ($inputs as $input) {
            $empty = false;
            if ($input == "") $empty = true;
            if ($empty == true) $errors[] = "All fields are required.";
        }

        if (!filter_var($inputs["email"], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "please verify email.";
        }

        if (!ctype_alpha($inputs["firstName"]) || !ctype_alpha($inputs["lastName"])) {
            $errors[] = "Please verify name entered.";
        }

        if (strlen($inputs["mobileNumber"]) != 12) {
            $errors[] = "Please enter mobile number in correct format.";
        }

        if (strlen($inputs["zipCode"]) != 5 || !ctype_digit($inputs["zipCode"])) {
            $errors[] = "Please verify zip code entered.";
        }

        $active = Subscriber::exists($this->pdo, $inputs["mobileNumber"]);

        if ($active == 1) $errors[] = "This mobile number is already subscribed and active.";
        if ($active == 0) $errors[] = "This mobile number is already subscribed, to RESTART alerts text START to ". APP_NUMBER;


        return $errors;
    }
}