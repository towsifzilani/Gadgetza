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
                  <td><p><b><?php echo _AUTHORBY; ?> </b> <a class="link-primary" href="../controller/edit_user.php?id=<?php echo $deal['deal_author']; ?>"><?php echo $deal['author_name']; ?></a></p></td>
                  <td><p><b><?php echo _PUBLISHED; ?> </b> <?php echo FormatDate($deal['deal_created']); ?></p></td>
                  <td><p><b><?php echo _UPDATED; ?> </b> <?php echo FormatDate($deal['deal_updated']); ?></p></td>
                  <td><p><b><?php echo _ITEMCLICKS; ?> </b> <a class="link-primary" href="../controller/stats.php?id=<?php echo $deal['deal_id']; ?>"><?php echo echoOutput($deal['deal_clicks']); ?></a></p></td>
                </tr>
              </table>
            </div>

            <div class="form-block mb-4">

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $deal['deal_id']; ?>" method="post">

               <input type="hidden" value="<?php echo $deal['deal_author']; ?>" name="deal_author">
               <input type="hidden" value="<?php echo $deal['deal_id']; ?>" name="deal_id">

               <div class="form-row">
                <div class="form-group col-12 col-lg-9">
                  <div class="block col-md-12">

                    <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                    <input type="text" value="<?php echo $deal['deal_title']; ?>" name="deal_title" class="form-control" required="">

                    <label><?php echo _TABLEFIELDSLUG; ?></label>
                    <input type="hidden" value="<?php echo $deal['deal_slug']; ?>" name="deal_slug_save">
                    <input type="text" placeholder="<?php echo $deal['deal_slug']; ?>" name="deal_slug" class="form-control">
                    
                    <label><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                    <textarea type="text" class="advancedtinymce form-control" name="deal_description"><?php echo $deal['deal_description']; ?></textarea>

                    <label><?php echo _TABLEFIELDTAGLINE; ?></label>
                    <input type="text" value="<?php echo $deal['deal_tagline']; ?>" name="deal_tagline" class="form-control">


                     <div class="row">

                      <div class="col-6">
                      <label class="required"><?php echo _TABLEFIELDCATEGORY; ?></label>
                        <select class="custom-select form-control" name="deal_category" id="categories-dropdown" require="">
                        <option value="">---</option>
                          <?php
                          foreach($categories as $item){
                            if($deal['deal_category'] == $item['category_id'])
                            {
                              echo '<option value="'.$deal['deal_category'].'" selected="selected">'.$item['category_title'].'</option>';
                            }
                            else{
                              echo '<option value="'.$item['category_id'].'">'.$item['category_title'].'</option>';
                            }
                          }
                          ?>

                        </select>
                      </div>

                      <div class="col-6">
                        <label class="control-label"><?php echo _TABLEFIELDSUBCATEGORY; ?></label>
                        <select class="custom-select form-control" name="deal_subcategory" id="subcategories-dropdown">
                        <option value="">---</option>
                        <?php
                          foreach($subcategories as $item){
                            if($deal['deal_subcategory'] == $item['subcategory_id'])
                            {
                              echo '<option value="'.$deal['deal_subcategory'].'" selected="selected">'.$item['subcategory_title'].'</option>';
                            }
                            else{
                              echo '<option value="'.$item['subcategory_id'].'">'.$item['subcategory_title'].'</option>';
                            }
                          }
                          ?>

                      </select>
                      </div>


                      <div class="col-6">
                      <label class="control-label"><?php echo _TABLEFIELDSTORE; ?></label>
                        <select class="custom-select form-control" name="deal_store">
                        <option value="">---</option>
                        <?php
                          foreach($stores as $item){
                            if($deal['deal_store'] == $item['store_id']){
                              echo '<option value="'.$deal['deal_store'].'" selected="selected">'.$item['store_title'].'</option>';
                            }
                            else{
                              echo '<option value="'.$item['store_id'].'">'.$item['store_title'].'</option>';
                            }
                          }
                          ?>

                        </select>
                      </div>

                      <div class="col-6">
                      <label class="control-label"><?php echo _TABLEFIELDLOCATIONS; ?></label>
                        <select class="custom-select form-control" name="deal_location">
                          <option value="">---</option>
                        <?php
                          foreach($locations as $item){
                            if($deal['deal_location'] == $item['location_id']){
                              echo '<option value="'.$deal['deal_category'].'" selected="selected">'.$item['location_title'].'</option>';
                            }
                            else{
                              echo '<option value="'.$item['location_id'].'">'.$item['location_title'].'</option>';
                            }
                          }
                        ?>

                        </select>
                      </div>

                    </div>

                    <div class="row">

                    <div class="col-3">
                      <label class="required"><?php echo _TABLEFIELDPRICE; ?></label>
                      <div class="input-group">
                            <span class="input-group-addon text-primary"><?php echo $siteSettings['st_currency'] ?></span>
                            <input class="form-control" value="<?php echo $deal['deal_price']; ?>" name="deal_price" type="text" required="">
                        </div>
                    </div>

                    <div class="col-3">
                      <label><?php echo _TABLEFIELDOLDPRICE; ?></label>
                      <div class="input-group">
                            <span class="input-group-addon text-primary"><?php echo $siteSettings['st_currency'] ?></span>
                            <input class="form-control" value="<?php echo $deal['deal_oldprice']; ?>" name="deal_oldprice" type="text">
                        </div>
                    </div>

                    <div class="col-3">
                        <label><?php echo _TABLEFIELDSTART; ?></label>
                        <div class="input-group">
                            <span class="input-group-addon text-primary"><i class="dripicons-calendar"></i></span>
                            <input class="form-control" name="deal_start" value="<?php echo $deal['deal_start']; ?>" type="text" id="saved-start-date">
                        </div>
                      </div>

                      <div class="col-3">
                        <label><?php echo _TABLEFIELDEXPIRE; ?></label>
                        <div class="input-group">
                            <span class="input-group-addon text-primary"><i class="dripicons-calendar"></i></span>
                            <input class="form-control" name="deal_expire" value="<?php echo $deal['deal_expire']; ?>" type="text" id="saved-end-date">
                            <a class="input-group-addon text-danger clearexpiry"><i class="dripicons-cross"></i></a>
                        </div>
                      </div>

                    </div>

                    <label class="required"><?php echo _TABLEFIELDURLLINK; ?></label>
                    <input type="text" value="<?php echo $deal['deal_link']; ?>" name="deal_link" class="form-control" required="">

                    <label><?php echo _TABLEFIELDVIDEO; ?></label>
                    <input type="text" value="<?php echo $deal['deal_video']; ?>" name="deal_video" class="form-control">

                    <label><?php echo _TABLEFIELDGIF; ?></label>
                    <input type="text" value="<?php echo $deal['deal_gif']; ?>" name="deal_gif" class="form-control">

                    <label><?php echo _TABLEFIELDGALLERY; ?></label>
                      <div class="gallery">
                          <?php foreach($gallery as $item): ?>
                            <div class="image">
                            <div class="badge-container" style="background:url(<?php echo $target_dir; ?><?php echo $item['picture']; ?>);">
                            <a class="deleteItem" data-url="../controller/delete_gallery.php?id=<?php echo $item['id']; ?>">
                            <div class="badge_gallery badge-red"><i class="fa fa-times" aria-hidden="true"></i></div>
                            </div>
                            </a>
                            </div>
                          <?php endforeach; ?>
                      </div>

                    <input name="files" class="input-file" type="file">
                  
                    <div class="row">

                    <div class="col-6">

                    <label class="control-label"><?php echo _TABLEFIELDFEATURED; ?></label>

                    <select class="custom-select form-control" name="deal_featured" required="">
                      <?php
                      if($deal['deal_featured'] == 1)
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

                    <div class="col-6">

                    <label class="control-label"><?php echo _TABLEFIELDEXCLUSIVE; ?></label>

                    <select class="custom-select form-control" name="deal_exclusive" required="">
                      <?php
                      if($deal['deal_exclusive'] == 1)
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

                    <select class="custom-select form-control" name="deal_sponsored" required="">
                      <?php
                      if($deal['deal_sponsored'] == 1){
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
                      <input type="text" value="<?php echo $deal['deal_seotitle']; ?>" name="deal_seotitle" class="form-control">


                      <label><?php echo _SEODESCRIPTION; ?></label>
                      <textarea type="text" class="form-control" name="deal_seodescription"><?php echo $deal['deal_seodescription']; ?></textarea>

                    </fieldset>

                  </div>
                </div>

                <div class="form-group col-12 col-lg-3 sidebar">

                 <div class="block col-md-12">
                   <label><?php echo _TABLEFIELDSTATUS; ?></label>

                   <select class="custom-select form-control" name="deal_status" required="">

                    <?php
                    if($deal['deal_status'] == 1){
                      echo '<option value="1" selected="selected">'._ENABLED.'</option>';
                      echo '<option value="2">'._DISABLED.'</option>';
                      echo '<option value="3">'._PENDING.'</option>';
                      echo '<option value="4">'._REJECTED.'</option>';
                      echo '<option value="5">'._HIDDEN.'</option>';
                    }elseif($deal['deal_status'] == 2){
                      echo '<option value="2" selected="selected">'._DISABLED.'</option>';
                      echo '<option value="1">'._ENABLED.'</option>';
                      echo '<option value="3">'._PENDING.'</option>';
                      echo '<option value="4">'._REJECTED.'</option>';
                      echo '<option value="5">'._HIDDEN.'</option>';
                    }elseif($deal['deal_status'] == 3){
                      echo '<option value="3" selected="selected">'._PENDING.'</option>';
                      echo '<option value="1">'._ENABLED.'</option>';
                      echo '<option value="2">'._DISABLED.'</option>';
                      echo '<option value="4">'._REJECTED.'</option>';
                      echo '<option value="5">'._HIDDEN.'</option>';
                    }elseif($deal['deal_status'] == 4){
                      echo '<option value="1">'._ENABLED.'</option>';
                      echo '<option value="2">'._DISABLED.'</option>';
                      echo '<option value="3">'._PENDING.'</option>';
                      echo '<option value="4" selected="selected">'._REJECTED.'</option>';
                      echo '<option value="5">'._HIDDEN.'</option>';
                    }elseif($deal['deal_status'] == 5){
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

                  <div class="new-image" id="image-preview" style="background: url(<?php echo $target_dir; ?><?php echo $deal['deal_image'] ?>);">
                    <label for="image-upload" id="image-label"><?php echo _CHOOSEFILE; ?></label>
                    <input type="hidden" value="<?php echo $deal['deal_image']; ?>" name="deal_image_save">
                    <input type="file" name="deal_image" accept=".jpg, .jpeg, .png, .gif" id="image-upload" />
                  </div>

                  <span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>650 x 350</b> </span>
                  <br/>
                </div>

                <div class="block col-md-12">
                <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
                <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_deal.php?id=<?php echo $deal['deal_id']; ?>" data-redirect="../controller/deals.php"><?php echo _DELETEITEM; ?></button>
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
