<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
require_once 'Models/Message.php';
require_once 'Models/Subscriber.php';

use Controllers\AdminController;
use Controllers\PostController;

use Views\LoginView;
use Views\MainView;
use Views\MessagePreviewView;
use Views\SubscriberView;
use Views\SubscriberEditView;

// Simple auto loader translate \rooms\classname() to ./rooms/classname.php
// https://stackoverflow.com/questions/12630840/why-do-you-have-to-include-php-file-when-using-namespace
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once
    ('./' . $class . '.php');
});

session_start();

if (HTTPS_REDIRECT == true && (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")) {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}

// gets variable from URL
$uri = explode('/', $_SERVER['REQUEST_URI']);

switch ($_SERVER['REQUEST_URI']) {

    case '/admin/messages':
        $view = new MainView();
        $controller = new AdminController($view);
        $controller->main();
        break;
    case '/admin/messages/preview':
        $view = new MessagePreviewView();
        $controller = new AdminController($view);
        $controller->messagePreview();
        break;
    case '/admin/messages/post':
        $controller = new PostController();
        $controller->sendPush();
        break;

    case '/admin/subscribers':
        $view = new SubscriberView();
        $controller = new AdminController($view);
        $controller->viewSubscribers();
        break;
    case '/admin/subscribers/add/post':
        $controller = new Controllers\PostController();
        $controller->subscribe();
        break;
    case '/admin/subscribers/edit/' . $uri[4]:
        $view = new SubscriberEditView();
        $controller = new Controllers\AdminController($view);
        $controller->editSubscriber($uri[4]);
        break;
    case '/admin/subscribers/edit/' . $uri[4] . '/post':
        $controller = new Controllers\PostController();
        $controller->editSubscriber($uri[4]);
        break;
    case '/admin/subscribers/unsub/' . $uri[4] . '/post':
        $controller = new Controllers\PostController();
        $controller->unsubscribe($uri[4]);
        break;

    case '/admin/timeout':
        session_destroy();
        session_start();
        $_SESSION['alerts'] = ["Your session expired, please start again."];
        header('Location: /admin');
        break;
    case '/admin/login':
        $controller = new PostController();
        $controller->login();
        break;
    case '/admin/logout':
        session_destroy();
        session_start();
        $_SESSION['alerts'] = ["user logged out."];
        header('Location: /admin');
        break;

    default:
        $view = new LoginView();
        $controller = new AdminController($view);
        break;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- Bootstrap Form Helpers -->
    <link href="/css/bootstrap-formhelpers.min.css" rel="stylesheet" media="screen">


    <title><?php echo APP_TITLE; ?> admin</title>
</head>
<body>

<div class="container-fluid">

    <?php $view->render(); ?>

</div>

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>

<script src="https://use.fontawesome.com/bb724fcb2e.js"></script>
<script src="/js/bootstrap-formhelpers-phone.js"></script>

<script>
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var name = button.data('name')
        var modal = $(this)
        modal.find('.modal-body').text('are you sure you would like to unsubscribe ' + name + '?');
        $("#unsub_form_link").attr("action", "/admin/subscribers/unsub/" + id + "/post");
    })
</script>

</body>
</html>