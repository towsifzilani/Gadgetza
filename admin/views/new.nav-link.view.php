<div id="add_link" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="btn btn-primary close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo _ADDCUSTOMLINK; ?></h4>
  </div>
  <div class="modal-body">
    <form enctype="multipart/form-data" method="post" id="insertNavLink">
      <div class="form-group">
       <label class="required"><?php echo _HREFLABEL; ?></label>
       <input type="text" name="navigation_label" id="navigation_label" class="form-control" required="" />

       <br />
       
       <label class="required"><?php echo _HREFURL; ?></label>
       <input type="text" name="navigation_url" id="navigation_url" class="form-control" required="" />


       <br />
       <label class="control-label"><?php echo _HREFTARGET; ?></label>

       <select class="custom-select form-control" name="navigation_target">
         <option value="_self" selected="">Self</option>
         <option value="_blank">Blank</option>
         <option value="_top">Top</option>
       </select>
       <br>
       <br>

       <input type="text" name="navigation_type" value="custom" hidden="true" />
       <input type="text" name="menu_id" value="<?php echo $_GET["id"]; ?>" hidden="true" />
       <input type="text" name="navigation_order" hidden="true" />

       <input type="submit" name="add" id="add" value="<?php echo _SAVECHANGES; ?>" class="btn btn-primary" />

     </div>
   </form>
 </div>
</div>
</div>
</div>