<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 1/28/2019
 * Time: 6:05 PM
 */
namespace Views;


class SubscriberEditView extends AdminView
{

    private $mSubscriber;

    public function __construct()
    {

    }

    /**
     * @param mixed $mSubscriber
     */
    public function setSubscriber($sub)
    {
        $this->mSubscriber = $sub;
    }

    public function render() {
?>
    <!-- HEADER ROW -->
    <div class="row align-items-center">
        <div class="col-8 col-md-11">
            <h1 class="hidden-xs-down">subscribers</h1>
            <h3 class="hidden-sm-up">edit</h3>
        </div>

        <?php include 'layout_nav.php'; ?>
    </div>
    <!-- END HEADER ROW -->

        <form class="form-inline input-group-sm mt-4" style="background-color:#FFFFE0; align:center" method="post"
              action="/admin/subscribers/edit/<?php echo $this->mSubscriber->getId(); ?>/post">

            <label required class="sr-only" for="firstName">First Name</label>
            <input type="text" class="form-control m-1" id="firstName" name="firstName"
                   value="<?php echo $this->mSubscriber->getFirstName(); ?>">

            <label class="sr-only" for="lastName">Last Name</label>
            <input required type="text" class="form-control m-1" id="lastName" name="lastName"
                   value="<?php echo $this->mSubscriber->getLastName(); ?>">

            <label class="sr-only" for="mobileNumber">Mobile #</label>
            <input required type="text" class="form-control m-1 bfh-phone" data-format="ddd-ddd-dddd" id="mobileNumber"
                   name="mobileNumber" value="<?php echo $this->mSubscriber->getMobileNumber(); ?>" size="11" minlength="12" maxlength="12">

            <label class="sr-only" for="email">Email</label>
            <input required type="email" class="form-control m-1" id="email" name="email" value="<?php echo $this->mSubscriber->getEmail(); ?>"
                   size="25">

            <label class="sr-only" for="zipCode">Zip Code</label>
            <input type="text" class="form-control m-1" id="zipCode" name="zipCode" value="<?php echo $this->mSubscriber->getZipCode(); ?>"
                   minlength="5" maxlength="5" size="6">

            <button name="submit" type="submit" class="btn btn-primary btn-sm">save</button>

            <a class="btn btn-cancel btn-sm" href="/admin/subscribers" role="button">cancel</a>

        </form>
<?php
    }
}