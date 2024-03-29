<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_menus.php",
     "responsive": true,
     "bPaginate":true,
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
     { mData: 'menu_id', "width": "5%", "className": "text-center" },
     { mData: 'menu_name'},
     { "mData": null , "width": "10%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.menu_header == 1) {
        return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
      }else{
        return '<span class="badge badge-pill bg-danger"><i class="dripicons-cross"></i></span>';
      }
    }
  },
  { "mData": null , "width": "10%", "className":"status text-center",
  "mRender" : function (data) {
    if (data.menu_footer == 1) {
      return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
    }else{
      return '<span class="badge badge-pill bg-danger"><i class="dripicons-cross"></i></span>';
    }
  }
},
{ "mData": null , "width": "10%", "className":"status text-center",
"mRender" : function (data) {
  if (data.menu_sidebar == 1) {
    return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
  }else{
    return '<span class="badge badge-pill bg-danger"><i class="dripicons-cross"></i></span>';
  }
}
},
{ "mData": null , "width": "5%", "className":"status text-center",
"mRender" : function (data) {
  if (data.menu_status == 1) {
    return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
  }else{
    return '<span class="badge badge-pill bg-danger"><i class="dripicons-cross"></i></span>';
  }
}
},
{ "mData": null ,
"width": "14%",
"className": "text-center",
'orderable': false,
'searchable': false,
"mRender" : function (data) {
  return "<a class='btn btn-small btn-primary' href='../controller/edit_menu.php?id="+data.menu_id+"'>"+EDITITEM+"</a> <a class='btn btn-small btn-danger btn-delete deleteItem' data-url='../controller/delete_menu.php?id="+data.menu_id+"'>"+DELETEITEM+"</a>";}
}
]
});
  });
</script>

<!--Page Container-->
<section class="page-container">
  <div class="page-content-wrapper">

    <!--Main Content-->

    <div class="content sm-gutter">
      <div class="container-fluid padding-25 sm-padding-10">

        <div class="section-title">
          <h5 class="text-truncate"><?php echo _MENUS; ?></h5>
        </div>

        <div class="row">

        <div class="col-12 c-col-12">
            <button type="button" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-primary"><i class="fa fa-plus add-new-i"></i> <?php echo _ADDITEM; ?></button>
        </div>

          <div class="col-12">
            <div class="block table-block mb-4 c-4">

              <div class="row">
                <div class="table-responsive">
                  <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                    <thead>
                      <tr>
                        <th><?php echo _TABLEFIELDID; ?></th>
                        <th><?php echo _TABLEFIELDTITLE; ?></th>
                        <th><?php echo _TABLEFIELDHEADER; ?></th>
                        <th><?php echo _TABLEFIELDFOOTER; ?></th>
                        <th><?php echo _TABLEFIELDSIDEBAR; ?></th>
                        <th><?php echo _TABLEFIELDSTATUS; ?></th>
                        <th><?php echo _TABLEFIELDACTIONS; ?></th>
                      </tr>
                    </thead>
                  </table>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require 'new.menu.view.php'; ?>

<?php require 'footer.php'; ?>
