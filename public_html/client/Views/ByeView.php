<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 12/20/2018
 * Time: 9:59 AM
 */
namespace client\Views;


class ByeView extends ClientView
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
                            <h2>___ we're sad to see you go ___</h2><h4>but we're glad that you came.</h4>you're officially
                            unsubscribed from all future communication.</h4>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <?php
    }
}