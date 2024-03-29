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

                    <label  class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                    <input type="text" value="" placeholder="" name="code_title" class="form-control" required="">

                    <label  class="required"><?php echo _TABLEFIELDCOUPON; ?></label>
                    <input type="text" value="" placeholder="" name="code_coupon" class="form-control" required="">

                    <label  class="required"><?php echo _TABLEFIELDDISCOUNT; ?></label>
                    <input type="number" value="" placeholder="" name="code_discount" class="form-control" required="">
                    <small class="form-text text-muted"><?php echo _TABLEFIELDDISCOUNTTIP; ?></small>

                    <label  class="required"><?php echo _TABLEFIELDQUANTITY; ?></label>
                    <input type="number" value="" placeholder="" name="code_quantity" class="form-control" required="">
                    <small class="form-text text-muted"><?php echo _TABLEFIELDQUANTITYTIP; ?></small>

                    <label><?php echo _TABLEFIELDSTATUS; ?></label>
                    <select class="custom-select form-control" name="code_status">
                    <option value="1" selected=""><?php echo _ENABLED; ?></option>
                  <option value="0"><?php echo _DISABLED; ?></option>
                </select>

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
