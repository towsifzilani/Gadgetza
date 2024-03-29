<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_codes.php",
     "responsive": true,
     "bPaginate":true,
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aaSorting": [[1,'desc']],
     "aoColumns": [
     { mData: 'code_id', "width": "5%", "className": "text-center" },
     { mData: 'code_title'},
     { mData: 'code_coupon'},
     { mData: 'code_discount'},
     { mData: 'code_quantity', "width": "14%"},
     { mData: 'totalused'},
     { "mData": null , "width": "6%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.code_status == 1) {
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
    return "<a class='btn btn-small btn-primary' href='../controller/edit_code.php?id="+data.code_id+"'>"+EDITITEM+"</a> <a class='btn btn-small btn-danger btn-delete deleteItem' data-url='../controller/delete_code.php?id="+data.code_id+"'>"+DELETEITEM+"</a>";}
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
          <h5 class="text-truncate"><?php echo _CODES; ?></h5>
        </div>

        <div class="row">

          <div class="col-12 c-col-12">
            <a class="btn btn-primary" href="../controller/new_code.php">
              <i class="fa fa-plus add-new-i"></i> <?php echo _ADDITEM; ?>
            </a>
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
                        <th><?php echo _TABLEFIELDCOUPON; ?></th>
                        <th><?php echo _TABLEFIELDDISCOUNT; ?></th>
                        <th><?php echo _TABLEFIELDQUANTITY; ?></th>
                        <th><?php echo _TABLEFIELDUSED; ?></th>
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
<?php require 'footer.php'; ?>