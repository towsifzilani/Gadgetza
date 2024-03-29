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

            <div class="alert alert-warning" role="alert">
            <?php echo _TAXCANTBEEDITED; ?>
            </div>

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-row">

                  <div class="form-group col-md-12">

                    <label  class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                    <input type="text" value="" placeholder="" name="tax_title" class="form-control" required="">

                    <label  class="required"><?php echo _TABLEFIELDPERCENTAGE; ?></label>
                    <div class="input-group">
                            <input class="form-control" name="tax_percentage" type="number" required="">
                            <span class="input-group-addon text-primary">%</span>
                        </div>

                    <label  class="required"><?php echo _TABLEFIELDTAXTYPE; ?></label>
                    <select class="custom-select form-control" name="tax_type">
                    <option value="inclusive"><?php echo _INCLUSIVETAX; ?></option>
                    <option value="exclusive"><?php echo _EXCLUSIVETAX; ?></option>
                    </select>

                    <label><?php echo _TABLEFIELDCOUNTRIES; ?></label>
                    <select class="selectDrop form-control" name="tax_countries[]" multiple="">
                      <?php foreach($countriesArray as $item => $value): ?>
                      <option value="<?php echo $item; ?>"><?php echo $value; ?></option>
                      <?php endforeach; ?>
                    </select>

                    <small class="form-text text-muted"><?php echo _LEAVEEMPTYCOUNTRIES; ?></small>

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
