<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_deals_by_user.php?user=<?php echo echoOutput($usr['user_id']); ?>",
     "responsive": true,
     "bPaginate":true,
     "aaSorting": [[1,'desc']],
     "sPaginationType":"full_numbers",
     "iDisplayLength": 5,
     "aoColumns": [
     { mData: 'deal_id', "width": "5%", "className": "text-center" },
     { "mData": null , "width": "12%", "className": "product text-center",
     "mRender" : function (data) {
      return "<img src='"+IMAGES_FOLDER+data.deal_image+"' class='product-img product-img-horizontal'/>";}
    },
    { mData: 'deal_title'},
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
        <div class="row">
          <div class="col-12">
            <div class="section-title">
              <h5><?php echo _DETAILSITEM; ?></h5>
            </div>
          </div>

          <div class="col-md-12">
          
            <div class="block form-block mb-4">

          <div class="row">

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDUSERNAME; ?></p>
          <h6><?php echo echoOutput($usr['user_name']); ?></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDUSEREMAIL; ?></p>
          <h6><?php echo echoOutput($usr['user_email']); ?></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDAVATAR; ?></p>
          <h6 class="text-truncate"><a target="_blank" href="<?php echo $target_dir; ?><?php echo $usr['user_avatar']; ?>"><?php echo $usr['user_avatar']; ?></a></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDIP; ?></p>
          <h6><?php echo echoOutput($usr['user_ip']); ?></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDDEVICE; ?></p>
          <h6 class="text-capitalize"><?php echo echoOutput($usr['user_device']); ?></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDCOUNTRY; ?></p>
          <h6><?php echo echoOutput($usr['user_country']); ?></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDSTATUS; ?></p>
          <h6><?php echo ($usr['user_status'] == 1 ? '<span class="text-success">'._ACTIVE.'</span>' : '<span class="text-danger">'._INACTIVE.'</span>' ); ?></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDVERIFIED; ?></p>
          <h6><?php echo ($usr['user_verified'] == 1 ? '<span class="text-success">'._YESTEXT.'</span>' : '<span class="text-danger">'._NOTEXT.'</span>' ); ?></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDUSERROLE; ?></p>
          <h6><?php echo echoOutput($usr['role_title']); ?></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDCREATED; ?></p>
          <h6><?php echo formatDate($usr['user_created']); ?></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDUPDATED; ?></p>
          <h6><?php echo formatDate($usr['user_updated']); ?></h6>
          </div>
          </div>

          <div class="col-6 col-md-4 col-lg-2">
          <div class="mt-3 mb-3">
          <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDACTIVATED; ?></p>
          <h6><?php echo (!empty($usr['user_activation_at']) ? formatDate($usr['user_activation_at']) : "-"); ?></h6>
          </div>
          </div>

          </div>

            </div>

          </div>


          <div class="col-md-12">

            <div class="block form-block mb-4">

            <h6><?php echo _BILLINGINFO; ?></h6>

            <hr>

            <div class="row">

            <div class="col-md-12">

            <?php if(!empty($usrBilling)): ?>
              
            <div class="row">

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _BILLINGFULLNAME; ?></p>
            <h6><?php echo echoOutput($usrBilling->user_billing_name); ?></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _BILLINGCOMPANY; ?></p>
            <h6><?php echo echoOutput($usrBilling->user_billing_company); ?></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _BILLINGADDRESS; ?></p>
            <h6><?php echo echoOutput($usrBilling->user_billing_address); ?></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _BILLINGCOUNTRY; ?></p>

            <?php foreach($countriesArray as $item => $value): ?>
            <?php if((!empty($usrBilling) ? $usrBilling->user_billing_country : 0) == $item): ?>
            <h6><?php echo echoOutput($value); ?></h6>
            <?php endif; ?>
            <?php endforeach; ?>
                      
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _BILLINGCITY; ?></p>
            <h6><?php echo echoOutput($usrBilling->user_billing_city); ?></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _BILLINGPOSTALCODE; ?></p>
            <h6><?php echo echoOutput($usrBilling->user_billing_zip); ?></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _BILLINGPHONE; ?></p>
            <h6><?php echo echoOutput($usrBilling->user_billing_phone); ?></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _BILLINGTAXID; ?></p>
            <h6><?php echo echoOutput($usrBilling->user_billing_tax_id); ?></h6>
            </div>
            </div>

            </div>

            <?php else: ?>

            <p class="text-muted"><?php echo _NODATAFOUND; ?></p>

            <?php endif; ?>

            </div>

            </div>

            </div>

          </div>

          <div class="col-md-12">

            <div class="block form-block mb-4">

            <h6><?php echo _PLANDETAILS; ?></h6>

            <hr>

            <div class="row">

            <div class="col-md-12">

            <?php if(!empty($planDetails)): ?>

            <div class="row">

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDPLAN; ?></p>
            <h6><a class="text-dark" href="../controller/edit_plan.php?id=<?php echo $usr['user_plan']; ?>"><?php echo echoOutput($planDetails['plan_title']); ?></a></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _PLANEXPIRATIONDATE; ?></p>
            <h6><?php echo echoOutput($usr['user_plan_expiration_date']); ?></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _LASTPROCESSOR; ?></p>
            <h6 class="text-capitalize"><?php echo echoOutput($usr['user_payment_processor']); ?></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _LASTPAYMENTAMOUNT; ?></p>
            <h6><?php echo echoOutput($usr['user_payment_total_amount']); ?> <?php echo echoOutput($usr['user_payment_currency']); ?></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _LASTSUBCRIPTIONID; ?></p>
              <h6><?php echo echoOutput($usr['user_payment_subscription_id']); ?></h6>
            </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
            <div class="mt-3 mb-3">
            <p class="label text-capitalize mb-1"><?php echo _CANCELEDDATE; ?></p>
            <h6><?php echo echoOutput($usr['user_plan_canceled_date']); ?></h6>
            </div>
            </div>

            </div>

            <?php else: ?>

            <p class="text-muted"><?php echo _NODATAFOUND; ?></p>

            <?php endif; ?>

            </div>

            </div>

            </div>

          </div>

          <div class="col-md-12">

          <div class="block form-block mb-4">

          <h6><?php echo _SUBMISSIONSBYUSER; ?></h6>

          <hr>

          <div class="row">

          <div class="col-md-12">

            <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                    <thead>
                      <tr>
                        <th><?php echo _TABLEFIELDID; ?></th>
                        <th><?php echo _TABLEFIELDIMAGE; ?></th>
                        <th><?php echo _TABLEFIELDTITLE; ?></th>
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

          <div class="col-md-12">
          <div class="d-block mt-6">
          <a class="btn btn-primary" href="../controller/edit_user.php?id=<?php echo $usr['user_id']; ?>"><?php echo _EDITITEM; ?></a>
          </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
<?php require 'footer.php'; ?>
