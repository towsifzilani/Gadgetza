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

            <div>
              <table>
                <tr>
                  <td><p><b><?php echo _AUTHORBY; ?> </b> <a class="link-primary" href="../controller/edit_user.php?id=<?php echo $coupon['coupon_author']; ?>"><?php echo $coupon['author_name']; ?></a></p></td>
                  <td><p><b><?php echo _PUBLISHED; ?> </b> <?php echo FormatDate($coupon['coupon_created']); ?></p></td>
                  <td><p><b><?php echo _UPDATED; ?> </b> <?php echo FormatDate($coupon['coupon_updated']); ?></p></td>
                  <td><p><b><?php echo _ITEMCLICKS; ?> </b> <a class="link-primary" href="../controller/stats.php?id=<?php echo $coupon['coupon_id']; ?>"><?php echo echoOutput($coupon['coupon_clicks']); ?></a></p></td>
                </tr>
              </table>
            </div>

            <div class="form-block mb-4">

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $coupon['coupon_id']; ?>" method="post">

               <input type="hidden" value="<?php echo $coupon['coupon_author']; ?>" name="coupon_author">
               <input type="hidden" value="<?php echo $coupon['coupon_id']; ?>" name="coupon_id">

               <div class="form-row">
                <div class="form-group col-12 col-lg-9">
                  <div class="block col-md-12">

                    <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                    <input type="text" value="<?php echo $coupon['coupon_title']; ?>" name="coupon_title" class="form-control" required="">

                    <label><?php echo _TABLEFIELDSLUG; ?></label>
                    <input type="hidden" value="<?php echo $coupon['coupon_slug']; ?>" name="coupon_slug_save">
                    <input type="text" placeholder="<?php echo $coupon['coupon_slug']; ?>" name="coupon_slug" class="form-control">
                    
                    <label><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                    <textarea type="text" class="form-control" name="coupon_description"><?php echo $coupon['coupon_description']; ?></textarea>

                    <label><?php echo _TABLEFIELDTAGLINE; ?></label>
                    <input type="text" value="<?php echo $coupon['coupon_tagline']; ?>" name="coupon_tagline" class="form-control">


                     <div class="row">

                      <div class="col-4">
                      <label class="required"><?php echo _TABLEFIELDCATEGORY; ?></label>
                        <select class="custom-select form-control" name="coupon_category" id="categories-dropdown" require="">
                        <option value="">---</option>
                          <?php
                          foreach($categories as $item){
                            if($coupon['coupon_category'] == $item['category_id'])
                            {
                              echo '<option value="'.$coupon['coupon_category'].'" selected="selected">'.$item['category_title'].'</option>';
                            }
                            else{
                              echo '<option value="'.$item['category_id'].'">'.$item['category_title'].'</option>';
                            }
                          }
                          ?>

                        </select>
                      </div>

                      <div class="col-4">
                        <label class="control-label"><?php echo _TABLEFIELDSUBCATEGORY; ?></label>
                        <select class="custom-select form-control" name="coupon_subcategory" id="subcategories-dropdown">
                        <option value="">---</option>
                        <?php
                          foreach($subcategories as $item){
                            if($coupon['coupon_subcategory'] == $item['subcategory_id'])
                            {
                              echo '<option value="'.$coupon['coupon_subcategory'].'" selected="selected">'.$item['subcategory_title'].'</option>';
                            }
                            else{
                              echo '<option value="'.$item['subcategory_id'].'">'.$item['subcategory_title'].'</option>';
                            }
                          }
                          ?>

                      </select>
                      </div>


                      <div class="col-4">
                      <label class="control-label"><?php echo _TABLEFIELDSTORE; ?></label>
                        <select class="custom-select form-control" name="coupon_store">
                        <option value="">---</option>
                        <?php
                          foreach($stores as $item){
                            if($coupon['coupon_store'] == $item['store_id']){
                              echo '<option value="'.$coupon['coupon_store'].'" selected="selected">'.$item['store_title'].'</option>';
                            }
                            else{
                              echo '<option value="'.$item['store_id'].'">'.$item['store_title'].'</option>';
                            }
                          }
                          ?>

                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-4">
                        <label class="control-label"><?php echo _TABLEFIELDCOUPONCODE; ?></label>
                        <input type="text" value="<?php echo $coupon['coupon_code']; ?>" name="coupon_code" class="form-control">
                      </div>
                      <div class="col-4">
                        <label><?php echo _TABLEFIELDSTART; ?></label>
                        <div class="input-group">
                            <span class="input-group-addon text-primary"><i class="dripicons-calendar"></i></span>
                            <input class="form-control" name="coupon_start" value="<?php echo $coupon['coupon_start']; ?>" type="text" id="saved-start-date">
                        </div>
                      </div>

                      <div class="col-3">
                        <label><?php echo _TABLEFIELDEXPIRE; ?></label>
                        <div class="input-group">
                            <span class="input-group-addon text-primary"><i class="dripicons-calendar"></i></span>
                            <input class="form-control" name="coupon_expire" value="<?php echo $coupon['coupon_expire']; ?>" type="text" id="saved-end-date">
                            <a class="input-group-addon text-danger clearexpiry"><i class="dripicons-cross"></i></a>
                        </div>
                      </div>

                    </div>

                    <label class="required"><?php echo _TABLEFIELDURLLINK; ?></label>
                    <input type="text" value="<?php echo $coupon['coupon_link']; ?>" name="coupon_link" class="form-control" required="">
                  
                    <div class="row">
                      <div class="col-4">
                        <label class="control-label"><?php echo _TABLEFIELDFEATURED; ?></label>
                        <select class="custom-select form-control" name="coupon_featured" required="">
                          <?php
                          if($coupon['coupon_featured'] == 1)
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
                      </div>

                      <div class="col-4">
                        <label class="control-label"><?php echo _TABLEFIELDVERIFY; ?></label>
                        <select class="custom-select form-control" name="coupon_verified" required="">
                          <?php
                          if($coupon['coupon_verified'] == 1)
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
                      </div>

                      <div class="col-4">

                        <label class="control-label"><?php echo _TABLEFIELDEXCLUSIVE; ?></label>

                        <select class="custom-select form-control" name="coupon_exclusive" required="">
                          <?php
                          if($coupon['coupon_exclusive'] == 1)
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
                      </div>

                    <!--<div class="col-4">

                    <label class="control-label"><?php echo _TABLEFIELDSPONSORED; ?></label>

                    <select class="custom-select form-control" name="coupon_sponsored" required="">
                      <?php
                      if($coupon['coupon_sponsored'] == 1){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';

                      }else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>
                    </div>-->

                    </div>

                    <br>
                    <br>

                    <fieldset>
                      <legend><?php echo _SEO; ?></legend>

                      <label class="no-margin-top"><?php echo _SEOTITLE; ?></label>
                      <input type="text" value="<?php echo $coupon['coupon_seotitle']; ?>" name="coupon_seotitle" class="form-control">


                      <label><?php echo _SEODESCRIPTION; ?></label>
                      <textarea type="text" class="form-control" name="coupon_seodescription"><?php echo $coupon['coupon_seodescription']; ?></textarea>

                    </fieldset>

                  </div>
                </div>

                <div class="form-group col-12 col-lg-3 sidebar">

                 <div class="block col-md-12">
                   <label><?php echo _TABLEFIELDSTATUS; ?></label>

                   <select class="custom-select form-control" name="coupon_status" required="">

                    <?php
                    if($coupon['coupon_status'] == 1){
                      echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                      echo '<option value="2">'._DISABLED.'</option>';
                      echo '<option value="3">'._PENDING.'</option>';
                      echo '<option value="4">'._REJECTED.'</option>';
                      echo '<option value="5">'._HIDDEN.'</option>';
                    }elseif($coupon['coupon_status'] == 2){
                      echo '<option value="2" selected="selected">'._DISABLED.'</option>';
                      echo '<option value="1">'._ENABLED.'</option>';
                      echo '<option value="3">'._PENDING.'</option>';
                      echo '<option value="4">'._REJECTED.'</option>';
                      echo '<option value="5">'._HIDDEN.'</option>';
                    }elseif($coupon['coupon_status'] == 3){
                      echo '<option value="3" selected="selected">'._PENDING.'</option>';
                      echo '<option value="1">'._ENABLED.'</option>';
                      echo '<option value="2">'._DISABLED.'</option>';
                      echo '<option value="4">'._REJECTED.'</option>';
                      echo '<option value="5">'._HIDDEN.'</option>';
                    }elseif($coupon['coupon_status'] == 4){
                      echo '<option value="1">'._ENABLED.'</option>';
                      echo '<option value="2">'._DISABLED.'</option>';
                      echo '<option value="3">'._PENDING.'</option>';
                      echo '<option value="4" selected="selected">'._REJECTED.'</option>';
                      echo '<option value="5">'._HIDDEN.'</option>';
                    }elseif($coupon['coupon_status'] == 5){
                      echo '<option value="1">'._ENABLED.'</option>';
                      echo '<option value="2">'._DISABLED.'</option>';
                      echo '<option value="3">'._PENDING.'</option>';
                      echo '<option value="4">'._REJECTED.'</option>';
                      echo '<option value="5" selected="selected">'._HIDDEN.'</option>';
                    }
                    ?>
                  </select>

                </div>

                <div class="block col-md-12">
                  <label><?php echo _TABLEFIELDIMAGE; ?></label>

                  <div class="new-image" id="image-preview" style="background: url(<?php echo $target_dir; ?><?php echo $coupon['coupon_image'] ?>);">
                    <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
                    <input type="hidden" value="<?php echo $coupon['coupon_image']; ?>" name="coupon_image_save">
                    <input type="file" name="coupon_image" accept=".jpg, .jpeg, .png, .gif" id="image-upload" />
                  </div>

                  <span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>650 x 350</b> </span>
                  <br/>
                </div>

                <div class="block col-md-12">
                  <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
                  <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_coupon.php?id=<?php echo $coupon['coupon_id']; ?>" data-redirect="../controller/coupons.php"><?php echo _DELETEITEM; ?></button>
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
