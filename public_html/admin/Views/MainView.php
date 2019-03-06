<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 1/28/2019
 * Time: 6:05 PM
 */
namespace Views;


class MainView extends AdminView
{
    public $mMessages;

    public function __construct()
    {
    }

    public function setMessages($messages)
    {
        $this->mMessages = $messages;
    }

    public function render() {
?>
    <!-- HEADER ROW -->
    <div class="row align-items-center">
        <div class="col-8 col-md-11">
            <h1 class="hidden-xs-down">administration</h1>
        </div>


        <?php include 'layout_nav.php'; ?>
    </div>
    <!-- END HEADER ROW -->

    <div class="row align-items-center mt-3">
        <div class="col-12 col-md-6">

            <?php $this::displayAlerts()  ?>

            <div class="card">
                <div class="card-header" style="background-col-smor:#FFFFE0;">
                    compose
                </div>
                <div class="card-block">
                    <form role="form" method="post" action="/admin/messages/preview">

                        <div class="form-group col-12 col-sm-6">
                            <label class="form-control-label" for="recipients">recipients</label>
                            <select size="0" class="form-control" name="recipients">
                                <option value="admin">admins only</option>
                                <option value="all">all subscribers</option>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label class="form-control-label" for="messageBody">message</label>
                            <textarea required onkeyup="countChar(this)" class="form-control" style="resize:none"
                                      id="messageBody" name="messageBody" rows="6"></textarea>
                        </div>
                        <div class="form-group col-12">
                            <p class="mb-0">character count: <span id="charNum">0</span></p>
                        </div>


                        <!--<button type="submit" class="btn btn-primary" name="action" value="save">save draft</button>-->
                        <button type="submit" class="btn btn-primary offset-1 col-10" name="action" value="submit">
                            proceed
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-xs-12 col-md-6">

            <div class="card">
                <div class="card-header" style="background-col-smor:#FFFFE0;">
                    incoming: <?php echo TWILIO['fromNumber']; ?>
                </div>
                <div class="card-block">
                    <iframe id="incoming_frame" src="Modules/incoming_viewer.php" style="border:none; width:100%"
                            height="360px"></iframe>
                </div>
            </div>

        </div>


    </div>

    <div class="row mt-5">
        <div class="col-9 col-md-11">
            <h1 class="hidden-xs-down">push feed</h1>
            <h3 class="hidden-sm-up">feed</h3>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-sm-12">

            <table class="table table-sm">
                <thead>
                <tr>
                    <th style="width:50px">id</th>
                    <th class="">sent to</th>
                    <th class="">message body</th>
                    <th class="">date</th>
                    <th class="">sent/success</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($this->mMessages as $message)
                { ?>

                    <tr>
                        <td scope="row"><?php echo $message["id"]; ?></td>
                        <td><?php echo $message["recGroup"]; ?></td>
                        <td><?php echo $message["body"]; ?></td>
                        <td><?php echo $message["dateSent"]; ?></td>
                        <td><?php echo $message["numSent"] ."/". $message["numSuccess"]; ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>


        </div>
    </div>

    <script>
        function countChar(val) {
            var len = val.value.length;
            $('#charNum').text(len);
        };
    </script>

    <script>
        document.getElementById("incoming_frame").contentWindow.scrollTo(0, document.getElementById("incoming_frame").contentWindow.document.body.scrollHeight)
    </script>


<?php
    }

}