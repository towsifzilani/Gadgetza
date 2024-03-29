<?php if($itemDetails['page_show_title'] == 1): ?>
<?php include './sections/page-title.php'; ?>
<?php else: ?>
<div class="uk-margin-medium-top"></div>
<?php endif; ?>

<?php if($itemDetails['page_ad_header'] == 1): ?>
<?php include './sections/views/header-ad.view.php'; ?>
<?php endif; ?>

<?php
    $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
    $cid = isset($_GET['cid']) && !empty($_GET['cid']) ? $_GET['cid'] : '';
?>

<div class="uk-container page">
    <div class="uk-grid-large" uk-grid>

        <!-- SIDEBAR -->
        <div class="uk-width-1-1 uk-width-1-4@m sidebar uk-visible@m">
        
            <?php require './sections/views/search-form-coupons.view.php'; ?>

        </div>
        <!-- END SIDEBAR -->

        <!-- CONTENT -->
        <div class="uk-width-1-1 uk-width-expand@m content">

        <?php if(!empty($itemDetails['page_content'])): ?>
        <div class="uk-container">
        <div class="uk-width-1-1">
        <?php echo $itemDetails['page_content']; ?>
        </div>
        </div>
        <?php endif; ?>

        <div class="uk-hidden@m uk-margin-bottom">
            <a class="uk-button uk-button-default uk-border-rounded uk-flex uk-flex-center uk-flex-middle uk-width-1-1 fltr" uk-toggle="target: #searchModal">
            <i class="ti ti-filter uk-text-primary uk-margin-small-right"></i>
            <?php echo echoOutput($translation['tr_90']); ?>
            </a>
        </div>

        <?php if(false !== strpos($_SERVER['REQUEST_URI'], '?')): ?>

            <div class="uk-margin-bottom" uk-grid>
            
            <div class="uk-width-expand uk-flex uk-flex-middle">
            
            <div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slider>
            <ul class="uk-slider-items uk-grid-small" uk-grid>

            <?php if(getQParam()): ?>
                <li>
                    <a class="filterTag" data-value="q">
                        <p><?php echo getQParam(); ?></p>
                        <i class="ti ti-x"></i>
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if(getSearchQuery()): ?>
            <li>
                <a class="filterTag" data-value="query">
                    <p><?php echo echoOutput(getSearchQuery()); ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if(getSlugCategory()): ?>
            <li>
                <a class="filterTag" data-value="category">
                    <p><?php echo getTagCategoryBySlug(getSlugCategory()); ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if(getSlugSubCategory()): ?>
            <li>
                <a class="filterTag" data-value="subcategory">
                    <p><?php echo getTagSubCategoryBySlug(getSlugSubCategory()); ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if(getSlugStore()): ?>
            <li>
                <a class="filterTag" data-value="store">
                    <p><?php echo getTagStoreBySlug(getSlugStore()); ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>
            <?php if(getTypeParam()): ?>
                <li>
                    <a class="filterTag" data-value="type">
                        <p><?php echo getTypeParam(); ?></p>
                        <i class="ti ti-x"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(getFilterParam() && getFilterParam() != "all-coupons"): ?>
            <li>
                <a class="filterTag" data-value="filter">
                    <p>
                        <?php echo echoOutput(getFilterParam()); ?>
                    </p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            </ul>
            </div>
            </div>

            </div>


        <?php endif; ?>

    <div class="uk-grid-small" uk-grid>

    <div class="uk-width-1-2 uk-flex uk-flex-left uk-flex-middle">
        <div>
        <h5 class="uk-text-small uk-margin-remove"><?php echo $total; ?> <?php echo echoOutput($translation['tr_96']); ?></h5>
        </div>
    </div>

    </div>
    <?php if(!empty($items)): ?>
        <div class="uk-grid-medium uk-child-width-1-1 uk-grid uk-grid-stack" uk-grid="">
            <?php foreach($items as $item): 
                if(isset($_GET['cid']) && !empty($_GET['cid'])) {
                    if($item['coupon_id'] != $_GET['cid']) continue;
                }    
            ?>
                <div class="tas_card_5 uk-first-column">
                    <div
                        class="uk-grid-collapse uk-margin card uk-flex uk-flex-middle uk-grid"
                        uk-grid=""
                    >
                        <div class="left uk-width-auto uk-first-column">
                            <div class="uk-cover-container">
                                <img
                                    src="<?php echo $urlPath->image($item['coupon_image']);  ?>"
                                    alt="<?php echo echoOutput($item['coupon_title']); ?>"
                                    uk-cover=""
                                    class="uk-cover"
                                    style="height: 60px; width: 60px"
                                />
                                <canvas width="60" height="60"></canvas>
                            </div>
                        </div>
                        <div class="body uk-width-expand">
                            <div class="uk-grid-small uk-grid" uk-grid="">
                                <div class="uk-width-1-1 uk-width-expand@s uk-first-column">
                                    <h3 class="title"><?php echo echoOutput($item['coupon_title']); ?></h3>
                                    <p class="tagline"><?php echo echoOutput($item['coupon_tagline']); ?></p>
                                </div>
                                <div class="uk-width-1-1 uk-width-auto@s">
                                    <a
                                        class="uk-width-1-1@s uk-button btn c-open copen<?php echo $item['coupon_id']; ?>"
                                        data-id="<?php echo $item['coupon_id'] ?>" 
                                        data-redirect="<?php echo echoOutput($item['coupon_link']); ?>"
                                        data-title="<?php echo $item['coupon_title'] ?>" 
                                        data-description="<?php echo $item['coupon_description'] ?>"
                                        data-couponcode="<?php echo $item['coupon_code'] ?>" 
                                        data-couponimage="<?php echo $urlPath->image($item['coupon_image']);  ?>" 
                                        data-storetitle="<?php echo $item['store_title'];  ?>" 
                                        data-storeslug="<?php echo $item['store_slug'];  ?>" 
                                        href="#"
                                        issubmitted="<?php if(in_array($item['coupon_id'], array_column($hasFeedbackCoupon, 'coupon_id'))) echo "1"; else echo "0"; ?>"
                                    >
                                        Get Code
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="uk-width-1-1 info uk-grid-margin uk-first-column">
                            <div
                                class="uk-grid-small uk-flex uk-flex-middle uk-grid"
                                uk-grid=""
                            >
                                <div class="uk-width-expand uk-text-left uk-first-column">
                                    <ul class="uk-subnav" uk-margin="">
                                    <?php if($item['coupon_verified']==1): ?>
                                        <li class="uk-first-column">
                                            <span
                                                ><div class="verified">
                                                    <i class="ti ti-check"></i> Verified
                                                </div></span
                                            >
                                        </li>
                                        <?php endif; ?>
                                        <?php if($item['coupon_exclusive']==1): ?>
                                        <li>
                                            <span
                                                ><div class="exclusive">
                                                    <i class="ti ti-crown"></i> Exclusive
                                                </div></span
                                            >
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>

                                <div class="uk-width-auto uk-text-right">
                                    <a
                                        class="see_details"
                                        uk-toggle="target: #toggle_<?php echo $item['coupon_id'] ?>; animation: uk-animation-fade"
                                        aria-expanded="false"
                                        >Details</a
                                    >
                                </div>
                            </div>

                            <div class="uk-width-1-1" id="toggle_<?php echo $item['coupon_id'] ?>" hidden="">
                                <p class="details">
                                <?php echo $item['coupon_description'] ?>
                                </p>
                                <hr class="uk-margin-small" />
                                <p class="uk-margin-remove reaction uk-flex uk-flex-middle">
                                    <i class="ti ti-mood-smile uk-text-success"></i>
                                    <span id="totalLikes<?php echo $item['coupon_id'] ?>"><?php echo $item['total_like'] ?></span>
                                    <i class="ti ti-mood-sad uk-text-danger"></i>
                                    <span id="totalDislikes<?php echo $item['coupon_id'] ?>"><?php echo $item['total_dislike'] ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php require './sections/pagination.php'; ?>
    
    <?php endif; ?>

    <?php if(empty($items)): ?>
        <div class="uk-width-1-1 uk-flex uk-flex-center uk-text-center uk-margin-large-top">
        <div class="uk-width-1-1 uk-width-1-2@s">
        <h3 class="uk-text-bold uk-margin-small"><?php echo echoOutput($translation['tr_109']); ?></h3>
        <p class="uk-margin-small"><?php echo echoOutput($translation['tr_110']); ?></p>
        </div>
        </div>
    <?php endif; ?>

        
        </div>
        <!-- END CONTENT -->

    <div>

    <div
    class="uk-open uk-modal"
    id="singleModal"
    uk-modal=""
    style="display: none"
    tabindex="-1"
    bg-close="false"
>
    <div class="tas-modal coupon-modal uk-modal-dialog uk-modal-body">
        <button
            class="uk-modal-close-default c-close uk-icon uk-close"
            type="button"
            uk-close=""
        >
            <svg
                width="14"
                height="14"
                viewBox="0 0 14 14"
                xmlns="http://www.w3.org/2000/svg"
            >
                <line
                    fill="none"
                    stroke="#000"
                    stroke-width="1.1"
                    x1="1"
                    y1="1"
                    x2="13"
                    y2="13"
                ></line>
                <line
                    fill="none"
                    stroke="#000"
                    stroke-width="1.1"
                    x1="13"
                    y1="1"
                    x2="1"
                    y2="13"
                ></line>
            </svg>
        </button>

        <!-- -->

        <div class="uk-text-center">
            <img
                id="modalImage"
                class="image"
                src="https://wicombit.com/demo/couponza/images/store_1636012768.jpg"
            />
            <h2 class="title" id="modalTitle">Up to 50% Off Udemy Courses</h2>
            <p>
                Copy and paste this code at
                <a
                    id="modalStoreSlug"
                    href=""
                    target="_blank"
                    >Udemy</a
                >
            </p>

            <div class="coupon">
                <div>
                    <p class="uk-text-secondary uk-text-bold" id="modalCouponCode">50OFFNEW</p>
                </div>
                <div>
                    <a
                        class="uk-button uk-button-primary uk-border-pill uk-text-bold copy"
                        data-clipboard-text="50OFFNEW"
                        data-copy="Copy"
                        data-copied="Copied!"
                        >Copy</a
                    >
                </div>
            </div>

            <div
                class="uk-grid-small uk-flex uk-flex-middle uk-flex-center likes uk-grid"
                uk-grid=""
            >
                <div class="uk-first-column">
                    <p class="uk-text-small">Did it work?</p>
                </div>
                <div>
                    <a
                        class="deslike coupon_deslike uk-text-secondary"
                        data-item="19"
                        id="coupon_deslike"
                        ><i class="ti ti-mood-sad"></i> No</a
                    >
                    <a class="like coupon_like uk-text-secondary" id="coupon_like" data-item="19"
                        ><i class="ti ti-mood-smile"></i> Yes</a
                    >
                </div>
            </div>

            <p class="uk-text-small thanks uk-hidden">
                Thanks for your feedback
            </p>
            <!-- -->
        </div>

        <!-- -->

        <hr />
        <p class="uk-margin-small-top uk-text-small" id="modalCouponDescription">
            Lorem Ipsum is simply dummy text of the printing and typesetting
            industry. Lorem Ipsum has been the industry's standard dummy text
        </p>

        <hr />

        <div class="uk-width-1-1 share_box">
            <h6 class="uk-margin-small-bottom uk-text-center uk-text-left@s">
                Share This Coupon
            </h6>

            <div
                class="uk-grid-small uk-child-width-1-4 uk-text-center uk-grid"
                uk-grid=""
            >
                <div class="uk-first-column">
                    <a
                        class="resp-sharing-button__link"
                        href="https://facebook.com/sharer/sharer.php?u=https://wicombit.com/demo/couponza/store/udemy/?c=19"
                        target="_blank"
                        rel="noopener"
                        aria-label="Facebook"
                        id="facebook"
                    >
                        <div
                            class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--medium"
                        >
                            <div
                                aria-hidden="true"
                                class="resp-sharing-button__icon resp-sharing-button__icon--solid"
                            >
                                <i class="ti ti-brand-facebook"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div>
                    <a
                        class="resp-sharing-button__link"
                        href="https://twitter.com/intent/tweet/?text=Up to 50% Off Udemy Courses&amp;url=https://wicombit.com/demo/couponza/store/udemy/?c=19"
                        target="_blank"
                        rel="noopener"
                        aria-label="Twitter"
                        id="twitter"
                    >
                        <div
                            class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--medium"
                        >
                            <div
                                aria-hidden="true"
                                class="resp-sharing-button__icon resp-sharing-button__icon--solid"
                            >
                                <i class="ti ti-brand-twitter"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div>
                    <a
                        class="resp-sharing-button__link"
                        href="whatsapp://send?text=Up to 50% Off Udemy Courses%20https://wicombit.com/demo/couponza/store/udemy/?c=19"
                        target="_blank"
                        rel="noopener"
                        aria-label="WhatsApp"
                        id="whatsapp"
                    >
                        <div
                            class="resp-sharing-button resp-sharing-button--whatsapp resp-sharing-button--medium"
                        >
                            <div
                                aria-hidden="true"
                                class="resp-sharing-button__icon resp-sharing-button__icon--solid"
                            >
                                <i class="ti ti-brand-whatsapp"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div>
                    <a
                        class="resp-sharing-button__link"
                        href="https://telegram.me/share/url?text=Up to 50% Off Udemy Courses&amp;url=https://wicombit.com/demo/couponza/store/udemy/?c=19"
                        target="_blank"
                        rel="noopener"
                        aria-label="Share on Telegram"
                        id="telegram"
                    >
                        <div
                            class="resp-sharing-button resp-sharing-button--telegram resp-sharing-button--large"
                        >
                            <div
                                aria-hidden="true"
                                class="resp-sharing-button__icon resp-sharing-button__icon--solid"
                            >
                                <i class="ti ti-brand-telegram"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <hr />
        <p><img src="https://via.placeholder.com/720x120" /></p>
    </div>
</div>

<!-- Include the clipboard.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>


<script>

    var domain = "<?php echo $domain; ?>";
    var scheme = "<?php echo $scheme; ?>";
    var cid = "<?php echo $cid; ?>";

    console.log('cid', cid);
    // Function to open the modal and redirect to the specified link
    function openModalAndRedirect(link, items) {
        // Open the modal
        UIkit.modal('#singleModal').show();
        $('#singleModal').data('couponId', items.id);
        $('#modalImage').attr('src', items.couponimage);
        $('#modalTitle').text(items.title);
        $('#modalCouponCode').text(items.couponcode);
        $('#modalCouponDescription').text(items.description);
        $('#modalCouponLink').attr('href', link);
        $('#modalStoreSlug').attr('href', link);
        $('#modalStoreSlug').text(items.storetitle);
        $('#singleModal .coupon_like, #singleModal .coupon_deslike').attr("data-item",items.id);

        if(items.isFeedbackSubmitted=="1") {
            $("#singleModal .likes").hide();
            $("#singleModal .thanks").removeClass("uk-hidden")
        } else {
            $("#singleModal .likes").show();
            $("#singleModal .thanks").addClass("uk-hidden")
        }

        var facebookShareLink = "https://facebook.com/sharer/sharer.php?u=" + encodeURIComponent(scheme+ "://" +domain + "/search?filter=all-coupons&cid="+items.id);
        $('#facebook').attr('href', facebookShareLink);

        var twitterShareLink = "https://twitter.com/intent/tweet/?text=" + encodeURIComponent(items.title) + "&url=" + encodeURIComponent(scheme+ "://" +domain + "/search?filter=all-coupons&cid="+items.id);
        $('#twitter').attr('href', twitterShareLink);

        var whatsappShareLink = "whatsapp://send?text=" + encodeURIComponent(items.title) + ' ' + encodeURIComponent(scheme+ "://" +domain + "/search?filter=all-coupons&cid="+items.id);
        $('#whatsapp').attr('href', whatsappShareLink);

        var telegramShareLink = "https://telegram.me/share/url?text=" + encodeURIComponent(items.title) + "&url=" + encodeURIComponent(scheme+ "://" +domain + "/search?filter=all-coupons&cid="+items.id);
        $('#telegram').attr('href', telegramShareLink);

        // Open the redirect link in a new tab
        window.open(link, '_blank');
    }

    // Hide the modal initially
    UIkit.modal('#singleModal').hide();

    // Attach click event handler to all "Get Code" buttons
    $('.c-open').on('click', function (e) {
        e.preventDefault(); // Prevent the default behavior of the anchor tag

        // Get the data-redirect attribute value
        var redirectLink = $(this).data('redirect');

        var items = {
            id : $(this).data('id'),
            title : $(this).data('title'),
            description : $(this).data('description'),
            couponcode : $(this).data('couponcode'),
            couponimage : $(this).data('couponimage'),
            storetitle: $(this).data('storetitle'),
            storeslug : $(this).data('storeslug'),
            isFeedbackSubmitted: $(this).attr('issubmitted')
        }

        // Call the function to open the modal and redirect
        openModalAndRedirect(redirectLink, items);
    });

    if(cid !== '') {
        $('.c-open[data-id="' + cid + '"]').click();
    }

    // Attach click event handler to the "Copy" button inside the modal
    $('.copy').on('click', function () {
        // Select the text in the coupon code element
        var couponCodeElement = document.getElementById('modalCouponCode');
        var range = document.createRange();
        range.selectNode(couponCodeElement);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);

        // Execute the copy command
        try {
            document.execCommand('copy');
            // Show "Copied!" message
            $(this).text('Copied!');
        } catch (err) {
            console.error('Unable to copy', err);
            // Handle the error
        } finally {
            // Clear the selection
            window.getSelection().removeAllRanges();
        }
    });

    // Function to reset the "Copy" text
    function resetCopyText() {
        $('.copy').text('Copy');
    }

    // Add event listener to the modal close event
    UIkit.util.on('#singleModal', 'hidden', function () {
        // Reset the "Copy" text
        resetCopyText();
    });


    var userId = "<?php if(isset($userInfo['user_id'])) echo $userInfo['user_id']; else echo ""; ?>";

    $('#coupon_like, #coupon_deslike').on('click', function () {
        var couponId = $('#singleModal').data('couponId');
        var feedback = $(this).hasClass('coupon_like') ? 'like' : 'dislike';

        // Send AJAX request to submit feedback
        $.ajax({
            url: 'sections/views/feedbackSubmission.php', // Replace with the actual PHP file handling feedback
            type: 'POST',
            data: { coupon_id: couponId, feedback: feedback, user_id: userId},
            dataType: 'json',
            success: function (response) {
                if (response == "0") {
                    // Handle case where feedback is already submitted
                    $("#singleModal .likes").hide();
                    $("#singleModal .thanks").removeClass('uk-hidden');
                } else if (response == "1") {
                    // Update UI based on successful feedback submission
                    $("#singleModal .likes").hide();
                    $("#singleModal .thanks").css('display','block');
                    $("#singleModal .thanks").removeClass('uk-hidden');

                    $(".copen"+couponId).attr("issubmitted","1")

                    var getTotalLikesOfThatCoupon = +$("#totalLikes"+couponId).text();
                    var getTotalDisLikesOfThatCoupon = +$("#totalDislikes"+couponId).text();

                    if(feedback == 'like') {
                        $("#totalLikes"+couponId).text(getTotalLikesOfThatCoupon + 1);
                    }
                    if(feedback == 'dislike') {
                        $("#totalDislikes"+couponId).text(getTotalDisLikesOfThatCoupon + 1);
                    }
                } else if (response == "2") {
                    // Handle case where feedback submission failed
                    $("#singleModal .likes").hide();
                } else if (response == "3") {
                    // Handle case where feedback submission failed
                    $("#singleModal .thanks").css('display','block');
                    $("#singleModal .thanks").removeClass('uk-hidden');
                    $("#singleModal .thanks").addClass('uk-text-danger').text('Please log in to submit feedback').fadeOut(5000, function () {
                        // After fadeout, add uk-hidden class and remove uk-text-danger
                        $(this).addClass('uk-hidden').removeClass('uk-text-danger').text('Thank you for your feedback');
                    });;
                }
                else {
                    // Handle other responses as needed
                    console.error('Feedback submission failed 22222222');
                }
            },
        });
    });
</script>

<?php require './sections/views/search-modal.view.php'; ?>
