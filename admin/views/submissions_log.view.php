<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_submissions_log.php",
     "responsive": true,
     "bPaginate":true,
     "aaSorting": [[1,'desc']],
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
     { mData: 'item', "width": "5%", "className": "text-center" },
     { mData: 'deal_title'},
     { "mData": null , "width": "8%", "className": "text-left",
     "mRender" : function (data) {
      return "<a class='text-dark' href='../controller/user_details.php?id="+data.author_id+"'>"+data.author_name+"</a>";}
    },
    { mData: 'author_message'},
    { "mData": null , "width": "8%", "className": "text-left",
     "mRender" : function (data) {
      return "<a class='text-dark' href='../controller/user_details.php?id="+data.author_id+"'>"+data.reviewer_name+"</a>";}
    },
    { mData: 'reviewer_message'},
    { "mData": null , "width": "5%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.log_type == "approved") {
        return '<span class="label badge-pill bg-success">'+data.log_type+'</span>';
      }else if (data.log_type == "rejected") {
        return '<span class="label badge-pill bg-danger">'+data.log_type+'</span>';
      }else if (data.log_type == "cancel") {
        return '<span class="label badge-pill bg-info">'+data.log_type+'</span>';
      }else if (data.log_type == "new") {
        return '<span class="label badge-pill bg-warning">'+data.log_type+'</span>';
      }else if (data.log_type == "update") {
        return '<span class="label badge-pill bg-secondary">'+data.log_type+'</span>';
      }
      }
    },
    { mData: 'created'},
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
          <h5><?php echo _SUBMISSIONSLOG; ?></h5>
        </div>

        <div class="row">

          <div class="col-12 c-col-12">

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
                        <th><?php echo _TABLEFIELDAUTHOR; ?></th>
                        <th><?php echo _TABLEFIELDAUTHORMESSAGE; ?></th>
                        <th><?php echo _TABLEFIELDREVIEWER; ?></th>
                        <th><?php echo _TABLEFIELDREVIEWERMESSAGE; ?></th>
                        <th><?php echo _TABLEFIELDSTATUS; ?></th>
                        <th><?php echo _TABLEFIELDDATE; ?></th>
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
