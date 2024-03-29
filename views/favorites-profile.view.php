<h5 class="uk-heading-line"><span><?php echo echoOutput($translation['tr_182']); ?></span></h5>

<script type="text/javascript">

'use strict';
$(document).ready(function(){
  
    $('#favorites_table').DataTable({
     "bProcessing": true,
     "sAjaxSource": SITEURL+"/controllers/favorites.php",
     "responsive": true,
     "bPaginate":true,
     "bInfo" : false,
     "bFilter": false,
     "sPaginationType":"simple_numbers",
     "iDisplayLength": 5,
     "lengthChange": false,
     "fnCreatedRow": function( nRow, data, iDataIndex ) {
      $(nRow).addClass("id-"+data.deal_id);
    },
     "aoColumns": [
     { "mData": null , "width": "12%", "className": "uk-text-center", 'orderable': false,
    'searchable': false,
     "mRender" : function (data) {
      return '<a href="<?php echo $urlPath->deal(); ?>'+data.deal_id+'/'+data.deal_slug+'" target="_blank"><img src="'+IMAGES_FOLDER+data.deal_image+'" class="uk-border-rounded"/></a>';}
    },
    { "mData": null,
    "mRender" : function (data) {
      return '<a href="<?php echo $urlPath->deal(); ?>'+data.deal_id+'/'+data.deal_slug+'" target="_blank" class="uk-link-reset uk-text-small">'+data.deal_title+'</a>';}
    },
    { "mData": null ,
    "width": "14%",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      return '<a class="deleteItem" data-item="'+data.deal_id+'" data-user="<?php echo $userInfo['user_id']; ?>"><span class="uk-label uk-label-danger uk-text-danger"><?php echo $translation['tr_112']; ?></span></a>';}
    }
    ]
  });

  });

</script>

<table id="favorites_table" class="uk-table uk-table-hover uk-table-middle uk-table-divider" style="width: 100%">

<thead>
  <tr>
    <th><?php echo $translation['tr_105']; ?></th>
    <th><?php echo $translation['tr_106']; ?></th>
    <th></th>
  </tr>
</thead>
</table>