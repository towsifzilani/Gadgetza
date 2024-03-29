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

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $ad['ad_id']; ?>" method="post">

               <input type="hidden" value="<?php echo $ad['ad_id']; ?>" name="ad_id">

               <div class="form-row">
                <div class="form-group col-12 col-lg-9">
                  <div class="block col-md-12">

                    <label><?php echo _TABLEFIELDTITLE; ?></label>
                    <input type="text" value="<?php echo $ad['ad_title']; ?>" name="ad_title" class="form-control" required="">

                    <label><?php echo _TABLEFIELDLOCATION; ?></label>

                    <select class="custom-select form-control" id="single-select" data-selected="<?php echo $ad['ad_position']; ?>" name="ad_position" required="">
                      <option value="header"><?php echo _TABLEFIELDHEADER; ?></option>
                      <option value="footer"><?php echo _TABLEFIELDFOOTER; ?></option>
                      <option value="sidebar"><?php echo _TABLEFIELDSIDEBAR; ?></option>
                    </select>

                    <label><?php echo _TABLEFIELDCONTENT; ?></label>
                    <textarea type="text" class="advancedtinymce form-control" name="ad_html"><?php echo $ad['ad_html']; ?></textarea>


                  </div>
                </div>

                <div class="form-group col-12 col-lg-3 sidebar">

                  <div class="block col-md-12">
                   <label><?php echo _TABLEFIELDSTATUS; ?></label>

                   <select class="custom-select form-control" name="ad_status" required="">

                    <?php
                    if($ad['ad_status'] == 1){
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
                <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
                <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_ad.php?id=<?php echo $ad['ad_id']; ?>" data-redirect="../controller/ads.php"><?php echo _DELETEITEM; ?></button>
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
