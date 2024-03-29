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

                    <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                    <input type="text" value="" placeholder="" name="role_title" class="form-control" required="">

                    <label class="required"><?php echo _TABLEFIELDPERMISSIONS; ?></label>
                    
                    <div class="row">

                    <?php foreach($permissionsArray as $key => $item): ?>
                    <div class="col-md-6 col-12">
                    <fieldset style="margin-top: 10px;padding: 20px 15px">
                      <legend style="margin-bottom: -5px;"><?php echo $key; ?></legend>
                    <?php foreach($item as $val): ?>
                    <div class="pretty p-default p-round">
                      <input type="checkbox" value="<?php echo $val['value']; ?>" name="role_permissions[]" />
                      <div class="state p-success">
                          <label style="display: flex; letter-spacing: 0;"><?php echo $val['title']; ?></label>
                      </div>
                    </div>
                    <?php endforeach; ?>
                    </fieldset>
                    </div>
                    <?php endforeach; ?>

                    </div>

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
