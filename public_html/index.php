<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use client\Controllers\ClientController;
use client\Controllers\PostController;

use client\Views\HomeView;
use client\Views\WelcomeView;
use client\Views\AboutView;
use client\Views\UnsubscribeView;
use client\Views\ByeView;

session_start();

// Simple auto loader translate \rooms\classname() to ./rooms/classname.php
// https://stackoverflow.com/questions/12630840/why-do-you-have-to-include-php-file-when-using-namespace
spl_autoload_register(function($class) {
    $class = str_replace('\\', '/', $class);
    require_once
    ('' . $class . '.php');
});

if (HTTPS_REDIRECT == true && (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")) {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}

switch ($_SERVER['REQUEST_URI']) {

    case '/about':
        $view = new AboutView();
        break;

    case '/subscribe/post':
        $controller = new PostController();
        $controller->subscribe();
        break;

    case '/welcome':
        $view = new WelcomeView();
        break;

    case '/unsubscribe':
        $view = new UnsubscribeView();
        $controller = new ClientController($view);
        break;

    case '/unsubscribe/post':
        $view = new UnsubscribeView();
        $controller = new PostController();
        $controller->unsubscribe();
        break;

    case '/bye':
        $view = new ByeView();
        break;


    default:
        $view = new HomeView();
        $controller = new ClientController($view);
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <!-- Bootstrap Form Helpers -->
    <link href="/css/bootstrap-formhelpers.min.css" rel="stylesheet" media="screen">
    <link href="/css/custom.css" rel="stylesheet" media="screen">

    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">

    <!-- https://daneden.github.io/animate.css/  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

    <title><?php echo APP_TITLE; ?></title>
</head>
<body>

<div class="container-fluid">

    <!-- splash logo -->
    <div class="row p-1">
        <div class="col-12 text-center">
            <?php echo SPLASH; ?>
        </div>
    </div>

    <!-- main-captain -->
    <h5 class="text-center">
        sends you SMS alerts about the news you want, directly to your mobile.
    </h5>

    <!-- mobile buttons -->
    <div class="row mt-3 ">
        <div class="col-6 offset-sm-2 col-sm-4 hidden-lg-up text-center">
            <a href="/about">
                <button class="btn btn-secondary btn-block">
                    <span class="hidden-xs-down">what is <?php echo APP_TITLE; ?>?</span>
                    <span class="hidden-sm-up" style=" font-size: .85em;">what is <?php echo APP_TITLE; ?>?</span></button>
            </a>
        </div>

        <div class="col-6 col-sm-4 hidden-lg-up text-center">
            <a href="<?php echo IG_LINK; ?>" target="_blank">
                <button class="btn btn-secondary btn-block"><i class="fa fa-instagram left"></i> <span>instagram</span>
                </button>
            </a></div>
    </div>
    <!-- ./mobile buttons -->

    <?php echo $view->render(); ?>

<!-- start of footer area -->
<?php include('client/Views/layout_footer.php'); ?>

</div>

<div class="fixed-top offset-10 col-2 hidden-md-down" style="text-align:right">
    <a href="<?php echo IG_LINK; ?>" target="_blank">
        <button class="btn btn-secondary"><i class="fa fa-instagram left"></i> <span>instagram</span></button>
    </a>
</div>

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
        crossorigin="anonymous"></script>
<script src="/js/bootstrap-formhelpers.min.js"></script>
<script src="/js/bootstrap-formhelpers-phone.js"></script>
<script src="https://use.fontawesome.com/bb724fcb2e.js"></script>
<script src="https://cdn.rawgit.com/twbs/bootstrap/v3.3.7/js/affix.js"></script>

</body>
</html>