<div id="add_data_Modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="btn btn-primary close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo _ADDITEM; ?></h4>
   </div>
   <div class="modal-body">
    <form enctype="multipart/form-data" method="post" id="insertMenu">

     <label class="control-label"><?php echo _TABLEFIELDTITLE; ?></label>
     <input type="text" name="menu_name" id="menu_name" class="form-control" required="" />
     <br />
   <br>

   <label class="control-label"><?php echo _TABLEFIELDLOCATION; ?></label>

   <table>
     <tr>
       <td>
        <div class="pretty p-default p-curve p-bigger">
        <input type="checkbox" name="menu_header" value="1" />
        <div class="state p-success">
        <label><?php echo _TABLEFIELDHEADER; ?></label>
        </div>
        </div>
       </td>

       <td>
        <div class="pretty p-default p-curve p-bigger">
        <input type="checkbox" name="menu_footer" value="1" />
        <div class="state p-success">
        <label><?php echo _TABLEFIELDFOOTER; ?></label>
        </div>
        </div>
       </td>

       <td>
        <div class="pretty p-default p-curve p-bigger">
        <input type="checkbox" name="menu_sidebar" value="1" />
        <div class="state p-success">
        <label><?php echo _TABLEFIELDSIDEBAR; ?></label>
        </div>
        </div>
       </td>

     </tr>
   </table>

   <br>

   <input type="submit" name="insert" id="insert" value="<?php echo _SAVECHANGES; ?>" class="btn btn-primary" />

    </form>
   </div>
  </div>
 </div>
</div>
