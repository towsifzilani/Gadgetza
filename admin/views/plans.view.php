<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_plans.php",
     "responsive": true,
     "bPaginate":true,
     "aaSorting": [[1,'desc']],
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
     { mData: 'plan_id', "width": "5%", "className": "text-center" },
     { "mData": null , "width": "15%", "className":"text-left",
     "mRender" : function (data) {
        return '<span>'+data.plan_title+'</span> '+(data.plan_recommended == 1 ? '<small>(Recommended)</small>' : '');
      }
    },
    { "mData": null , "width": "15%", "className":"text-left",
     "mRender" : function (data) {
        return '<span>'+data.plan_monthly+' <?php echo $siteSettings['st_currencycode']; ?></span>';
      }
    },
    { "mData": null , "width": "15%", "className":"text-left",
     "mRender" : function (data) {
        return '<span>'+(data.plan_halfyear ? data.plan_halfyear : '0')+' <?php echo $siteSettings['st_currencycode']; ?></span>';
      }
    },
    { "mData": null , "width": "15%", "className":"text-left",
     "mRender" : function (data) {
        return '<span>'+(data.plan_annual ? data.plan_annual : '0')+' <?php echo $siteSettings['st_currencycode']; ?></span>';
      }
    },
    { "mData": null , "width": "7%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.plan_status == '1') {
        return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
      }else{
        return '<span class="badge badge-pill bg-warning"><i class="dripicons-cross"></i></span>';
        }
      }
    },
    { "mData": null ,
    "width": "14%",
    "className": "text-center",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      return "<a class='btn btn-small btn-primary' href='../controller/edit_plan.php?id="+data.plan_id+"'>"+EDITITEM+"</a> <a class='btn btn-small btn-danger btn-delete deleteItem' data-url='../controller/delete_plan.php?id="+data.plan_id+"'>"+DELETEITEM+"</a>";}
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
          <h5 class="text-truncate"><?php echo _PLANS; ?></h5>
        </div>

        <div class="row">

          <div class="col-12 c-col-12">
            <a class="btn btn-primary" href="../controller/new_plan.php">
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
                        <th><?php echo _TABLEFIELDMONTHLYPRICE; ?></th>
                        <th><?php echo _TABLEFIELDHALFYEARPRICE; ?></th>
                        <th><?php echo _TABLEFIELDANNUALPRICE; ?></th>
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