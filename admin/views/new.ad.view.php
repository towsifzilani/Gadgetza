<div id="add_data_Modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="btn btn-primary close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo _ADDITEM; ?></h4>
   </div>
   <div class="modal-body">
    <form enctype="multipart/form-data" method="post" id="insertAds">

     <label class="required"><?php echo _TABLEFIELDTITLE; ?></label>
     <input type="text" name="ad_title" id="ad_title" class="form-control" required="" />
     <br />
   <br>

   <label class="control-label required"><?php echo _TABLEFIELDLOCATION; ?></label>

   <select class="form-control" name="ad_position" required="">
     <option value="header"><?php echo _TABLEFIELDHEADER; ?></option>
     <option value="footer"><?php echo _TABLEFIELDFOOTER; ?></option>
     <option value="sidebar"><?php echo _TABLEFIELDSIDEBAR; ?></option>
   </select>
   <br>
   <br>
   <input type="submit" name="insert" id="insert" value="<?php echo _SAVECHANGES; ?>" class="btn btn-primary" />

    </form>
   </div>
  </div>
 </div>
</div>
