<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_subscribers.php",
     "responsive": true,
     "bPaginate":true,
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aaSorting": [[1,'desc']],
     "aoColumns": [
     { mData: 'subscriber_id', "width": "5%", "className": "text-center" },
     { mData: 'subscriber_email'},
  { "mData": null ,
  "width": "14%",
  "className": "text-center",
  'orderable': false,
  'searchable': false,
  "mRender" : function (data) {
    return "<a class='btn btn-small btn-danger btn-delete deleteItem' data-url='../controller/delete_subscriber.php?id="+data.subscriber_id+"'>"+DELETEITEM+"</a>";}
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
          <h5 class="text-truncate"><?php echo _SUBSCRIBERS; ?></h5>
        </div>

        <div class="row">

          <div class="col-12">
            <div class="block table-block mb-4 c-4">

              <div class="row">
                <div class="table-responsive">
                  <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                    <thead>
                      <tr>
                        <th><?php echo _TABLEFIELDID; ?></th>
                        <th><?php echo _TABLEFIELDUSEREMAIL; ?></th>
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