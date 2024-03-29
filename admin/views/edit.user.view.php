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

          <div class="col-md-12">

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

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $usr['user_id']; ?>" method="post">
                <div class="form-row">

                  <div class="form-group col-md-12">

                   <input type="hidden" value="<?php echo $usr['user_id']; ?>" name="user_id">
                   
                   <label class="required"><?php echo _TABLEFIELDUSERNAME; ?></label>
                   <input type="text" value="<?php echo $usr['user_name']; ?>" name="user_name" autocomplete="off" class="form-control" required="">

                   <br/>

                   <label class="required"><?php echo _TABLEFIELDUSEREMAIL; ?></label>
                   <input type="text" value="<?php echo $usr['user_email']; ?>" name="user_email" autocomplete="off" class="form-control" required="">

                   <br/>

                   <label><?php echo _TABLEFIELDPASSWORD; ?></label>
                   <input type="hidden" value="<?php echo $usr['user_password']; ?>" name="user_password_save">
                   <input type="password" value="" placeholder="" name="user_password" autocomplete="off" class="form-control" id="password-field">
                   <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>

                   <br/>

                    <label><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                    <textarea type="text" class="mceNoEditor form-control" name="user_description"><?php echo $usr['user_description']; ?></textarea>

                   <br/>

                   <label class="control-label"><?php echo _TABLEFIELDSTATUS; ?></label>

                   <select class="custom-select form-control" name="user_status">
                    <?php
                    if($usr['user_status'] == 1){
                      echo '<option value="1" selected="selected">'._ACTIVE.'</option>';
                      echo '<option value="0">'._INACTIVE.'</option>';

                    } else{
                      echo '<option value="0" selected="selected">'._INACTIVE.'</option>';
                      echo '<option value="1">'._ACTIVE.'</option>';
                    }
                    ?>
                  </select>

                   <br/>

                    <label class="control-label"><?php echo _TABLEFIELDUSERROLE; ?></label>

                    <select class="custom-select form-control" name="user_role">

                      <?php foreach($roles as $role){
                        if($usr['user_role'] == $role['role_id']){

                          echo '<option value="'.$usr['user_role'].'" selected="selected">'.$role['role_title'].'</option>';
                        }else{
                          echo '<option value="'.$role['role_id'].'">'.$role['role_title'].'</option>';
                        }
                      }
                      ?>

                    </select>

                    <br>

                   <label class="control-label"><?php echo _TABLEFIELDVERIFIED; ?></label>

                   <select class="custom-select form-control" name="user_verified">
                    <?php
                    if($usr['user_verified'] == 1){
                      echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                      echo '<option value="0">'._NOTEXT.'</option>';

                    } else{
                      echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                      echo '<option value="1">'._YESTEXT.'</option>';
                    }
                    ?>
                  </select>

                  <label class="control-label"><?php echo _TABLEFIELDSELLER; ?></label>
                  <select class="custom-select form-control" name="user_pro">
                  <?php
                  if($usr['user_pro'] == 1){
                  echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                  echo '<option value="0">'._NOTEXT.'</option>';

                  } else{
                  echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                  echo '<option value="1">'._YESTEXT.'</option>';
                  }
                  ?>
                  </select>

                  <br/>
                  <br/>

                  <fieldset>
            
            <legend><?php echo _BILLINGINFO; ?></legend>

        <table class="display table s-table">

        <tr>  

            <td colspan="2">
              <label><?php echo _BILLINGFULLNAME; ?></label>
              <input class="form-control" value="<?php echo (!empty($usrBilling) ? $usrBilling->user_billing_name : null); ?>" name="user_billing_name" type="text">
            </td>

            <td>
              <label><?php echo _BILLINGCOMPANY; ?></label>
              <input class="form-control" value="<?php echo (!empty($usrBilling) ? $usrBilling->user_billing_company : null); ?>" name="user_billing_company" type="text">
            </td>

          </tr>

          <tr>  
            <td colspan="3">
              <label><?php echo _BILLINGADDRESS; ?></label>
              <input class="form-control" value="<?php echo (!empty($usrBilling) ? $usrBilling->user_billing_address : null); ?>" name="user_billing_address" type="text">
            </td>
          </tr>

          <tr>  
            <td>
              <label><?php echo _BILLINGCOUNTRY; ?></label>
              <select class="selectDrop form-control" name="user_billing_country">
              <?php foreach($countriesArray as $item => $value){
                        if((!empty($usrBilling) ? $usrBilling->user_billing_country : 0) == $item){
                          echo '<option value="'.$item.'" selected="selected">'.$value.'</option>';
                        }else{
                          echo '<option value="'.$item.'">'.$value.'</option>';
                        }
                      }
                      ?>
                </select>

            </td>
            <td>
              <label><?php echo _BILLINGCITY; ?></label>
              <input class="form-control" value="<?php echo (!empty($usrBilling) ? $usrBilling->user_billing_city : null); ?>" name="user_billing_city" type="text">
            </td>
            <td>
              <label><?php echo _BILLINGPOSTALCODE; ?></label>
              <input class="form-control" value="<?php echo (!empty($usrBilling) ? $usrBilling->user_billing_zip : null); ?>" name="user_billing_zip" type="text">
            </td>
          </tr>

          <tr>  
            <td colspan="2">
              <label><?php echo _BILLINGPHONE; ?></label>
              <input class="form-control" value="<?php echo (!empty($usrBilling) ? $usrBilling->user_billing_phone : null); ?>" name="user_billing_phone" type="text">
            </td>

            <td>
              <label><?php echo _BILLINGTAXID; ?></label>
              <input class="form-control" value="<?php echo (!empty($usrBilling) ? $usrBilling->user_billing_tax_id : null); ?>" name="user_billing_tax_id" type="text">
            </td>

          </tr>

        </table>

      </fieldset>

      <label><?php echo _TABLEFIELDAVATAR; ?></label>

<div class="new-image" id="image-preview" style="background: url(<?php echo $target_dir; ?><?php echo $usr['user_avatar'] ?>);">
  <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
  <input type="hidden" value="<?php echo $usr['user_avatar']; ?>" name="user_avatar_save">
  <input type="file" name="user_avatar" accept=".jpg, .jpeg, .png, .gif" id="image-upload" />
</div>

<span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>350 x 350</b> </span>


                  <hr>

                  <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
                  <button class="btn btn-danger deleteItem" type="button" data-msg="<?php echo _BYDELETINGTHEUSER; ?>" data-url="../controller/delete_user.php?id=<?php echo $usr['user_id']; ?>" data-redirect="../controller/users.php"><?php echo _DELETEITEM; ?></button>

                </div>


              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<?php require 'footer.php'; ?>
