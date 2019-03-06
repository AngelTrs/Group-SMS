<?php
 // Globals Configuration
const HTTPS_REDIRECT = false;

const APP_TITLE = "SMS GROUP!";
const APP_NUMBER = "855-333-4444";
const SPLASH = "<h1><span class=\"splash animated flash\">". APP_TITLE ."</span></h1>";
const IG_LINK = "http://www.instagram.com/";
const FOOTER_TEXT = "___ copyright © 2019 ". APP_TITLE .", all rights are reserved.";

const WELCOME_MESSAGE_TEXT = "We're pushing news forward. Save us in your contacts! To opt out at any time, just reply STOP. - ". APP_TITLE;

const BRUTE_MAX_ATTEMPTS = 5;

const CONTACT_TEXT = "For help, business inquries, or just to say hey, email: <a class=\"cus-whiteLink lead\" href=\"mailto:contact@site.com\">contact@site.com</a>";

// Database Configuration
const DATABASE = [
    'host' => 'host',
    'name' => 'db_name',
    'user' => 'username',
    'password' => 'password'
];

const TWILIO = [
  'sid' => 'AC00000000000000000',
  'token' => 'ac00000000000',
  'fromNumber' => '+18553334444'
];

const APP_DOMAIN = "http://www.appname.com";