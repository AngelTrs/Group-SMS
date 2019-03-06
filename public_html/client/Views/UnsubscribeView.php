<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 12/19/2018
 * Time: 10:26 PM
 */
namespace client\Views;

class UnsubscribeView extends ClientView
{
    public function __construct()
    {

    }

    public function render() { ?>


        <form method="post" action="/unsubscribe/post" class="form">

            <div class="row">
                <div class="offset-sm-2 offset-lg-5 offset-xl-5 col-sm-8 col-lg-4 col-xl-2 mt-3">

                    <?php
                    $this->displayErrors();
                    ?>

                    <div class="card">
                        <div class="card-block">
                                    <label class="sr" for="mobileNumber">mobile #</label><input minlength="12" maxlength="12" required type="text" class="form-control bfh-phone" data-format="ddd-ddd-dddd"
                                           id="mobileNumber" name="mobileNumber" placeholder="555-555-5555">
                        </div>

                    </div>
                </div>


            </div>

            <!-- btm submit section -->
            <div class="row">
                <div class="offset-sm-2 offset-lg-5 offset-xl-5 col-sm-8 col-lg-4 col-xl-2 mt-3" align="center">
                    <button type="submit" name="submit" value="subscribe" class="btn btn-secondary col-8">
                        <span>unsubscribe</span></button>
        </div>
        <div class="offset-lg-1 offset-xl-2 col-lg-2 hidden-md-down" style="text-align:right;">
            <a href="/about"><h1><span style="color:#FFFFFF;"><strong>what is<br><?php echo APP_TITLE; ?>?</strong></span></h1></a>

        </div>
        </div>
        <!-- ./btm submit section -->
        </form>

<?php
    }
}