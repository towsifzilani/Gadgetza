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
          
            <div class="block form-block mb-4">

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $tax['tax_id']; ?>" method="post">
                <div class="form-row">

                  <div class="form-group col-md-12">

                   <input type="hidden" value="<?php echo $tax['tax_id']; ?>" name="tax_id">
                   
                   <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
                   <input type="text" value="<?php echo $tax['tax_title']; ?>" name="tax_title" class="form-control" required="">

                   <label  class="required"><?php echo _TABLEFIELDPERCENTAGE; ?></label>
                    <div class="input-group">
                            <input class="form-control" name="tax_percentage" value="<?php echo $tax['tax_percentage']; ?>" type="number" required="" disabled="">
                            <span class="input-group-addon text-primary">%</span>
                        </div>

                        <label  class="required"><?php echo _TABLEFIELDTAXTYPE; ?></label>
                    <select class="custom-select form-control" name="tax_type" disabled="">
                    <?php
                    if($tax['tax_type'] == 'inclusive'){
                      echo '<option value="inclusive" selected="selected">'._INCLUSIVETAX.'</option>';
                      echo '<option value="exclusive">'._EXCLUSIVETAX.'</option>';

                    }elseif($tax['tax_type'] == 'exclusive'){
                      echo '<option value="exclusive" selected="selected">'._EXCLUSIVETAX.'</option>';
                      echo '<option value="inclusive">'._INCLUSIVETAX.'</option>';
                    }
                    ?>
                    </select>

                    <label><?php echo _TABLEFIELDCOUNTRIES; ?></label>
                    <select class="selectDrop form-control" name="tax_countries[]" multiple="">

                   <?php
                          foreach($countriesArray as $item => $value){
                            if(in_array($item, json_decode($tax['tax_countries']))){
                              echo '<option value="'.$item.'" selected="selected">'.$value.'</option>';
                            }
                            else{
                              echo '<option value="'.$item.'">'.$value.'</option>';
                            }
                          }
                        ?>
                          
                    </select>
                    <small class="form-text text-muted"><?php echo _LEAVEEMPTYCOUNTRIES; ?></small>


                  <br/>
                  <br/>

                  <hr>

                  <button class="btn btn-primary" type="submit" name="save"><?php echo _UPDATEITEM; ?></button>
                  <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_tax.php?id=<?php echo $tax['tax_id']; ?>" data-redirect="../controller/taxs.php"><?php echo _DELETEITEM; ?></button>

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
