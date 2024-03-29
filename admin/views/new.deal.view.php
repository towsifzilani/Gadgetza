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

                      <input type="hidden" value="<?php echo $userInfo['user_id']; ?>" name="deal_author">

                      <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                      <input type="text" placeholder="" name="deal_title" class="form-control" required="">

                      <label><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                      <textarea type="text" class="advancedtinymce form-control" name="deal_description"></textarea>

                      <label><?php echo _TABLEFIELDTAGLINE; ?></label>
                      <input type="text" placeholder="" name="deal_tagline" class="form-control">

                     <div class="row">

                      <div class="col-6">
                        <label class="required"><?php echo _TABLEFIELDCATEGORY; ?></label>
                        <select class="custom-select form-control" name="deal_category" id="categories-dropdown" required="">
                            <option value="-" selected>---</option>
                          <?php foreach($categories as $item): ?>
                            <option value="<?php echo $item['category_id']; ?>"><?php echo $item['category_title']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                      <div class="col-6">
                        <label><?php echo _TABLEFIELDSUBCATEGORY; ?></label>
                        <select class="custom-select form-control" name="deal_subcategory" id="subcategories-dropdown">
                            <option value="" selected>---</option>
                        </select>
                      </div>

                    </div>

                    <div class="row">

                    <div class="col-6">
                      <label><?php echo _TABLEFIELDSTORE; ?></label>
                      <select class="custom-select form-control" name="deal_store">
                            <option value="-" selected>---</option>
                      <?php foreach($stores as $item): ?>
                            <option value="<?php echo $item['store_id']; ?>"><?php echo $item['store_title']; ?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="col-6">
                      <label><?php echo _TABLEFIELDLOCATIONS; ?></label>
                      <select class="custom-select form-control" name="deal_location">
                            <option value="-" selected>---</option>
                      <?php foreach($locations as $item): ?>
                            <option value="<?php echo $item['location_id']; ?>"><?php echo $item['location_title']; ?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>

                    </div>

                     <div class="row">

                      <div class="col-3">
                        <label class="required"><?php echo _TABLEFIELDPRICE; ?></label>
                        <div class="input-group">
                            <span class="input-group-addon text-primary"><?php echo $siteSettings['st_currency'] ?></span>
                            <input class="form-control" name="deal_price" type="number" required="">
                        </div>
                      </div>

                      <div class="col-3">
                        <label><?php echo _TABLEFIELDOLDPRICE; ?></label>
                        <div class="input-group">
                            <span class="input-group-addon text-primary"><?php echo $siteSettings['st_currency'] ?></span>
                            <input class="form-control" name="deal_oldprice" type="number">
                        </div>
                      </div>

                      <div class="col-3">
                        <label><?php echo _TABLEFIELDSTART; ?></label>
                        <div class="input-group">
                            <span class="input-group-addon text-primary"><i class="dripicons-calendar"></i></span>
                            <input class="form-control" name="deal_start" type="text" id="start-date">
                        </div>
                      </div>

                      <div class="col-3">
                        <label><?php echo _TABLEFIELDEXPIRE; ?></label>
                        <div class="input-group">
                            <span class="input-group-addon text-primary"><i class="dripicons-calendar"></i></span>
                            <input class="form-control" name="deal_expire" type="text" id="end-date">
                            <a class="input-group-addon text-danger clearexpiry"><i class="dripicons-cross"></i></a>
                        </div>
                      </div>

                    </div>

                   <label class="required"><?php echo _TABLEFIELDURLLINK; ?></label>
                   <input type="text" placeholder="" name="deal_link" class="form-control" required="">

                   <label><?php echo _TABLEFIELDVIDEO; ?></label>
                   <input type="text" placeholder="" name="deal_video" class="form-control">

                   <label><?php echo _TABLEFIELDGIF; ?></label>
                   <input type="text" placeholder="" name="deal_gif" class="form-control">


                   <div class="row">

                    <div class="col-6">
                      <label class="control-label"><?php echo _TABLEFIELDFEATURED; ?></label>
                      <select class="custom-select form-control" name="deal_featured">
                        <option value="0"><?php echo _NOTEXT; ?></option>
                        <option value="1"><?php echo _YESTEXT; ?></option>
                      </select>
                    </div>

                    <div class="col-6">
                      <label class="control-label"><?php echo _TABLEFIELDEXCLUSIVE; ?></label>
                      <select class="custom-select form-control" name="deal_exclusive">
                        <option value="0"><?php echo _NOTEXT; ?></option>
                        <option value="1"><?php echo _YESTEXT; ?></option>
                      </select>
                    </div>

                    <!--<div class="col-4">
                      <label class="control-label"><?php echo _TABLEFIELDSPONSORED; ?></label>
                      <select class="custom-select form-control" name="deal_sponsored">
                        <option value="0"><?php echo _NOTEXT; ?></option>
                        <option value="1"><?php echo _YESTEXT; ?></option>
                      </select>
                    </div>-->

                  </div>

                  <label class="control-label"><?php echo _TABLEFIELDGALLERY; ?></label>
                  <input name="files" class="input-file" type="file">

                   <br>
                   <br>

                   <fieldset>
                    <legend><?php echo _SEO; ?></legend>

                    <label class="no-margin-top"><?php echo _SEOTITLE; ?></label>
                    <input type="text" placeholder="" name="deal_seotitle" class="form-control">


                    <label><?php echo _SEODESCRIPTION; ?></label>
                    <textarea type="text" class="mceNoEditor form-control" name="deal_seodescription"></textarea>

                  </fieldset>

                </div>
              </div>
              <div class="form-group col-12 col-lg-3 sidebar">

               <div class="block col-md-12">
                 <label><?php echo _TABLEFIELDSTATUS; ?></label>
                 <select class="custom-select form-control" name="deal_status">
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
                  <input type="file" name="deal_image" accept=".jpg, .jpeg, .png, .gif" id="image-upload" />
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
