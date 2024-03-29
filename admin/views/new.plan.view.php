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

                      <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                      <input type="text" placeholder="" name="plan_title" class="form-control" required="">

                      <label><?php echo _TABLEFIELDORDER; ?></label>
                      <input type="number" placeholder="" name="plan_order" class="form-control">

                      <label><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                      <textarea type="text" class="mceNoEditor form-control" name="plan_description"></textarea>

                      <br>
                      <br>
                      <fieldset>
                        <legend style="margin-bottom: 0;"><?php echo _TABLEFIELDMONTHLYPRICE; ?></legend>

                        <div class="row">

                        <div class="col-3">
                          <label style="margin-top: 0;"><?php echo _TABLEFIELDPRICE; ?></label>
                          <div class="input-group">
                              <span class="input-group-addon text-primary"><?php echo $siteSettings['st_currencycode'] ?></span>
                              <input class="form-control" name="plan_monthly" type="number">
                          </div>
                        <small class="form-text text-muted"><?php echo _TOTALSETZERO; ?></small>
                        </div>

                        <div class="col-4">
                          <label style="margin-top: 0;"><?php echo _TABLEFIELDTITLE; ?></label>
                          <input class="form-control" name="plan_monthly_label" type="text">
                        </div>

                        <div class="col-5">
                          <label style="margin-top: 0;"><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                          <input class="form-control" name="plan_monthly_description" type="text">
                        </div>

                        </div>

                      </fieldset>

                      <br>
                      <fieldset>
                        <legend style="margin-bottom: 0;"><?php echo _TABLEFIELDHALFYEARPRICE; ?></legend>

                        <div class="row">

                        <div class="col-3">
                          <label style="margin-top: 0;"><?php echo _TABLEFIELDPRICE; ?></label>
                          <div class="input-group">
                              <span class="input-group-addon text-primary"><?php echo $siteSettings['st_currencycode'] ?></span>
                              <input class="form-control" name="plan_halfyear" type="number">
                          </div>
                        <small class="form-text text-muted"><?php echo _TOTALSETZERO; ?></small>
                        </div>

                        <div class="col-4">
                          <label style="margin-top: 0;"><?php echo _TABLEFIELDTITLE; ?></label>
                          <input class="form-control" name="plan_halfyear_label" type="text">
                        </div>

                        <div class="col-5">
                          <label style="margin-top: 0;"><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                          <input class="form-control" name="plan_halfyear_description" type="text">
                        </div>

                        </div>

                      </fieldset>

                      <br>
                      <fieldset>
                        <legend style="margin-bottom: 0;"><?php echo _TABLEFIELDANNUALPRICE; ?></legend>

                        <div class="row">

                        <div class="col-3">
                          <label style="margin-top: 0;"><?php echo _TABLEFIELDPRICE; ?></label>
                          <div class="input-group">
                              <span class="input-group-addon text-primary"><?php echo $siteSettings['st_currencycode'] ?></span>
                              <input class="form-control" name="plan_annual" type="number">
                          </div>
                        <small class="form-text text-muted"><?php echo _TOTALSETZERO; ?></small>
                        </div>

                        <div class="col-4">
                          <label style="margin-top: 0;"><?php echo _TABLEFIELDTITLE; ?></label>
                          <input class="form-control" name="plan_annual_label" type="text">
                        </div>

                        <div class="col-5">
                          <label style="margin-top: 0;"><?php echo _TABLEFIELDDESCRIPTION; ?></label>
                          <input class="form-control" name="plan_annual_description" type="text">
                        </div>

                        </div>

                      </fieldset>

                      <label class="required"><?php echo _TABLEFIELDPRODUCTSLIMIT; ?></label>
                      <input type="number" placeholder="" name="plan_total" class="form-control" required="">
                      <small class="form-text text-muted"><?php echo _TOTALPRODUCTS; ?></small>

                      <label class="required"><?php echo _TABLEFIELDCUSTOMSTORE; ?></label>
                   <select class="custom-select form-control" name="plan_customstore">
                     <option value="0"><?php echo _NOTEXT; ?></option>
                     <option value="1"><?php echo _YESTEXT; ?></option>
                   </select>
                   <small class="form-text text-muted"><?php echo _CUSTOMSTORE; ?></small>

                   <label class="required"><?php echo _TABLEFIELDEXPIRED; ?></label>
                      <input type="number" placeholder="" name="plan_limit" class="form-control" required="">
                   <small class="form-text text-muted"><?php echo _EXPIREDITEMS; ?></small>

                   <br>

                   <!--<div class="row">

                   <div class="col-12 col-lg-6">
                          <label class="required"><?php echo _TABLEFIELDEXCLUSIVESPLAN; ?></label>
                          <input class="form-control" name="plan_exclusive_total" type="number">
                   <small class="form-text text-muted"><?php echo _TABLEFIELDEXCLUSIVESPLANTEXT; ?></small>
                        </div>

                        <div class="col-12 col-lg-6">
                          <label class="required"><?php echo _TABLEFIELDFEATUREDPLAN; ?></label>
                          <input class="form-control" name="plan_featured_total" type="number">
                   <small class="form-text text-muted"><?php echo _TABLEFIELDFEATUREDPLANTEXT; ?></small>
                        </div>

                    </div>-->

                   <label><?php echo _TABLEFIELDRECOMMENDED; ?></label>
                   <select class="custom-select form-control" name="plan_recommended">
                     <option value="0"><?php echo _NOTEXT; ?></option>
                     <option value="1"><?php echo _YESTEXT; ?></option>
                   </select>

                   <label><?php echo _APPLIEDTAXES; ?></label>
                    <select class="selectDrop form-control" name="plan_taxes[]" multiple="">
                      <?php foreach($taxes as $item): ?>
                      <option value="<?php echo $item['tax_id']; ?>"><?php echo $item['tax_title']; ?></option>
                      <?php endforeach; ?>
                    </select>

                    <label><?php echo _APPLIEDCOUPONS; ?></label>
                    <select class="selectDrop form-control" name="plan_codes[]" multiple="">
                      <?php foreach($codes as $item): ?>
                      <option value="<?php echo $item['code_id']; ?>"><?php echo $item['code_coupon']; ?></option>
                      <?php endforeach; ?>
                    </select>

                   <label><?php echo _TABLEFIELDOTHERFEATURES; ?></label>
                      <div id="features">  
                      <div id="rowIng1">
                      <div class="row small-margin-bottom">  
                         <div class="col-2 no-padding-right">
                         <select class="custom-select form-control" name="plan_checkbox[]">
                          <option value="1" selected=""><?php echo _ENABLED; ?></option>
                          <option value="0"><?php echo _DISABLED; ?></option>
                         </select>
                         </div>  
                         <div class="col-4"><input type="text" name="plan_features[]" placeholder="<?php echo _ENTERVALUE; ?>" class="form-control" /></div>  
                         <div class="col-5 no-padding-left"><input type="text" name="plan_summary[]" placeholder="<?php echo _ENTERDESCRIPTION; ?>" class="form-control" /></div>  
                         <div class="col-1 no-padding-left"><button type="button" name="add" id="addIng" class="btn btn-block btn-success"><i class="fa fa-plus"></i></button></div>  
                        </div>  
                     </div>  
                     </div>  

                   <br>
                   <br>

                </div>
              </div>
              <div class="form-group col-12 col-lg-3 sidebar">

               <div class="block col-md-12">
                 <label><?php echo _TABLEFIELDSTATUS; ?></label>

                 <select class="custom-select form-control" name="plan_status">
                  <option value="1" selected=""><?php echo _ENABLED; ?></option>
                  <option value="2"><?php echo _DISABLED; ?></option>
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

<script>

'use strict';
$(document).ready(function(){  

    var count = $('[id^=rowIng]').filter(function () {
        return this.id.match(/rowIng\d+$/);
    }).length;

  $('#addIng').on('click', function(){  
    console.log('test');
    count++;  
   $('#features').append('<div id="rowIng'+count+'"><div class="row small-margin-bottom"><div class="col-2 no-padding-right"> <select class="custom-select form-control" name="plan_checkbox[]"> <option value="1" selected=""><?php echo _ENABLED; ?></option> <option value="0"><?php echo _DISABLED; ?></option> </select> </div><div class="col-md-4"><input type="text" name="plan_features[]" placeholder="<?php echo _ENTERVALUE; ?>" class="form-control" /></div><div class="col-md-5 no-padding-left"><input type="text" name="plan_summary[]" placeholder="<?php echo _ENTERDESCRIPTION; ?>" class="form-control" /></div><div class="col-md-1 no-padding-left"><button type="button" name="remove" id="'+count+'" class="btn btn-block btn-danger remove_ing">'+'<i class="fa fa-times"></i>'+'</button></div></div></div>');  
 });  
  $(document).on('click', '.remove_ing', function(){  
    var button_id = $(this).attr("id");   
   $('#rowIng'+button_id+'').remove();  
 });  
});
</script>

<?php require 'footer.php'; ?>
