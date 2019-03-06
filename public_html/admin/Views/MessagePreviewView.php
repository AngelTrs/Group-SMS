<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 1/28/2019
 * Time: 6:05 PM
 */

namespace Views;

class MessagePreviewView extends AdminView
{
    private $mMessage;

    public function __construct()
    {

    }

    public function setMessage($message)
    {
        $this->mMessage = $message;
    }

    public function render()
    {
        ?>
        <!-- HEADER ROW -->
        <div class="row align-items-center">
            <div class="col-8 col-md-11">
                <h1 class="hidden-xs-down">message</h1>
                <h3 class="hidden-sm-up">preview</h3>
            </div>

            <?php include 'layout_nav.php'; ?>
        </div>
        <!-- END HEADER ROW -->

        <div class="row align-items-center mt-3">
            <div class="col-12 col-md-6">

                <div class="card">
                    <div class="card-header" style="background-color:#FFFFE0;">
                        <strong>changes?</strong> or proceed to send push.
                    </div>
                    <div class="card-block">
                        <form role="form" method="post" action="/admin/messages/post">
                            <div class="form-group col-8">
                                <label class="form-control-label" for="form-group-input">recipients</label>
                                <blockquote class="blockquote">
                                    <p class="mb-0"><?php echo $this->mMessage['recipients']; ?></p>
                                    <input hidden name="recipients" id="recipients"
                                           value="<?php echo $this->mMessage['recipients']; ?>">
                                </blockquote>
                            </div>
                            <div class="form-group col-12">
                                <label class="form-control-label" for="form-group-input">message</label>
                                <blockquote class="blockquote">
                                    <p class="mb-0"><?php echo $this->mMessage['body']; ?></p>
                                    <textarea name="messageBody"
                                              style="display:none;"><?php echo $this->mMessage['body']; ?></textarea>
                                </blockquote>
                            </div>
                            <div class="form-group col-12">
                                <p class="mb-0">message characters: <?php echo $this->mMessage['characters']; ?></p>
                                <p class="mb-0">message segments: <?php echo $this->mMessage['segments']; ?></p>
                            </div>

                            <a class="btn btn-danger" href="/admin/messages" role="button">cancel</a>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#msgModal">
                                edit
                            </button>
                            <button type="submit" class="btn btn-success" name="submit" value="submit">send alert
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <form role="form" method="POST" action="/admin/messages/preview">

        <div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="msgModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">> edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                            <div class="form-group col-lg-8">
                                <label class="form-control-label" for="recipients">recipients</label>
                                <select size="0" class="form-control" name="recipients">
                                    <option value="admin" <?php if ($this->mMessage['recipients'] == "admin") if ($this->mMessage['recipients'] == "admin") echo "selected"; ?>>
                                        admins only
                                    </option>
                                    <option value="all" <?php if ($this->mMessage['recipients'] == "all") echo "selected"; ?>>
                                        all
                                        subscribers
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="form-control-label" for="messageBody">message</label>
                                <textarea required class="form-control" style="resize:none" id="messageBody"
                                          name="messageBody" rows="6"><?php echo $this->mMessage['body']; ?></textarea>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                        <button type="submit" class="btn btn-primary" name="submit" value="submit">submit changes
                        </button>
                    </div>

                </div>
            </div>
        </div>
        </form>
        <?php
    }
}