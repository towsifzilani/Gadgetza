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

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $menu['menu_id']; ?>" method="post">


                <div class="form-row">
                  <div class="form-group col-12 col-lg-9">
                    <div class="block col-md-12 padding-bottom-35">

                      <input type="hidden" value="<?php echo $menu['menu_id']; ?>" name="menu_id">

                      <label><?php echo _TABLEFIELDTITLE; ?></label>

                      <input type="text" value="<?php echo $menu['menu_name']; ?>" name="menu_name" class="form-control" required="">

                      <br>

                      <label class="control-label"><?php echo _TABLEFIELDLOCATION; ?></label>
                      <fieldset>

                        <table>
                         <tr>
                           <td>
                            <div class="pretty p-default p-curve p-bigger">
                              <?php if ($menu['menu_header'] == 1) {
                                echo '<input type="checkbox" name="menu_header" value="1" checked />';
                              }else{
                                echo '<input type="checkbox" name="menu_header" value="1" />';
                              } ?>
                              <div class="state p-success">
                                <label><?php echo _TABLEFIELDHEADER; ?></label>
                              </div>
                            </div>
                          </td>

                          <td>
                            <div class="pretty p-default p-curve p-bigger">
                              <?php if ($menu['menu_footer'] == 1) {
                                echo '<input type="checkbox" name="menu_footer" value="1" checked />';
                              }else{
                                echo '<input type="checkbox" name="menu_footer" value="1" />';
                              } ?>
                              <div class="state p-success">
                                <label><?php echo _TABLEFIELDFOOTER; ?></label>
                              </div>
                            </div>
                          </td>

                          <td>
                            <div class="pretty p-default p-curve p-bigger">
                              <?php if ($menu['menu_sidebar'] == 1) {
                                echo '<input type="checkbox" name="menu_sidebar" value="1" checked />';
                              }else{
                                echo '<input type="checkbox" name="menu_sidebar" value="1" />';
                              } ?>
                              <div class="state p-success">
                                <label><?php echo _TABLEFIELDSIDEBAR; ?></label>
                              </div>
                            </div>
                          </td>

                        </tr>
                      </table>
                    </fieldset>

                    <label class="control-label"><?php echo _NAVIGATION; ?></label>

                    <fieldset>

                      <ul class="listas sortable ui-sortable">
                        <?php foreach($navigations as $nav){
                          echo '<li class="ui-sortable-handle" id="item-'.$nav['navigation_id'].'"> <span style="font-weight:bold;font-size: 14px;">' . $nav['navigation_label'] . '</span> · <span style="font-size:12px">' . $nav['navigation_url'] . '</span><a class="delete-nav" href="../controller/delete_nav.php?id=' . $nav["navigation_id"] . '"><i class="fa fa-trash"></i> '._DELETEITEM.'</a></li>';
                          }
                        ?>

                      </ul>
                      <?php if (!empty($navigations)){ ?>
                        <table>
                          <tr>
                            <td><button class="save btn btn-embossed btn-primary" data-id="<?php echo $menu['menu_id']; ?>"><?php echo _SAVECHANGES; ?></button></td>
                            <td><div id="response" class="response"></div></td>
                          </tr>
                        </table>
                      <?php }else{ ?>
                        <p class="nomenuitems"><?php echo _NOITEMSFOUND; ?></p>
                      <?php } ?>
                    </fieldset>

                    <br>

                    <button type="button" data-toggle="modal" data-target="#add_page" class="btn btn-primary"><i class="fa fa-plus add-new-i"></i> <?php echo _ADDPAGE; ?></button>

                    <button type="button" data-toggle="modal" data-target="#add_link" class="btn btn-primary"><i class="fa fa-plus add-new-i"></i> <?php echo _ADDCUSTOMLINK; ?></button>



                  </div>

                </div>

                <div class="form-group col-12 col-lg-3 sidebar">

                  <div class="block col-md-12">
                   <label><?php echo _TABLEFIELDSTATUS; ?></label>

                   <select class="custom-select form-control" name="menu_status" required="">

                    <?php
                    if($menu['menu_status'] == 1){
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
                <button class="btn btn-danger deleteItem" type="button" data-url="../controller/delete_menu.php?id=<?php echo $menu['menu_id']; ?>" data-redirect="../controller/menus.php"><?php echo _DELETEITEM; ?></button>
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

<?php require 'new.nav-link.view.php'; ?>

<?php require 'new.nav-page.view.php'; ?>

<?php require 'footer.php'; ?>



