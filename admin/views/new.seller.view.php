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

                    <label><?php echo _TABLEFIELDUSEREMAIL; ?></label>
                    <select class="selectDrop form-control" name="seller_user">
                      <?php foreach($users as $item): ?>
                      <option value="<?php echo echoOutput($item['user_id']); ?>">ID <?php echo echoOutput($item['user_id']); ?> <?php echo echoOutput($item['user_email']); ?></option>
                      <?php endforeach; ?>
                    </select>

                      <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                      <input type="text" placeholder="" name="seller_title" class="form-control" required="">

                      <label class="required"><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                      <textarea type="text" class="mceNoEditor form-control" name="seller_description" required=""></textarea>

                      <label><?php echo _TABLEFIELDCOVER; ?></label>
                      <span class="text-danger recomendedsize display-block"><?php echo _RECOMMENDEDSIZE; ?> <b>1024 x 500</b> </span>

                    </div>
                  </div>
                  <div class="form-group col-12 col-lg-3 sidebar">

               <div class="block col-md-12">
                 <label><?php echo _TABLEFIELDSTATUS; ?></label>

                 <select class="custom-select form-control" name="seller_status">
                  <option value="1" selected=""><?php echo _ENABLED; ?></option>
                  <option value="0"><?php echo _DISABLED; ?></option>
                </select>

              </div>

                    <div class="block col-md-12">
                      <label><?php echo _TABLEFIELDIMAGE; ?></label>

                      <div class="new-image" id="image-preview">
                        <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
                        <input type="file" name="seller_logo" accept=".jpg, .jpeg, .png, .gif" id="image-upload"/>
                      </div>

                      <span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>350 x 350</b> </span>
                      <br/>
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
