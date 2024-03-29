<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_coupons.php",
     "responsive": true,
     "bPaginate":true,
     "aaSorting": [[1,'desc']],
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
     { mData: 'coupon_id', "width": "5%", "className": "text-center" },
     { "mData": null , "width": "12%", "className": "product text-center",
     "mRender" : function (data) {
      return "<img src='"+IMAGES_FOLDER+data.coupon_image+"' class='product-img product-img-horizontal'/>";}
    },
    { mData: 'coupon_title'},
    { mData: 'category_title', "width": "10%" },
    { mData: 'coupon_code', "width": "10%" },
    { "mData": null , "width": "7%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.coupon_featured == 1) {
        return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
      }else{
        return '<span class="badge badge-pill bg-warning"><i class="dripicons-cross"></i></span>';
        }
      }
    },
    { "mData": null , "width": "7%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.coupon_verified == 1) {
        return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
      }else{
        return '<span class="badge badge-pill bg-warning"><i class="dripicons-cross"></i></span>';
        }
      }
    },
    { "mData": null , "width": "5%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.coupon_status == 1) {
        return '<span class="label badge-pill bg-success"><?php echo _ENABLED; ?></span>';
      }else if (data.coupon_status == 2) {
        return '<span class="label badge-pill bg-danger"><?php echo _DISABLED; ?></span>';
      }else if (data.coupon_status == 3) {
        return '<span class="label badge-pill bg-warning"><?php echo _PENDING; ?></span>';
      }else if (data.coupon_status == 4) {
        return '<span class="label badge-pill bg-danger"><?php echo _REJECTED; ?></span>';
      }else if (data.coupon_status == 5) {
        return '<span class="label badge-pill bg-secondary"><?php echo _HIDDEN; ?></span>';
      }
      }
    },
    { "mData": null ,
    "width": "14%",
    "className": "text-center",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      return "<a class='btn btn-small btn-primary' href='../controller/edit_coupon.php?id="+data.coupon_id+"'>"+EDITITEM+"</a> <a class='btn btn-small btn-danger btn-delete deleteItem' data-url='../controller/delete_coupon.php?id="+data.coupon_id+"'>"+DELETEITEM+"</a>";}
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
          <h5 class="text-truncate"><?php echo _COUPONS; ?></h5>
        </div>

        <div class="row">

          <div class="col-12 c-col-12">

            <a class="btn btn-primary" href="../controller/new_coupon.php">
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
                        <th><?php echo _TABLEFIELDIMAGE; ?></th>
                        <th><?php echo _TABLEFIELDTITLE; ?></th>
                        <th><?php echo _TABLEFIELDCATEGORY; ?></th>
                        <th><?php echo _TABLEFIELDCOUPONCODE; ?></th>
                        <th><?php echo _TABLEFIELDFEATURED; ?></th>
                        <th><?php echo _TABLEFIELDVERIFY; ?></th>
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