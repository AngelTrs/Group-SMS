<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 12/19/2018
 * Time: 10:20 PM
 */
namespace client\Views;


class ClientView
{
    private $mErrors = null;

    public function __construct()
    {

    }

    /**
     * @param mixed $mErrors
     */
    public function setErrors($errors)
    {
        $this->mErrors = $errors;
    }

    public function displayErrors() {

        if ($this->mErrors != null) {
            foreach($this->mErrors as $error) {
                echo "<div class=\"alert alert-danger\" role=\"alert\"><small>". $error ."</small></div>";
            }
        }
    }
}