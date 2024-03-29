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

            <div class="form-block mb-4">

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="form-row">
                  <div class="form-group col-12 col-lg-9">
                    <div class="block col-md-12">

                      <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                      <input type="text" placeholder="" name="subcategory_title" class="form-control" required="">

                      <label><?php echo _TABLEFIELDDESCRIPTION; ?></label>

                      <textarea type="text" class="mceNoEditor form-control" name="subcategory_description"></textarea>

                      <label class="required"><?php echo _TABLEFIELDPARENT; ?></label>
                      <select class="custom-select form-control" name="subcategory_parent" required="">
                        <option value="" selected>---</option>
                      <?php foreach($categories as $item): ?>
                            <option value="<?php echo $item['category_id']; ?>"><?php echo $item['category_title']; ?></option>
                          <?php endforeach; ?>
                      </select>

                      <br>
                      <br>

                      <fieldset>
                        <legend><?php echo _SEO; ?></legend>

                        <label class="no-margin-top"><?php echo _SEOTITLE; ?></label>
                        <input type="text" name="subcategory_seotitle" class="form-control">

                        <label><?php echo _SEODESCRIPTION; ?></label>
                        <textarea type="text" class="mceNoEditor form-control" name="subcategory_seodescription"></textarea>

                      </fieldset>

                    </div>
                  </div>
                  <div class="form-group col-12 col-lg-3 sidebar">

               <div class="block col-md-12">
                 <label><?php echo _TABLEFIELDSTATUS; ?></label>

                 <select class="custom-select form-control" name="subcategory_status">
                  <option value="1" selected=""><?php echo _ENABLED; ?></option>
                  <option value="0"><?php echo _DISABLED; ?></option>
                </select>

              </div>

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
