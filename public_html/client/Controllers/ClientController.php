<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 12/20/2018
 * Time: 12:33 PM
 */

namespace client\Controllers;

class ClientController
{
    private $mView;

    public function __construct($view)
    {
        $this->mView = $view;

        if (isset($_SESSION['errors'])) {
            $this->mView->setErrors($_SESSION['errors']);
            unset($_SESSION['errors']);
        }
    }
}