<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 11/13/2018
 * Time: 1:17 PM
 */

namespace Controllers;
use Models\Message;
use Models\Subscriber;

class PostController
{
    private $pdo;

    public function __construct()
    {
        if (!isset($_POST['submit'])) {
            header('Location: /admin');
            exit();
        }

        //establish DB connection
        require 'db.php';
        $this->pdo = $pdo;
    }

    public function login()
    {
        $inputs = array(
            'email' => $_POST['email'],
            'password_sha1' => sha1($_POST['password'])
        );

        $error = $this->validateLogin($inputs);

        if ($error != null) {
            $_SESSION['alerts'] = $error;
            header('Location: /admin');
            exit();
        }

        $stmt = $this->pdo->prepare('SELECT ID as id, EMAIL as email, FIRST_NAME as firstName FROM admin_users WHERE EMAIL= :email AND PASSWORD= :password');
        $stmt->execute(['email' => $inputs['email'],'password' => $inputs['password_sha1']]);
        $user = $stmt->fetch();

        if ($user) {
                $_SESSION['user'] = $user;

                header("Location: /admin/messages");
                exit();

        } else {
            $_SESSION['alerts'] = ["Incorrect Username and password combination."];
            header('Location: /admin');
            exit();
        }
    }

    public function sendPush() {

        $adminId = $_SESSION['user']['id'];
        $recipientGroup = $_POST['recipients'];
        if ($recipientGroup == "admin") {
            $recipients = Subscriber::readAllAdminNumbers($this->pdo);
        }
        else {
            $recipients = Subscriber::readAllActiveNumbers($this->pdo);
        }
        // array of numbers
        $body = $_POST["messageBody"];

        $message = new Message($this->pdo);
        $message->setBlast($adminId, $recipientGroup, $recipients, $body);
        $message->create();

        try {
            $message->sendBlast();
        }
        catch (\Exception $e) {
            $_SESSION['alerts'] = [$e->getMessage()];
            header('Location: /admin/messages');
            exit();
        }

        $_SESSION['alerts'] = ["Push message sent."];
        header('Location: /admin/messages');
        exit();
    }

    public function subscribe()
    {
        $inputs = array(
            'email' => $_POST['email'],
            'firstName' => ucfirst($_POST['firstName']),
            'lastName' => ucfirst($_POST['lastName']),
            'mobileNumber' => $_POST['mobileNumber'],
            'zipCode' => $_POST['zipCode']
        );

        // SUBSCRIBER CREATE
        $sub = Subscriber::newFromClient($this->pdo, $inputs);

        $sub->setActive(1);
        $sub->setError(0);

        $sub->create();

        $_SESSION['alerts'] = ["subscriber added: " . $sub->getFirstName() . " " . $sub->getLastName()];
        header('Location: /admin/subscribers');
        exit();
    }
    public function unsubscribe($id) {
        $sub = new Subscriber($this->pdo);
        $sub->read($id);
        $sub->setActive(0);
        $sub->update();

        $_SESSION['alerts'] = ["unsubscribed: " . $sub->getFirstName() . " " . $sub->getLastName()];
        header('Location: /admin/subscribers');
        exit();
    }
    public function editSubscriber($id)
    {
        $sub = new Subscriber($this->pdo);
        $sub->read($id);

        $sub->setEmail($_POST['email']);
        $sub->setFirstName($_POST['firstName']);
        $sub->setLastName($_POST['lastName']);
        $sub->setMobileNumber($_POST['mobileNumber']);
        $sub->setZipCode($_POST['zipCode']);

        $sub->update();

        $_SESSION['alerts'] = ["updated: " . $sub->getFirstName() . " " . $sub->getLastName()];
        header('Location: /admin/subscribers');
        exit();
    }

    private function validateLogin($inputs)
    {
        $error = null;

        if (($inputs[email] == '') || ($inputs[password_sha1] == '') || !filter_var($inputs[email], FILTER_VALIDATE_EMAIL)) {
            $error = "Valid email and password required.";
        }

        return $error;
    }
}