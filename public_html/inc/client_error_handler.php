<?php

session_start();


abstract class ErrorType
{
    // subscribe
    const INPUT = "some of your info was off, please re-enter carefully.";
    const BACKEND = "something wrong on our end. If error persists, please check back later.";
    const DUPE = "mobile # already subscribed. Try another or contact us.";
    const SMS = "not able to validate your mobile number. Try again or contact us.";
    const IP_SAFETY = "attempts exceed for your IP. Please try again in 24 hours.";
    const OPT = "previously opted out, to receive messsages text START to 646-713-BLCK (2525)";

    // unsubscribe
    const NOTFOUND = "no active subscription found. Try again or contact us.";
}

function displayError()
{


    $error = $_SESSION['error_type'];


    if (isset($_SESSION['error_type'])) {

        echo "<div class=\"row alert alert-danger text-center\" role=\"alert\">" .

            $error .

            "</div>";

        unset($_SESSION["error_type"]);

    }

}


function setError($error_type)
{


    // example parameter input:: ErrorType::INPUT

    $_SESSION['error_type'] = $error_type;

}

