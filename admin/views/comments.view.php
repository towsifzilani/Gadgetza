<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<style>
  .comment{
    max-width: 400px; overflow: hidden; text-overflow: ellipsis;
  }
</style>

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_comments.php",
     "responsive": true,
     "bPaginate":true,
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
    { mData: 'id'},
    { "mData": null ,
    "mRender" : function (data) {
      return "<div class='comment'>"+data.comment+"</div>"}
    },
    { mData: 'rating'},
    { "mData": null ,
    "width": "10%",
    "className": "text-center",
    "mRender" : function (data) {
      return "<a href='../controller/edit_user.php?id="+data.user_id+"' class='btn-link' target='_blank'>"+data.user_name+"</a>";}
    },
    { mData: 'created', "width": "15%"},
    { "mData": null , "width": "5%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.status == 1) {
        return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
      }else{
        return '<span class="badge badge-pill bg-danger"><i class="dripicons-cross"></i></span>';
      }
    }
  },
  { "mData": null , "width": "5%", "className":"status text-center",
     "mRender" : function (data) {
      if (data.verified == 1) {
        return '<span class="badge badge-pill bg-success"><i class="dripicons-checkmark"></i></span>';
      }else{
        return '<span class="badge badge-pill bg-danger"><i class="dripicons-cross"></i></span>';
      }
    }
  },
    { "mData": null ,
    "width": "5%",
    "className": "text-center",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      if (data.status == 0) {
      return "<a class='btn btn-small btn-info' href='../controller/approve_comment.php?id="+data.id+"'>"+APPROVEITEM+"</a>";
    }else{
        return null;
      }
    }
    },
    { "mData": null ,
    "width": "5%",
    "className": "text-center",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      if (data.verified == 0) {
      return "<a class='btn btn-small btn-primary' href='../controller/verify_comment.php?id="+data.id+"'>"+VERIFYITEM+"</a>";
      }else{
        return null;
      }
    }
    },
    { "mData": null ,
    "width": "5%",
    "className": "text-center",
    'orderable': false,
    'searchable': false,
    "mRender" : function (data) {
      return "<a class='btn btn-small btn-danger btn-delete deleteItem' data-url='../controller/delete_comment.php?id="+data.id+"'>"+DELETEITEM+"</a>";
    }
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
          <h5 class="text-truncate"><?php echo _COMMENTS; ?></h5>
        </div>

        <div class="row">

          <div class="col-12 c-col-12"></div>

          <div class="col-12">
            <div class="block table-block mb-4 c-4">

              <div class="row">
                <div class="table-responsive">
                  <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
                    <thead>
                      <tr>
                        <th><?php echo _TABLEFIELDID; ?></th>
                        <th><?php echo _TABLEFIELDCONTENT; ?></th>
                        <th><?php echo _TABLEFIELDRATING; ?></th>
                        <th><?php echo _TABLEFIELDNAME; ?></th>
                        <th><?php echo _TABLEFIELDCREATED; ?></th>
                        <th><?php echo _TABLEFIELDSTATUS; ?></th>
                        <th><?php echo _TABLEFIELDVERIFIED; ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
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