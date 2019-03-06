<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 12/19/2018
 * Time: 10:26 PM
 */
namespace client\Views;

class HomeView extends ClientView
{
    public function __construct()
    {

    }

    public function render() { ?>


        <form method="post" action="/subscribe/post" class="form">

            <div class="row">
                <div class="offset-sm-2 offset-lg-3 offset-xl-4 col-sm-8 col-lg-6 col-xl-4 mt-3">

                    <?php
                    $this->displayErrors();
                    ?>

                    <div class="card">
                        <div class="card-block">

                            <div class="row">
                                <label class="sr offset-lg-1 col-lg-2" for="email">email</label>
                                <div class="col-lg-8">
                                    <input required type="email" class="form-control" id="email" name="email"
                                           placeholder="chick-fil-a@email.com">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="offset-lg-1 col-lg-5">

                                    <label class="sr" for="firstName">first name</label>
                                    <input required type="text" class="form-control" id="firstName" name="firstName"
                                           placeholder="">
                                </div>

                                <div class="col-lg-5">
                                    <label class="sr" for="lastName">last name</label>
                                    <input required type="text" class="form-control" id="lastName" name="lastName"
                                           placeholder="">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="offset-lg-1 col-lg-5">
                                    <label class="sr" for="mobileNumber">mobile #</label>
                                    <input minlength="12" maxlength="12" required type="text"
                                           class="form-control bfh-phone col-12" data-format="ddd-ddd-dddd"
                                           id="mobileNumber" name="mobileNumber" placeholder="555-555-5555">
                                </div>

                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="sr" for="zipCode">zip code</label>
                                        <input type="text" minlength="5" maxlength="5" required class="form-control"
                                               id="zipCode" name="zipCode" placeholder="">
                                    </div>
                                </div>

                            </div>

                            <div class="mt-1 cus-singlespaced text-center">msg & data rates may apply. We respect your
                                privacy and do not tolerate spam and will never sell, rent, lease or give away your
                                information. Reply STOP at anytime to totally opt-out of all further text msgs from
                                BLEECK.
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            <!-- btm submit section -->
            <div class="row">
                <div class="offset-sm-3 offset-lg-4 col-sm-8 col-lg-6 col-xl-4 my-3" align="center">
                    <button type="submit" name="submit" value="subscribe" class="btn btn-secondary col-8">
                        <span>subscribe</span></button>

        </div>
        <div class="offset-lg-1 offset-xl-2 col-lg-2 hidden-md-down" style="text-align:right;">
            <a href="/about"><h1><span style="color:#FFFFFF;"><strong>what is<br><?php echo APP_TITLE; ?>?</strong></span></h1></a>

        </div>
        </div>
        </form>
        <!-- ./btm submit section -->

<?php
    }
}