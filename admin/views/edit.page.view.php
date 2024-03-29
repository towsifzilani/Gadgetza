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

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $page['page_id']; ?>" method="post">

               <input type="hidden" value="<?php echo $page['page_id']; ?>" name="page_id">

               <div class="form-row">
                <div class="form-group col-12 col-lg-9">
                  <div class="block col-md-12">

                    <label class="required"><?php echo _PAGETITLE; ?></label>
                    <input type="text" value="<?php echo $page['page_title']; ?>" name="page_title" class="form-control" required="">

                    <label><?php echo _TABLEFIELDSLUG; ?></label>
                    <div class="input-group">
                    <span class="input-group-addon"><?php echo SITE_URL . '/' ?></span>
                    <input type="hidden" value="<?php echo $page['page_slug']; ?>" name="page_slug_save">
                    <input type="text" placeholder="<?php echo $page['page_slug']; ?>" name="page_slug" class="form-control">
                    </div>
                    
                    <label><?php echo _PAGETEMPLATE; ?></label>
                    <?php if(is_default_page($page['page_id'])): ?>
                      <input type="hidden" name="page_template" value="<?php echo $page['page_template']; ?>" />
                    <?php endif; ?>
                    
                    <select class="custom-select form-control" id="single-select" data-selected="<?php echo $page['page_template']; ?>" name="page_template" <?php echo !(is_default_page($page['page_id'])) ? NULL : 'disabled' ?>>
                      <option value="blank"><?php echo _PAGEBLANK; ?></option>
                      <option value="search"><?php echo _PAGESEARCH; ?></option>
                      <option value="categories"><?php echo _PAGECATEGORIES; ?></option>
                      <option value="locations"><?php echo _PAGELOCATIONS; ?></option>
                      <option value="stores"><?php echo _PAGESTORES; ?></option>
                      <option value="contact"><?php echo _PAGECONTACT; ?></option>
                      <option value="terms"><?php echo _PAGETERMSCONDITIONS; ?></option>
                      <option value="privacy"><?php echo _PAGEPRIVACYPOLICY; ?></option>
                      <option value="pricing"><?php echo _PAGEPRICING; ?></option>
                    </select>

                    <?php echo !(is_default_page($page['page_id'])) ? NULL : "<small>"._CANTCHANGEPAGE." <a href='../controller/settings.php#pages'>"._CHANGESETTINGBTN."</a></small><br/>" ?>

                    <div class="row">
                      
                      <div class="col-6">
                        
                    <label><?php echo _PAGEFOOTER; ?></label>
                    <select class="custom-select form-control" name="page_show_footer">
                      <?php
                      if($page['page_show_footer'] == 1){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';
                      }
                      else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>

                    <label><?php echo _PAGESHOWTITLE; ?></label>
                    <select class="custom-select form-control" name="page_show_title">
                      <?php
                      if($page['page_show_title'] == 1){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';
                      }
                      else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>

                    <label><?php echo _PAGEHEADERAD; ?></label>
                    <select class="custom-select form-control" name="page_ad_header">
                      <?php
                      if($page['page_ad_header'] == 1){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';
                      }
                      else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>

                      </div>

                      <div class="col-6">
                        
                    <label><?php echo _PAGEFOOTERAD; ?></label>
                    <select class="custom-select form-control" name="page_ad_footer">
                      <?php
                      if($page['page_ad_footer'] == 1){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';
                      }
                      else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>

                    <label><?php echo _PAGESIDEBARAD; ?></label>
                    <select class="custom-select form-control" name="page_ad_sidebar">
                      <?php
                      if($page['page_ad_sidebar'] == 1){
                        echo '<option value="1" selected="selected">'._YESTEXT.'</option>';
                        echo '<option value="0">'._NOTEXT.'</option>';
                      }
                      else{
                        echo '<option value="0" selected="selected">'._NOTEXT.'</option>';
                        echo '<option value="1">'._YESTEXT.'</option>';
                      }
                      ?>
                    </select>

                      </div>


                    </div>

                    <label><?php echo _PAGECONTENT; ?></label>
                    <textarea type="text" class="advancedtinymce form-control" name="page_content"><?php echo $page['page_content']; ?></textarea>
                    <br>

                    <fieldset>
                      <legend><?php echo _SEO; ?></legend>

                      <label class="no-margin-top"><?php echo _SEOTITLE; ?></label>
                      <input type="text" value="<?php echo $page['page_seotitle']; ?>" name="page_seotitle" class="form-control">


                      <label><?php echo _SEODESCRIPTION; ?></label>
                      <textarea type="text" class="form-control" name="page_seodescription"><?php echo $page['page_seodescription']; ?></textarea>

                    </fieldset>

                  </div>
                </div>

                <div class="form-group col-12 col-lg-3 sidebar">

         <div class="block col-md-12">
  
                      <label><?php echo _PAGEPRIVATE; ?></label>
                    <select class="custom-select form-control" name="page_private">

                      <?php
                      if($page['page_private'] == 1){
                        echo '<option value="1" selected="selected">'._PAGEHIDDEN.'</option>';
                        echo '<option value="0">'._PAGEPUBLIC.'</option>';
                      }else{
                        echo '<option value="0" selected="selected">'._PAGEPUBLIC.'</option>';
                        echo '<option value="1">'._PAGEHIDDEN.'</option>';
                      }
                      ?>

                    </select>
          </div>


         <div class="block col-md-12">
           <label class="required"><?php echo _TABLEFIELDSTATUS; ?></label>

           <select class="custom-select form-control" name="page_status" required="">
          <?php
          if($page['page_status'] == 1){
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

        <?php if (is_default_page($page['page_id'])): ?>

         <button class="btn btn-danger cursor-not" type="button" disabled="">
          <?php echo _DELETEITEM; ?>
        </button>

      <?php else: ?>

        <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_page.php?id=<?php echo $page['page_id']; ?>" data-redirect="../controller/pages.php"><?php echo _DELETEITEM; ?></button>

      <?php endif; ?>

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
