<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_drafts.php",
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
    { mData: 'deal_updated'},
    { "mData": null ,
    "width": "14%",
    "className": "text-center",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      return "<a class='btn btn-small btn-primary' href='../controller/edit_draft.php?id="+data.deal_id+"'>"+EDITITEM+"</a>";}
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
          <h5 class="text-truncate"><?php echo _NEWUPDATES; ?></h5>
        </div>

        <div class="row">

          <div class="col-12 c-col-12">
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
                        <th><?php echo _TABLEFIELDDATE; ?></th>
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
