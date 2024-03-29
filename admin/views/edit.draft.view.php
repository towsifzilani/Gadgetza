<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<!--Page Container--> 
<section class="page-container">
  <div class="page-content-wrapper">

    <!--Main Content-->

    <div class="content sm-gutter">
      <div class="container-fluid padding-25 sm-padding-10">
        <div class="row">
          <div class="col-12">
            <div class="section-title">
              <h5><?php echo _EDITITEM; ?></h5>
            </div>
          </div>

          <div class="col-md-12">

          <?php if(!empty($success)): ?>
          <div class="d-flex align-items-center alert alert-success" role="alert">
          <i class="icon dripicons-checkmark"></i> <?php echo $success; ?>
          </div>
          <?php endif; ?>

          <?php if(!empty($errors)): ?>
          <div class="alert alert-danger" role="alert">
          <ul>
          <?php foreach($errors as $key => $value):?>
          <li><?php echo $value; ?></li>
          <?php endforeach; ?>
          </ul>
          </div>
          <?php endif; ?>

            <div>
              <table>
                <tr>
                  <td><p><b><?php echo _AUTHORBY; ?> </b> <a class="link-primary" href="../controller/edit_user.php?id=<?php echo $deal['deal_author']; ?>"><?php echo $deal['author_name']; ?></a></p></td>
                  <td><p><b><?php echo _UPDATED; ?> </b> <?php echo FormatDate($deal['deal_updated']); ?></p></td>
                </tr>
              </table>
            </div>

            <div class="form-block mb-4">

              <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $deal['deal_id']; ?>" method="post">

              <input type="hidden" value="<?php echo $userInfo['user_id']; ?>" name="reviewer_id">

               <div class="form-row">
                <div class="form-group col-12 col-lg-9">
                  <div class="block col-md-12">

        <div class="row">

        <div class="col-12 col-md-12 col-lg-6">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDTITLE; ?></p>
        <h6><?php echo echoOutput($deal['deal_title']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDDESCRIPTION; ?></p>
        <textarea type="text" class="advancedtinymce form-control" name="deal_description"><?php echo $deal['deal_description']; ?></textarea>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDTAGLINE; ?></p>
        <h6><?php echo echoOutput($deal['deal_tagline']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDCATEGORY; ?></p>
        <h6><?php echo echoOutput($deal['category_title']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDSUBCATEGORY; ?></p>
        <h6><?php echo echoOutput($deal['subcategory_title']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDSTORE; ?></p>
        <h6><?php echo echoOutput($deal['store_title']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDLOCATIONS; ?></p>
        <h6><?php echo echoOutput($deal['location_title']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDPRICE; ?></p>
        <h6><?php echo $siteSettings['st_currency'] ?><?php echo echoOutput($deal['deal_price']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDOLDPRICE; ?></p>
        <h6><?php echo $siteSettings['st_currency'] ?><?php echo echoOutput($deal['deal_oldprice']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDEXPIRE; ?></p>
        <h6><?php echo echoOutput($deal['deal_expire']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDURLLINK; ?></p>
        <h6><?php echo echoOutput($deal['deal_link']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDVIDEO; ?></p>
        <h6><?php echo echoOutput($deal['deal_video']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDGIF; ?></p>
        <h6><?php echo echoOutput($deal['deal_gif']); ?></h6>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDIMAGE; ?></p>
        <div class="new-image" id="image-preview" style="width: 500px; height: 200px; max-width:100%; background: url(<?php echo $target_dir; ?><?php echo $deal['deal_image'] ?>);">
        </div>
        <span class="text-danger recomendedsize"><?php echo _RECOMMENDEDSIZE; ?> <b>650 x 350</b> </span>
        </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
        <div class="mt-3 mb-3">
        <p class="label text-capitalize mb-1"><?php echo _TABLEFIELDGALLERY; ?></p>
        <?php if(!empty($gallery)): ?>
        <div class="gallery">
          <?php foreach($gallery as $item): ?>
            <div class="image">
            <div class="badge-container" style="background:url(<?php echo $target_dir; ?><?php echo $item['picture']; ?>);">
            <a class="deleteItem" data-url="../controller/delete_gallery.php?id=<?php echo $item['id']; ?>">
            <div class="badge_gallery badge-red"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
            </a>
            </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <h6>-</h6>
        <?php endif; ?>
        </div>
        </div>

        </div>

                  </div>
                </div>

                <div class="form-group col-12 col-lg-3 sidebar">


                <div class="block col-md-12">
                <p class="font-weight-bold"><?php echo _TABLEFIELDAUTHORMESSAGE; ?></p>
                <hr>
                <p class="mb-0"><?php echo echoOutput($deal['author_message']); ?></p>
                </div>

                <div class="block col-md-12">

                <label><?php echo _REPLYTOAUTHOR; ?></label>
                <textarea type="text" class="form-control" name="reviewer_message" required=""></textarea>
                <br/>
                <br/>
                <button class="btn btn-success" type="submit" value="approved" name="submit"><?php echo _APPROVEITEM; ?></button>
                <button class="btn btn-info" type="submit" value="cancel" name="submit"><?php echo _CANCELITEM; ?></button>
                </div>

              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</section>
<?php require 'footer.php'; ?>
