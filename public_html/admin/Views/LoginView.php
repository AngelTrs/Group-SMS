<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 1/28/2019
 * Time: 6:02 PM
 */
namespace Views;

class LoginView extends AdminView
{
    public function __construct()
    {

    }

    public function render() {

?>
        <!-- HEADER ROW -->
    <div class="row align-items-center">
        <div class="col-md-9">
            <h1>administration</h1>
        </div>
    </div>
    <!-- END HEADER ROW -->



        <div class="row align-items-center mt-3">
        <div class="col-12 col-sm-8 col-lg-4">

            <?php
            $this->displayAlerts();
            ?>

            <div class="card">
                <div class="card-block">

                    <form method="post" action="/admin/login">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Password">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary offset-1 col-10">login</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
<?php
    }
}