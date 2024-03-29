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

            <div class="form-block mb-4">

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $category['category_id']; ?>" method="post">

               <input type="hidden" value="<?php echo $category['category_id']; ?>" name="category_id">

               <div class="form-row">
                <div class="form-group col-12 col-lg-9">
                  <div class="block col-md-12">

                    <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                    <input type="text" value="<?php echo $category['category_title']; ?>" name="category_title" class="form-control">

                    <label><?php echo _TABLEFIELDSLUG; ?></label>
                    <input type="hidden" value="<?php echo $category['category_slug']; ?>" name="category_slug_save">
                    <input type="text" placeholder="<?php echo $category['category_slug']; ?>" name="category_slug" class="form-control">
                    
                    <label><?php echo _TABLEFIELDDESCRIPTION; ?></label>

                    <textarea type="text" class="mceNoEditor form-control" name="category_description"><?php echo $category['category_description']; ?></textarea>

                    <label><?php echo _TABLEFIELDICON; ?>
                    <a href="https://tabler-icons.io/" target="_blank" class="text-muted text-capitalize">Select Icon <i class="dripicons-export"></i></a>
                    </label>
                    <input type="text" value="<?php echo $category['category_icon']; ?>" name="category_icon" class="form-control">


                    <label class="control-label"><?php echo _TABLEFIELDSHOWMENU; ?></label>
                    <select class="custom-select form-control" name="category_menu">
                      <?php
                      if($category['category_menu'] == 1)
                      {
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';

                      }
                      else {
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>

                    <label class="control-label"><?php echo _TABLEFIELDFEATURED; ?></label>
                    <select class="custom-select form-control" name="category_featured">
                      <?php
                      if($category['category_featured'] == 1)
                      {
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';

                      }
                      else {
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>
                    

                    <br>
                    <br>

                    <fieldset>
                      <legend><?php echo _SEO; ?></legend>

                      <label class="no-margin-top"><?php echo _SEOTITLE; ?></label>
                      <input type="text" value="<?php echo $category['category_seotitle']; ?>" name="category_seotitle" class="form-control">


                      <label><?php echo _SEODESCRIPTION; ?></label>
                      <textarea type="text" class="form-control" name="category_seodescription"><?php echo $category['category_seodescription']; ?></textarea>

                    </fieldset>

                  </div>
                </div>

                <div class="form-group col-12 col-lg-3 sidebar">

                 <div class="block col-md-12">
                   <label><?php echo _TABLEFIELDSTATUS; ?></label>

                   <select class="custom-select form-control" name="category_status">

                    <?php
                    if($category['category_status'] == 1){
                      echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                      echo '<option value="0">'._DISABLED.'</option>';

                    } else{
                      echo '<option value="0" selected="selected">'._DISABLED.'</option>';
                      echo '<option value="1">'._ENABLED.'</option>';
                    }
                    ?>
                  </select>

                </div>

                <div class="block col-md-12">
                  <label><?php echo _TABLEFIELDIMAGE; ?></label>

                  <div class="new-image" id="image-preview" style="background: url(<?php echo $target_dir; ?><?php echo $category['category_image'] ?>);">
                    <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
                    <input type="hidden" value="<?php echo $category['category_image']; ?>" name="category_image_save">
                    <input type="file" name="category_image" accept=".jpg, .jpeg, .png, .gif" id="image-upload" />
                  </div>

                  <span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>350 x 350</b> </span>
                  <br/>
                </div>

                <div class="block col-md-12">
                <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
                <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_category.php?id=<?php echo $category['category_id']; ?>" data-redirect="../controller/categories.php"><?php echo _DELETEITEM; ?></button>
                </div>

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

