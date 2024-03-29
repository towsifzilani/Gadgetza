<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<!--Page Container--> 
<section class="page-container">
  <div class="page-content-wrapper">

    <!--Main Content-->

    <div class="content sm-gutter">
      <div class="container-fluid padding-25 sm-padding-10">

        <div class="section-title">
              <h4><?php echo _PROFILE; ?></h4>
        </div>

        <div class="row">

          <div class="col-md-12">
            <div class="block form-block mb-4">

            <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-row">

                  <div class="form-group col-md-12">

                   <input type="hidden" value="<?php echo $userDetails['user_id']; ?>" name="user_id">
                   
                   <label class="required"><?php echo _TABLEFIELDUSERNAME; ?></label>
                   <input type="text" value="<?php echo $userDetails['user_name']; ?>" name="user_name" class="form-control" required="">

                   <br/>

                   <label class="required"><?php echo _TABLEFIELDUSEREMAIL; ?></label>
                   <input type="text" value="<?php echo $userDetails['user_email']; ?>" name="user_email" class="form-control" required="">

                   <br/>

                   <label><?php echo _TABLEFIELDPASSWORD; ?></label>
                   <input type="hidden" value="<?php echo $userDetails['user_password']; ?>" name="user_password_save">
                   <input type="password" value="" placeholder="" name="user_password" class="form-control" id="password-field">
                   <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>

                   <br/>

                    <label><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                    <textarea type="text" class="mceNoEditor form-control" name="user_description"><?php echo $userDetails['user_description']; ?></textarea>

                    <br/>
                    <br/>
            <p><b><?php echo _TABLEFIELDDATEREGISTER; ?> </b> <?php echo FormatDate($userDetails['user_created']); ?></p>

            <hr>

            <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
            <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_user.php?id=<?php echo $userDetails['user_id']; ?>" data-redirect="../controller/users.php"><?php echo _DELETEITEM; ?></button>

            </div>
            </form>

            </div>
          </div>
        </div>

      </div>

     </div>
   </div>
 </div>
</div>
</section>
<?php require 'footer.php'; ?>
