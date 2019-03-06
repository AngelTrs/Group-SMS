<div class="row row-footer justify-content-md-center hidden-xs-down">
    <div class="col-lg-6 push-lg-6 text-center text-lg-right" style="background-color:#FFFFFF; color:#000000;">
        <a href="/home">home ___</a> | <a href="/about">about ___</a> | <a href="/unsubscribe">unsubscribe
            ___</a> | <a href="#" data-toggle="modal" data-target="#exampleModal">contact ___</a>
    </div>
    <div class="col-lg-6 pull-lg-6 text-center text-lg-left" style="background-color:#FFFFFF; color:#000000; text-transform: lowercase;">
    <?php echo FOOTER_TEXT; ?>
    </div>

</div>


<div class="row row-footer justify-content-md-center hidden-sm-up">
    <div class="col-lg-6 push-lg-6 text-center text-lg-right" style="background-color:#FFFFFF; color:#000000;">
        <a href="/home">home</a> | <a href="/about">about</a> | <a href="/unsubscribe">unsubscribe</a> |
        <a href="#" data-toggle="modal" data-target="#exampleModal">contact</a>
    </div>
    <div class="col-lg-6 pull-lg-6 text-center text-lg-left" style="background-color:#FFFFFF; color:#000000; text-transform: lowercase;">
        <?php echo FOOTER_TEXT; ?>
    </div>

</div>

<!-- contact modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">___ contact ></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFFFFF">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php echo CONTACT_TEXT; ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><span><strong>close</strong></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ./ contact modal -->

<!--
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">___ contact > send message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFFFFF">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="form-control-label">name</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="form-control-label">email</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="form-control-label">regarding</label>
            <select class="form-control">
  <option selected>help</option>
  <option value="1">business inquiry</option>
  <option value="2">other</option>
</select>
          </div>
          <div class="form-group">
            <label for="message-text" class="form-control-label">message</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><span><strong>close</strong></span></button>
        <button type="button" class="btn btn-outline-secondary"><span><strong>send message ___</strong></span></button>
      </div>
    </div>
  </div>
</div> -->
