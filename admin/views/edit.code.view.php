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

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $code['code_id']; ?>" method="post">
                <div class="form-row">

                  <div class="form-group col-md-12">

                   <input type="hidden" value="<?php echo $code['code_id']; ?>" name="code_id">
                   
                   <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                   <input type="text" value="<?php echo $code['code_title']; ?>" name="code_title" class="form-control" required="">

                   <label class="required"><?php echo _TABLEFIELDCOUPON; ?></label>
                   <input type="text" value="<?php echo $code['code_coupon']; ?>" name="code_coupon" class="form-control" required="">

                   <label class="required"><?php echo _TABLEFIELDDISCOUNT; ?></label>
                   <input type="text" value="<?php echo $code['code_discount']; ?>" name="code_discount" minlength="1" maxlength="99" class="form-control" required="">
                   <small class="form-text text-muted"><?php echo _TABLEFIELDDISCOUNTTIP; ?></small>

                   <label class="required"><?php echo _TABLEFIELDQUANTITY; ?></label>
                   <input type="text" value="<?php echo $code['code_quantity']; ?>" name="code_quantity" class="form-control" required="">
                   <small class="form-text text-muted"><?php echo _TABLEFIELDQUANTITYTIP; ?></small>

                   <label class="control-label"><?php echo _TABLEFIELDSTATUS; ?></label>

                   <select class="custom-select form-control" name="code_status">
                    <?php
                    if($code['code_status'] == 1){
                      echo '<option value="1" selected="selected">'._ACTIVE.'</option>';
                      echo '<option value="0">'._INACTIVE.'</option>';

                    } else{
                      echo '<option value="0" selected="selected">'._INACTIVE.'</option>';
                      echo '<option value="1">'._ACTIVE.'</option>';
                    }
                    ?>
                  </select>

                  <br/>
                  <br/>

                  <hr>

                  <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
                  <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_code.php?id=<?php echo $code['code_id']; ?>" data-redirect="../controller/codes.php"><?php echo _DELETEITEM; ?></button>

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
