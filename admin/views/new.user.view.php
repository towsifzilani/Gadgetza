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
              <h5><?php echo _ADDITEM; ?></h5>
            </div>
          </div>

          <div class="col-md-12">

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

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-row">

                  <div class="form-group col-md-12">

                    <label class="required"><?php echo _TABLEFIELDUSERNAME; ?></label>
                    <input type="text" value="" placeholder="" name="user_name" class="form-control" required="">

                    <label class="required"><?php echo _TABLEFIELDUSEREMAIL; ?></label>
                    <input type="text" value="" placeholder="" name="user_email" class="form-control" required="">
                    <label id="email-availability-status"></label>

                    <label class="required"><?php echo _TABLEFIELDPASSWORD; ?></label>
                    <input type="password" value="" placeholder="" name="user_password" class="form-control" id="password-field" required="">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>

                    <label class="required"><?php echo _TABLEFIELDUSERROLE; ?></label>
                    <select class="custom-select form-control" name="user_role" required="">
                      <option value selected>-</option>
                      <?php foreach($roles as $role): ?>
                        <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_title']; ?></option>
                      <?php endforeach; ?>
                    </select>

                 <label><?php echo _TABLEFIELDVERIFIED; ?></label>
                 <select class="custom-select form-control" name="user_verified">
                  <option value selected>-</option>
                  <option value="1"><?php echo _YESTEXT; ?></option>
                  <option value="0"><?php echo _NOTEXT; ?></option>
                </select>

                <label><?php echo _TABLEFIELDSELLER; ?></label>
                 <select class="custom-select form-control" name="user_pro">
                  <option value selected>-</option>
                  <option value="1"><?php echo _YESTEXT; ?></option>
                  <option value="0"><?php echo _NOTEXT; ?></option>
                </select>

                <br>
                <br>

                <fieldset>
            
                <a data-toggle="collapse" href="#collapseExample" aria-controls="collapseExample"><legend class="m-0"><?php echo _BILLINGINFO; ?></legend></a>
            
            <div class="collapse" id="collapseExample">

            <table class="display table s-table">

            <tr>  

                <td colspan="2">
                  <label><?php echo _BILLINGFULLNAME; ?></label>
                  <input class="form-control" name="user_billing_name" type="text">
                </td>

                <td>
                  <label><?php echo _BILLINGCOMPANY; ?></label>
                  <input class="form-control" name="user_billing_company" type="text">
                </td>

              </tr>

              <tr>  
                <td colspan="3">
                  <label><?php echo _BILLINGADDRESS; ?></label>
                  <input class="form-control" name="user_billing_address" type="text">
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _BILLINGCOUNTRY; ?></label>
                  <select class="selectDrop form-control" name="user_billing_country">
                  <?php foreach($countriesArray as $item => $value): ?>
                      <option value="<?php echo $item; ?>"><?php echo $value; ?></option>
                      <?php endforeach; ?>
                    </select>

                </td>
                <td>
                  <label><?php echo _BILLINGCITY; ?></label>
                  <input class="form-control" name="user_billing_city" type="text">
                </td>
                <td>
                  <label><?php echo _BILLINGPOSTALCODE; ?></label>
                  <input class="form-control" name="user_billing_zip" type="text">
                </td>
              </tr>

              <tr>  
                <td colspan="2">
                  <label><?php echo _BILLINGPHONE; ?></label>
                  <input class="form-control" name="user_billing_phone" type="text">
                </td>

                <td>
                  <label><?php echo _BILLINGTAXID; ?></label>
                  <input class="form-control" name="user_billing_tax_id" type="text">
                </td>

              </tr>

            </table>

            </div>

          </fieldset>

                  </div>

                  <hr>

                  <button class="btn btn-primary" type="submit" name="save"><?php echo _SAVECHANGES; ?></button>

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
