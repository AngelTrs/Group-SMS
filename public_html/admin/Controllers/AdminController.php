<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 2/2/2019
 * Time: 5:17 PM
 */

namespace Controllers;
use Models\Message;
use Models\Subscriber;

class AdminController
{
    private $pdo;
    private $mView;

    public function __construct($view)
    {
        if (get_class($view) != "Views\LoginView") $this->checkAuth();

        $this->mView = $view;

        if (isset($_SESSION['alerts'])) {
            $this->mView->setAlerts($_SESSION['alerts']);
            unset($_SESSION['alerts']);
        }

        //establish DB connection
        require 'db.php';
        $this->pdo = $pdo;
    }

    public function main() {
        $this->mView->setMessages(Message::readAll($this->pdo));
    }

    public function messagePreview() {
        $newMessage = array(
            'recipients' => $_POST['recipients'],
            'body' => $_POST['messageBody'],
            'characters' => strlen($_POST['messageBody']),
            'segments' => Message::multipart_count($_POST['messageBody'])
        );

        $this->mView->setMessage($newMessage);
    }

    public function viewSubscribers() {
        $this->mView->setSubscribers(Subscriber::readAllActive($this->pdo));
    }

    public function editSubscriber($id) {
        $sub = new Subscriber($this->pdo);
        try {
            $sub->read($id);
        } catch (\Exception $e) {
            $_SESSION['alerts'] = [$e->getMessage()];
            header('Location: /admin/subscribers');
            exit();
        }

        $this->mView->setSubscriber($sub);
    }

    private function checkAuth() {
        // check if user already logged in.
        if (!isset($_SESSION['user'])) {
            $_SESSION['alerts'] = ["Authentication required, please login."];
            header('Location: /admin');
            exit();
        }

        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
            header('Location: /admin/timeout');
            exit();
        }

        $_SESSION['last_activity'] = time(); // update last activity time stamp
    }
}