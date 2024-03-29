<div id="add_page" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="btn btn-primary close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo _ADDPAGE; ?></h4>
   </div>
   <div class="modal-body">
    <form enctype="multipart/form-data" method="post" id="insertNavPage">
<div class="form-group">

   <label class="control-label required"><?php echo _PAGES; ?></label>

   <select class="custom-select form-control" name="page_id" required="">
      <?php
       foreach($pages as $page){
          echo '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
       }
      ?>
   </select>

     <br />
   <label class="control-label"><?php echo _HREFTARGET; ?></label>

   <select class="custom-select form-control" name="navigation_target">
   <option value="_self" selected="">Self</option>
   <option value="_blank">Blank</option>
   <option value="_top">Top</option>
   </select>
   <br>
   <br>

   <input type="text" name="navigation_type" value="page" hidden="true" />
   <input type="text" name="menu_id" value="<?php echo $_GET["id"]; ?>" hidden="true" />
   <input type="text" name="navigation_order" hidden="true" />


   <input type="submit" name="insert" id="insert" value="<?php echo _SAVECHANGES; ?>" class="btn btn-primary" />

</div>
    </form>
   </div>
  </div>
 </div>
</div>