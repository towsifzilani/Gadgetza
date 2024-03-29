<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<!--Page Container--> 
<section class="page-container">
  <div class="page-content-wrapper">

    <!--Main Content-->

    <div class="content sm-gutter">
      <div class="container-fluid padding-25 sm-padding-10">
        <div class="row">
          <div class="col-12">
            <div class="section-title">
              <h5><?php echo _EDITITEM; ?></h5>
            </div>
          </div>

          <div class="col-md-8">

          <?php if(!empty($success)): ?>
          <div class="d-flex align-items-center alert alert-success" role="alert">
          <i class="icon dripicons-checkmark"></i> <?php echo $success; ?>
          </div>
          <?php endif; ?>

          <?php if(!empty($errors)): ?>
          <div class="alert alert-danger" role="alert">
          <ul>
          <?php foreach($errors as $key => $value):?>
          <li><?php echo $value; ?></li>
          <?php endforeach; ?>
          </ul>
          </div>
          <?php endif; ?>
            
            <div class="block form-block mb-4">

              <div class="form-row">

                <div class="form-group col-md-12">
                  <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $etemplate['email_id']; ?>" method="post">

                    <h6><?php echo $etemplate['email_title']; ?></h6>
                    <hr>

                   <input type="text" value="<?php echo $etemplate['email_id']; ?>" name="email_id" class="form-control" hidden>
                   
                   <label class="required"><?php echo _EMAILFROMNAME; ?></label>
                   <input type="text" value="<?php echo $etemplate['email_fromname']; ?>" id="email_fromname" name="email_fromname" class="form-control" required="">

                   <div class="row">
                    <div class="col-md-6">

                    <label class="required"><?php echo _SENDASPLAINTEXT; ?></label>

                    <select class="custom-select form-control" id="single-select" data-selected="<?php echo $etemplate['email_plaintext']; ?>" name="email_plaintext" required="">
                      <option value="true"><?php echo _YESTEXT; ?></option>
                      <option value="false"><?php echo _NOTEXT; ?></option>
                    </select>

                    </div>

                    <div class="col-md-6">

                    <label class="required"><?php echo _ITEMSTATUS; ?> <small><?php echo _EMAILDISABLE; ?></small></label>

                    <select class="custom-select form-control" id="single-select-2" data-selected="<?php echo $etemplate['email_disabled']; ?>" name="email_disabled" required="">
                      <option value="0"><?php echo _ENABLED; ?></option>
                      <option value="1"><?php echo _DISABLED; ?></option>
                    </select>
                    
                    </div>

                  </div>

                <label class="required"><?php echo _EMAILSUBJECT; ?></label><br>
                <input class="form-control" type="text" name="subject" value="<?php echo $contents[0]['subject']; ?>" required=""/>
                <label class="required"><?php echo _EMAILMESSAGE; ?></label><br>
                <textarea class="emailtinymce form-control" name="message" required=""><?php echo $contents[0]['message']; ?></textarea>
                 <br>
                 <br>
                 <button class="btn btn-primary" type="submit" name="save"><?php echo _SAVECHANGES; ?></button>

               </form>

             </div>

           </div>
         </div>
       </div>

       <div class="col-md-4 sidebar">

        <div class="block form-block" style="padding: 20px 22px;">

          <div class="form-group col-md-12 padding-left-0 padding-right-0">

            <label class="control-label"><?php echo _EMAILFIELDS; ?></label>

            <div class="table-responsive">
              <table class="display table">

              <?php foreach($emailFields as $item): ?>
                <?php if(in_array($etemplate['email_id'], $item['email_ids'])): ?>
                <tr>
                  <td class="padding-left-0"><?php echo $item['title']; ?></td>
                  <td><a href="#" class="add_field"><?php echo $item['tag']; ?></a></td>
                </tr>
                <?php endif; ?>
              <?php endforeach; ?>

              </table>
            </div>

          </div>
        </div>

        <div class="block form-block mb-5" style="padding: 20px 22px;padding-bottom: 8px;">

          <div class="form-group col-md-12 padding-left-0 padding-right-0" style="margin-bottom: 0;">
            <label class="control-label"><?php echo _EMAILSENDTEST; ?></label>

            <form id="test-email" method="post">
              <input type="hidden" id="idtemplate" value="<?php echo $etemplate['email_id']; ?>" class="form-control" required>
              <input type="email" placeholder="example@email.com" id="sendto" class="form-control" required>
              <small style="margin: 8px 0; display: block;"><?php echo _EMAILYOUMUSTSAVE; ?></small>
              <button class="btn btn-block btn-primary" id="submit-send" type="submit"><?php echo _EMAILSENDBUTTON; ?></button>
            </form>

              <div id="showresults" style="margin-top: 15px;margin-bottom: 10px;"></div>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</div>
</section>
<?php require 'footer.php'; ?>