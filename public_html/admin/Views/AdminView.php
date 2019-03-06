<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 1/28/2019
 * Time: 5:41 PM
 */
namespace Views;

class AdminView
{
    private $mAlerts;

    public function __construct()
    {

    }

    public function setAlerts($alerts)
    {
        $this->mAlerts = $alerts;
    }

    public function displayAlerts() {
        if ($this->mAlerts != null) {
            foreach($this->mAlerts as $message) {
                echo "<div class=\"alert alert-info\" role=\"alert\"><small>". $message ."</small></div>";
            }
        }
    }
}