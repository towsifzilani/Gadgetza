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

          <label class="required"><?php echo _PAGETITLE; ?></label>
          <input type="text" placeholder="" name="page_title" class="form-control" required="">

          <label class="required"><?php echo _PAGETEMPLATE; ?></label>
          <select class="custom-select form-control" name="page_template" required="">
            <option value="blank" selected>-</option>
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

          <div class="row">

            <div class="col-6">

              <label><?php echo _PAGEFOOTER; ?></label>
              <select class="custom-select form-control" name="page_show_footer">
                <option value="1"><?php echo _YESTEXT; ?></option>
                <option value="0"><?php echo _NOTEXT; ?></option>
              </select>

              <label><?php echo _PAGESHOWTITLE; ?></label>
              <select class="custom-select form-control" name="page_show_title">
                <option value="1"><?php echo _YESTEXT; ?></option>
                <option value="0"><?php echo _NOTEXT; ?></option>
              </select>

              <label><?php echo _PAGESIDEBARAD; ?></label>
              <select class="custom-select form-control" name="page_ad_sidebar">
                <option value="0"><?php echo _NOTEXT; ?></option>
                <option value="1"><?php echo _YESTEXT; ?></option>
              </select>

            </div>

            <div class="col-6">

              <label><?php echo _PAGEHEADERAD; ?></label>
              <select class="custom-select form-control" name="page_ad_header">
                <option value="0"><?php echo _NOTEXT; ?></option>
                <option value="1"><?php echo _YESTEXT; ?></option>
              </select>

              <label><?php echo _PAGEFOOTERAD; ?></label>
              <select class="custom-select form-control" name="page_ad_footer">
                <option value="0"><?php echo _NOTEXT; ?></option>
                <option value="1"><?php echo _YESTEXT; ?></option>
              </select>

            </div>

          </div>

          <label><?php echo _PAGECONTENT; ?></label>
          <textarea type="text" class="advancedtinymce form-control" name="page_content"></textarea>

          <br>
          <fieldset>
            <legend><?php echo _SEO; ?></legend>

            <label class="no-margin-top"><?php echo _SEOTITLE; ?></label>
            <input type="text" placeholder="" name="page_seotitle" class="form-control">


            <label><?php echo _SEODESCRIPTION; ?></label>
            <textarea type="text" class="form-control" name="page_seodescription"></textarea>

          </fieldset>

        </div>
      </div>
      <div class="form-group col-12 col-lg-3 sidebar">

        <div class="block col-md-12">

          <label><?php echo _PAGEVISIBILTY; ?></label>
          <select class="custom-select form-control" name="page_private">
            <option value="0"><?php echo _PAGEPUBLIC; ?></option>
            <option value="1"><?php echo _PAGEPRIVATE; ?></option>
          </select>

        </div>

        <div class="block col-md-12">
         <label><?php echo _TABLEFIELDSTATUS; ?></label>

         <select class="custom-select form-control" name="page_status">
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