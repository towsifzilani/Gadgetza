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

                      <input type="hidden" value="<?php echo $userInfo['user_id']; ?>" name="coupon_author">

                      <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                      <input type="text" placeholder="" name="coupon_title" class="form-control" required="">

                      <label><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                      <textarea type="text" class="form-control" name="coupon_description"></textarea>

                      <label><?php echo _TABLEFIELDTAGLINE; ?></label>
                      <input type="text" placeholder="" name="coupon_tagline" class="form-control">

                     <div class="row">

                      <div class="col-4">
                        <label class="required"><?php echo _TABLEFIELDCATEGORY; ?></label>
                        <select class="custom-select form-control" name="coupon_category" id="categories-dropdown" required="">
                            <option value="" selected>---</option>
                          <?php foreach($categories as $item): ?>
                            <option value="<?php echo $item['category_id']; ?>"><?php echo $item['category_title']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                      <div class="col-4">
                        <label><?php echo _TABLEFIELDSUBCATEGORY; ?></label>
                        <select class="custom-select form-control" name="coupon_subcategory" id="subcategories-dropdown">
                            <option value="" selected>---</option>
                        </select>
                      </div>

                      <div class="col-4">
                      <label><?php echo _TABLEFIELDSTORE; ?></label>
                      <select class="custom-select form-control" name="coupon_store">
                            <option value="" selected>---</option>
                      <?php foreach($stores as $item): ?>
                            <option value="<?php echo $item['store_id']; ?>"><?php echo $item['store_title']; ?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>

                    </div>

                     <div class="row">

                     <div class="col-4">
                      <label class="required"><?php echo _TABLEFIELDCOUPONCODE; ?></label>
                      <input class="form-control" name="coupon_code" type="text" required="">
                    </div>

                      <div class="col-4">
                        <label><?php echo _TABLEFIELDSTART; ?></label>
                        <div class="input-group">
                            <span class="input-group-addon text-primary"><i class="dripicons-calendar"></i></span>
                            <input class="form-control" name="coupon_start" type="text" id="start-date">
                        </div>
                      </div>

                      <div class="col-4">
                        <label><?php echo _TABLEFIELDEXPIRE; ?></label>
                        <div class="input-group">
                            <span class="input-group-addon text-primary"><i class="dripicons-calendar"></i></span>
                            <input class="form-control" name="coupon_expire" type="text" id="end-date">
                            <a class="input-group-addon text-danger clearexpiry"><i class="dripicons-cross"></i></a>
                        </div>
                      </div>

                    </div>

                   <label class="required"><?php echo _TABLEFIELDURLLINK; ?></label>
                   <input type="text" placeholder="" name="coupon_link" class="form-control" required="">

                   <div class="row">

                    <div class="col-4">
                      <label class="control-label"><?php echo _TABLEFIELDFEATURED; ?></label>
                      <select class="custom-select form-control" name="coupon_featured">
                        <option value="0"><?php echo _NOTEXT; ?></option>
                        <option value="1"><?php echo _YESTEXT; ?></option>
                      </select>
                    </div>

                    <div class="col-4">
                      <label class="control-label"><?php echo _TABLEFIELDVERIFY; ?></label>
                      <select class="custom-select form-control" name="coupon_verified">
                        <option value="0"><?php echo _NOTEXT; ?></option>
                        <option value="1"><?php echo _YESTEXT; ?></option>
                      </select>
                    </div>

                    <div class="col-4">
                      <label class="control-label"><?php echo _TABLEFIELDEXCLUSIVE; ?></label>
                      <select class="custom-select form-control" name="coupon_exclusive">
                        <option value="0"><?php echo _NOTEXT; ?></option>
                        <option value="1"><?php echo _YESTEXT; ?></option>
                      </select>
                    </div>

                    <!--<div class="col-4">
                      <label class="control-label"><?php echo _TABLEFIELDSPONSORED; ?></label>
                      <select class="custom-select form-control" name="coupon_sponsored">
                        <option value="0"><?php echo _NOTEXT; ?></option>
                        <option value="1"><?php echo _YESTEXT; ?></option>
                      </select>
                    </div>-->

                  </div>

                   <br>
                   <br>

                   <fieldset>
                    <legend><?php echo _SEO; ?></legend>

                    <label class="no-margin-top"><?php echo _SEOTITLE; ?></label>
                    <input type="text" placeholder="" name="coupon_seotitle" class="form-control">


                    <label><?php echo _SEODESCRIPTION; ?></label>
                    <textarea type="text" class="mceNoEditor form-control" name="coupon_seodescription"></textarea>

                  </fieldset>

                </div>
              </div>
              <div class="form-group col-12 col-lg-3 sidebar">

               <div class="block col-md-12">
                 <label><?php echo _TABLEFIELDSTATUS; ?></label>
                 <select class="custom-select form-control" name="coupon_status">
                  <option value="1" selected=""><?php echo _ENABLED; ?></option>
                  <option value="2"><?php echo _DISABLED; ?></option>
                  <option value="3"><?php echo _PENDING; ?></option>
                  <option value="4"><?php echo _REJECTED; ?></option>
                  <option value="5"><?php echo _HIDDEN; ?></option>
                </select>
              </div>

              <div class="block col-md-12">
                <label class="required"><?php echo _TABLEFIELDIMAGE; ?></label>

                <div class="new-image" id="image-preview">
                  <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
                  <input type="file" name="coupon_image" accept=".jpg, .jpeg, .png, .gif" id="image-upload" />
                </div>

                <span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>650 x 350</b> </span>
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
