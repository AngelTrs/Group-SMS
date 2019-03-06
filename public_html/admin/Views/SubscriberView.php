<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 1/28/2019
 * Time: 6:05 PM
 */
namespace Views;


class SubscriberView extends AdminView
{
    private $mSubscribers;

    public function __construct()
    {

    }

    public function setSubscribers($subscribers)
    {
        $this->mSubscribers = $subscribers;
    }


    public function render() {
?>
    <!-- HEADER ROW -->
    <div class="row align-items-center">
        <div class="col-8 col-md-11">
            <h1 class="hidden-xs-down">subscribers</h1>
            <h3 class="hidden-sm-up">view all</h3>
        </div>

        <?php include 'layout_nav.php'; ?>
    </div>
    <!-- END HEADER ROW -->

        <?php $this::displayAlerts()  ?>

        <form class="form-inline input-group-sm mt-3 hidden-md-down" style="background-color:#FFFFE0; align:center"
              method="post" action="/admin/subscribers/add/post">

            <label class="sr-only" for="firstName">First Name</label>
            <input required type="text" class="form-control m-1" id="firstName" name="firstName" placeholder="First Name">

            <label class="sr-only" for="lastName">Last Name</label>
            <input required type="text" class="form-control m-1" id="lastName" name="lastName" placeholder="Last Name">

            <label class="sr-only" for="mobileNumber">Mobile #</label>
            <input required type="text" class="form-control m-1 bfh-phone" data-format="ddd-ddd-dddd" id="mobileNumber"
                   name="mobileNumber" placeholder="555-555-5555" size="12" minlength="12" maxlength="12">

            <label class="sr-only" for="email">Email</label>
            <input required type="email" class="form-control m-1" id="email" name="email" placeholder="Email">

            <label class="sr-only" for="zipCode">Zip Code</label>
            <input required type="text" class="form-control m-1" id="zipCode" name="zipCode" placeholder="Zip Code"
                   minlength="5" maxlength="5" size="7">

            <button name="submit" type="submit" class="btn btn-primary btn-sm">quick add</button>
        </form>


        <div class="row mt-2">
            <div class="col-12">

                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Mobile #</th>
                        <th>Email</th>
                        <th>Zip</th>
                        <th>Date Joined:</th>
                        <th class="hidden-md-down">edit</th>
                        <th>
                            unsubscribe
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($this->mSubscribers as $subscriber)
                    { ?>

                            <tr>
                                <th scope="row"><?php echo $subscriber["id"]; ?></th>
                                <td><?php echo $subscriber["firstName"]; ?></td>
                                <td><?php echo $subscriber["lastName"]; ?></td>
                                <td><?php echo $subscriber["mobileNumber"]; ?></td>
                                <td><?php echo $subscriber["email"]; ?></td>
                                <td><?php echo $subscriber["zipCode"]; ?></td>
                                <td><?php echo $subscriber["dateJoin"]; ?></td>
                                <td class="hidden-md-down"><a href="/admin/subscribers/edit/<?php echo $subscriber["id"]; ?>"><i
                                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                </td>
                                <td>
                                    <a name="unsub" href="#" data-toggle="modal" data-target="#myModal"
                                       data-name="<?php echo $subscriber["firstName"] . " " . $subscriber["lastName"]; ?>"
                                       data-id="<?php echo $subscriber["id"]; ?>"><i class="fa fa-ban"
                                                                                aria-hidden="true"></i></a>
                                </td>
                            </tr>

                            <?php
                        }
                    ?>

                    </tbody>
                </table>


                <!-- Button trigger modal
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-unsubid="1" data-unsubname="Darian">
                  Launch demo modal
                </button>-->

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">> unsubscribe</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <form method="post" id="unsub_form_link" action="#">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                                    <button name="submit" type="submit" class="btn btn-primary">proceed</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content here -->
            </div>
        </div>





<?php
    }
}