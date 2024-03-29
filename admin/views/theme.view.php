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
  <h4><?php echo _THEME; ?></h4> 
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


<div class="block form-block mb-4" style="margin-top: 20px;">

  <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

    <div class="form-row">

      <div class="form-group col-md-12">

        <div class="table-responsive">

          <fieldset>
            <legend><?php echo _THCOLORS; ?></legend>

            <table class="display table s-table">

              <tr>
                <td>
                  <table class="table">

                  <td width="50px" style="padding-top: 8px !important;">
                  <div class="preview-color" id="primary-color-preview" style="background-color: <?php echo $theme['th_primarycolor']; ?>"></div>
                  </td>

                  <td>
                  <label><?php echo _THCOLORPRIMARY; ?></label>
                  <input id="primary-color-picker" type="text" value="<?php echo $theme['th_primarycolor']; ?>" name="th_primarycolor" class="form-control"/>
                  </td>

                  <td width="50px" style="padding-top: 8px !important;">
                  <div class="preview-color" id="secondary-color-preview" style="background-color: <?php echo $theme['th_secondarycolor']; ?>"></div>
                  </td>

                  <td>
                  <label><?php echo _THCOLORSSECONDARY; ?></label>
                  <input id="secondary-color-picker" type="text" value="<?php echo $theme['th_secondarycolor']; ?>" name="th_secondarycolor" class="form-control"/>
                  </td>

                </td>

                </tr>

                </table>

            </table>

          </fieldset>

<fieldset>
            <legend><?php echo _THLAYOUT; ?></legend>

            <table class="display table s-table">

            <tr>  
                <td>
                  <label><?php echo _THHEADERMOBILE; ?></label>
                    <select class="custom-select form-control" name="th_mobilestyle" required="">
                      <?php
                      if($theme['th_mobilestyle'] == 'style1'){
                        echo '<option value="style1" selected="selected">Style 1</option>';
                        echo '<option value="style2">Style 2</option>';
                      }elseif($theme['th_mobilestyle'] == 'style2'){
                        echo '<option value="style2" selected="selected">Style 2</option>';
                        echo '<option value="style1">Style 1</option>';
                      }
                      ?>
                    </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _THHEADER; ?></label>
                    <select class="custom-select form-control" name="th_headerstyle" required="">
                      <?php
                      if($theme['th_headerstyle'] == 'header1'){
                        echo '<option value="header1" selected="selected">Style 1</option>';
                        echo '<option value="header2">Style 2</option>';
                        echo '<option value="header3">Style 3</option>';
                      }elseif($theme['th_headerstyle'] == 'header2'){
                        echo '<option value="header2" selected="selected">Style 2</option>';
                        echo '<option value="header1">Style 1</option>';
                        echo '<option value="header3">Style 3</option>';
                      }elseif($theme['th_headerstyle'] == 'header3'){
                        echo '<option value="header3" selected="selected">Style 3</option>';
                        echo '<option value="header1">Style 1</option>';
                        echo '<option value="header2">Style 2</option>';
                      }
                      ?>
                    </select>
                </td>
              </tr>

              <tr>  
                <td>
                  <label><?php echo _THHOME; ?></label>
                    <select class="custom-select form-control" name="th_homestyle" required="">
                    <?php
                      if($theme['th_homestyle'] == 'home1'){
                        echo '<option value="home1" selected="selected">Home 1</option>';
                        echo '<option value="home2">Home 2</option>';
                        echo '<option value="home3">Home 3</option>';
                      }elseif($theme['th_homestyle'] == 'home2'){
                        echo '<option value="home2" selected="selected">Home 2</option>';
                        echo '<option value="home1">Home 1</option>';
                        echo '<option value="home3">Home 3</option>';
                      }elseif($theme['th_homestyle'] == 'home3'){
                        echo '<option value="home3" selected="selected">Home 3</option>';
                        echo '<option value="home1">Home 1</option>';
                        echo '<option value="home2">Home 2</option>';
                      }
                      ?>
                    </select>
                </td>
              </tr>

            </table>

          </fieldset>


          <fieldset>
            <legend><?php echo _THLOGOS; ?></legend>

            <div class="row">

            <div class="col-12 col-sm-12 col-md-6 col-lg-4">

                  <label><?php echo _THLOGO; ?></label>
                  <span class="text-danger recomendedsize display-block"><b>270 x 110 Px</b> </span>

                  <div class="form-group">
                  <input type="hidden" value="<?php echo $theme['th_logo']; ?>" name="th_logo_save">
                  <input type="file" name="th_logo" accept=".jpg, .jpeg, .png, .gif" class="form-control-file th-file-input">
                  <small class="form-text text-muted"><?php echo _ALLOWEDFILEFORMATS; ?></small>
                  </div>

            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-4">

                  <label><?php echo _THTRANSPARENTLOGO; ?></label>
                  <span class="text-danger recomendedsize display-block"><b>270 x 110 Px</b> </span>

                  <div class="form-group">
                  <input type="hidden" value="<?php echo $theme['th_whitelogo']; ?>" name="th_whitelogo_save">
                  <input type="file" name="th_whitelogo" accept=".jpg, .jpeg, .png, .gif" class="form-control-file th-file-input">
                  <small class="form-text text-muted"><?php echo _ALLOWEDFILEFORMATS; ?></small>
                  </div>

            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-4">

            <label><?php echo _THFAVICON; ?></label>
                  <span class="text-danger recomendedsize display-block"><b>64 x 64 Px</b> </span>

                  <div class="form-group">
                  <input type="hidden" value="<?php echo $theme['th_favicon']; ?>" name="th_favicon_save">
                  <input type="file" name="th_favicon" accept=".jpg, .jpeg, .png, .gif" class="form-control-file th-file-input">
                  <small class="form-text text-muted"><?php echo _ALLOWEDFILEFORMATS; ?></small>
                  </div>


            </div>

            </div>

            </table>

          </fieldset>

          <fieldset>
            <legend><?php echo _THIMAGES; ?></legend>

            <div class="row">

              <div class="col-12 col-sm-12 col-md-6 col-lg-4">

              <label><?php echo _THHOMEBACKGROUND; ?></label>
                <span class="text-danger recomendedsize display-block"><b>1920 x 700 Px</b> </span>

                <div class="form-group">
                <input type="hidden" value="<?php echo $theme['th_homebg']; ?>" name="th_homebg_save">
                <input type="file" name="th_homebg" accept=".jpg, .jpeg, .png, .gif" class="form-control-file th-file-input">
                <small class="form-text text-muted"><?php echo _ALLOWEDFILEFORMATS; ?></small>
                </div>
              </div>

              </div>

          </fieldset>

</div>
</div>
</div>

<button class="btn btn-primary" type="submit" name="save"><?php echo _SAVECHANGES; ?></button>

</form>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

  <div class="scrollTop">
    <span><a href=""><i class="dripicons-arrow-thin-up"></i></a></span>
  </div>

<?php require 'footer.php'; ?>
