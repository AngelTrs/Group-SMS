<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 12/20/2018
 * Time: 9:59 AM
 */
namespace client\Views;

class WelcomeView extends ClientView
{
    public function __construct()
    {

    }

    public function render()
    { ?>


        <div class="row mt-3 mb-3" style="text-align:center">
            <div class="offset-sm-2 col-sm-8 offset-lg-4 col-lg-4" style="text-align:center">

                <div class="card">
                    <div class="card-block">

                        <div class="col-12 m-1" style="text-align:center">
                            <h2>___ welcome! ___</h2><h4>thank you for subscribing.</h4>
                            remember: reply STOP at anytime to totally opt-out.
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <?php
    }
}