<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_deals.php",
     "responsive": true,
     "bPaginate":true,
     "aaSorting": [[1,'desc']],
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
     { mData: 'deal_id', "width": "5%", "className": "text-center" },
     { "mData": null , "width": "8%", "className": "text-left",
     "mRender" : function (data) {
      return "<a class='text-dark' href='../controller/user_details.php?id="+data.deal_author+"'>"+data.author_name+"</a>";}
    },
     { "mData": null , "width": "12%", "className": "product text-center",
     "mRender" : function (data) {
      return "<img src='"+IMAGES_FOLDER+data.deal_image+"' class='product-img product-img-horizontal'/>";}
    },
    { mData: 'deal_title'},
     { mData: 'deal_clicks', "width": "5%", "className": "text-left" },
    { mData: 'category_title', "width": "10%" },
    { "mData": null , "width": "5%", "className":"text-left",
     "mRender" : function (data) {
        return '<span>'+formatPrice(data.deal_price, "<?php echo $siteSettings['st_currency']; ?>", "<?php echo $siteSettings['st_currencyposition']; ?>", "<?php echo $siteSettings['st_decimalnumber']; ?>", "<?php echo $siteSettings['st_decimalseparator']; ?>")+'</span>';
      }
    },
    { "mData": null , "width": "7%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.deal_featured == 1) {
        return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
      }else{
        return '<span class="badge badge-pill bg-warning"><i class="dripicons-cross"></i></span>';
        }
      }
    },
    { "mData": null , "width": "7%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.deal_exclusive == 1) {
        return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
      }else{
        return '<span class="badge badge-pill bg-warning"><i class="dripicons-cross"></i></span>';
        }
      }
    },
    { "mData": null , "width": "5%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.deal_status == 1) {
        return '<span class="label badge-pill bg-success"><?php echo _ENABLED; ?></span>';
      }else if (data.deal_status == 2) {
        return '<span class="label badge-pill bg-danger"><?php echo _DISABLED; ?></span>';
      }else if (data.deal_status == 3) {
        return '<span class="label badge-pill bg-warning"><?php echo _PENDING; ?></span>';
      }else if (data.deal_status == 4) {
        return '<span class="label badge-pill bg-danger"><?php echo _REJECTED; ?></span>';
      }else if (data.deal_status == 5) {
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
      return "<a class='btn btn-small btn-info' href='../controller/stats.php?id="+data.deal_id+"'>"+STATS+"</a> <a class='btn btn-small btn-primary' href='../controller/edit_deal.php?id="+data.deal_id+"'>"+EDITITEM+"</a> <a class='btn btn-small btn-danger btn-delete deleteItem' data-url='../controller/delete_deal.php?id="+data.deal_id+"'>"+DELETEITEM+"</a>";}
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
          <h5 class="text-truncate"><?php echo _DEALS; ?></h5>
        </div>

        <div class="row">

          <div class="col-12 c-col-12">

            <a class="btn btn-light" href="../controller/submissions_log.php">
            <i class="fa fa-repeat add-new-i"></i> <?php echo _LOGS; ?>
            </a>

            <a class="btn btn-success" href="../controller/pending.php">
            <?php echo _NEWSUBMISSIONS; ?> (<?php echo get_total_pending_deals(); ?>)
            </a>

            <a class="btn btn-info" href="../controller/drafts.php">
            <?php echo _NEWUPDATES; ?> (<?php echo get_total_drafts(); ?>)
            </a>

            <a class="btn btn-primary" href="../controller/new_deal.php">
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
                        <th><?php echo _TABLEFIELDAUTHOR; ?></th>
                        <th><?php echo _TABLEFIELDIMAGE; ?></th>
                        <th><?php echo _TABLEFIELDTITLE; ?></th>
                        <th><?php echo _TABLEFIELDCLICKS; ?></th>
                        <th><?php echo _TABLEFIELDCATEGORY; ?></th>
                        <th><?php echo _TABLEFIELDPRICE; ?></th>
                        <th><?php echo _TABLEFIELDFEATURED; ?></th>
                        <th><?php echo _TABLEFIELDEXCLUSIVE; ?></th>
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
