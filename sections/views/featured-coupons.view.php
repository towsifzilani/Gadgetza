
<?php
    $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
    $cid = isset($_GET['cid']) && !empty($_GET['cid']) ? $_GET['cid'] : '';
?>
<div
    class="uk-container uk-margin-large-top uk-margin-large-bottom"
    uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100"
>
    <div
        class="tas_heading uk-grid-collapse uk-flex uk-flex-middle uk-grid uk-scrollspy-inview uk-animation-fade"
        uk-grid=""
        style=""
    >
        <div class="uk-width-expand uk-first-column">
            <h3 class="uk-heading-line uk-text-left">
                <span>Featured Coupons</span>
            </h3>
        </div>
        <div class="uk-width-auto">
            <a href="<?php echo $urlPath->search(['filter' => 'featured-coupon']); ?>" class="uk-button uk-button-default uk-border-pill btn">
                <?php echo echoOutput($translation['tr_21']); ?>
                <i class="ti ti-chevron-right"></i>
            </a>
        </div>
    </div>

    <div
        class="uk-grid-medium uk-grid-match uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-3@l uk-grid uk-scrollspy-inview uk-animation-fade"
        uk-grid=""
        style=""
    >
    <?php foreach($featuredCoupons as $item): ?>
        <div class="tas_card_6 uk-first-column">
            <div class="uk-card uk-card-default uk-border-rounded">
                <div class="uk-card-media-top uk-cover-container">
                    <a
                        class="c-open2 copen2_<?php echo $item['coupon_id'] ?>"
                        data-redirect="<?php echo echoOutput($item['coupon_link']); ?>"
                        data-id="<?php echo $item['coupon_id'] ?>" 
                        data-title="<?php echo $item['coupon_title'] ?>" 
                        data-description="<?php echo $item['coupon_description'] ?>"
                        data-couponcode="<?php echo $item['coupon_code'] ?>" 
                        data-couponimage="<?php echo $urlPath->image($item['coupon_image']);  ?>"
                        data-storetitle="<?php echo $item['store_title'];  ?>" 
                        data-storeslug="<?php echo $item['store_slug'];  ?>" 
                        href="#"
                        issubmitted="<?php if(in_array($item['coupon_id'], array_column($hasFeedbackFeatured, 'coupon_id'))) echo "1"; else echo "0"; ?>"
                    >
                        <img
                            src="<?php echo $urlPath->image($item['coupon_image']); ?>" 
                            alt="<?php echo echoOutput($item['coupon_title']); ?>"
                            uk-cover=""
                            class="uk-cover"
                            style="height: 205px; width: 380px"
                        />
                    </a>
                </div>

                <div class="uk-card-body">
                    <a
                        class="c-open2 copen2_<?php echo $item['coupon_id'] ?>"
                        data-redirect="<?php echo echoOutput($item['coupon_link']); ?>"
                        data-id="<?php echo $item['coupon_id'] ?>" 
                        data-title="<?php echo $item['coupon_title'] ?>" 
                        data-description="<?php echo $item['coupon_description'] ?>"
                        data-couponcode="<?php echo $item['coupon_code'] ?>" 
                        data-couponimage="<?php echo $urlPath->image($item['coupon_image']);  ?>"
                        data-storetitle="<?php echo $item['store_title'];  ?>" 
                        data-storeslug="<?php echo $item['store_slug'];  ?>" 
                        href="#"
                        issubmitted="<?php if(in_array($item['coupon_id'], array_column($hasFeedbackFeatured, 'coupon_id'))) echo "1"; else echo "0"; ?>"
                    >
                        <h2 class="uk-card-title uk-text-truncate">
                        <?php echo echoOutput($item['coupon_title']); ?>
                        </h2>
                    </a>

                    <div
                        class="uk-grid-collapse uk-child-width-1-2 info uk-grid uk-grid-stack"
                        uk-grid=""
                    >
                        <div class="uk-text-left uk-first-column">
                            <span
                                ><div class="verified">
                                    <i class="ti ti-check"></i> Verified
                                </div></span
                            >
                        </div>
                    </div>

                    <a
                        class="uk-button uk-width-1-1 btn c-open2 copen2_<?php echo $item['coupon_id'] ?>"
                        data-redirect="<?php echo echoOutput($item['coupon_link']); ?>"
                        data-id="<?php echo $item['coupon_id'] ?>" 
                        data-title="<?php echo $item['coupon_title'] ?>" 
                        data-description="<?php echo $item['coupon_description'] ?>"
                        data-couponcode="<?php echo $item['coupon_code'] ?>" 
                        data-couponimage="<?php echo $urlPath->image($item['coupon_image']);  ?>" 
                        data-storetitle="<?php echo $item['store_title'];  ?>" 
                        data-storeslug="<?php echo $item['store_slug'];  ?>" 
                        href="#"
                        issubmitted="<?php if(in_array($item['coupon_id'], array_column($hasFeedbackFeatured, 'coupon_id'))) echo "1"; else echo "0"; ?>"
                    >
                        Get Code
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<div
    class="uk-open uk-modal"
    id="singleModal2"
    uk-modal=""
    style="display: none"
    tabindex="-1"
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
                id="modalImage2"
                class="image"
                src="https://wicombit.com/demo/couponza/images/store_1636012768.jpg"
            />
            <h2 class="title" id="modalTitle2">Up to 50% Off Udemy Courses</h2>
            <p>
                Copy and paste this code at
                <a
                    id="modalStoreSlug2"
                    href="https://wicombit.com/demo/couponza/redirect/19"
                    target="_blank"
                    ></a
                >
            </p>

            <div class="coupon">
                <div>
                    <p class="uk-text-secondary uk-text-bold" id="modalCouponCode2">50OFFNEW</p>
                </div>
                <div>
                    <a
                        class="uk-button uk-button-primary uk-border-pill uk-text-bold copy2"
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
                        ><i class="ti ti-mood-sad"></i> No</a
                    >
                    <a class="like coupon_like uk-text-secondary" data-item="19"
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
        <p class="uk-margin-small-top uk-text-small" id="modalCouponDescription2">
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
                        id="facebook2"
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
                        id="twitter2"
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

                <!-- <div>
                    <a
                        class="resp-sharing-button__link"
                        href="https://pinterest.com/pin/create/button/?url=https://wicombit.com/demo/couponza/store/udemy/?c=19&amp;media=https://wicombit.com/demo/couponza/store/udemy/?c=19&amp;description=Up to 50% Off Udemy Courses"
                        target="_blank"
                        rel="noopener"
                        aria-label="Pinterest"
                    >
                        <div
                            class="resp-sharing-button resp-sharing-button--pinterest resp-sharing-button--medium"
                        >
                            <div
                                aria-hidden="true"
                                class="resp-sharing-button__icon resp-sharing-button__icon--solid"
                            >
                                <i class="ti ti-brand-pinterest"></i>
                            </div>
                        </div>
                    </a>
                </div> -->

                <div>
                    <a
                        class="resp-sharing-button__link"
                        href="whatsapp://send?text=Up to 50% Off Udemy Courses%20https://wicombit.com/demo/couponza/store/udemy/?c=19"
                        target="_blank"
                        rel="noopener"
                        aria-label="WhatsApp"
                        id="whatsapp2"
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
                        id="telegram2"
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
    // Function to open the modal and redirect to the specified link
    function openModalAndRedirect(link, items) {
        // Open the modal
        UIkit.modal('#singleModal2').show();

        $('#singleModal2').data('couponId', items.id);
        $('#modalImage2').attr('src', items.couponimage);
        $('#modalTitle2').text(items.title);
        $('#modalCouponCode2').text(items.couponcode);
        $('#modalCouponDescription2').text(items.description);
        $('#modalCouponLink2').attr('href', link);
        $('#modalStoreSlug2').attr('href',link);
        $('#modalStoreSlug2').text(items.storetitle);
        $('#singleModal2 .coupon_like, #singleModal2 .coupon_deslike').attr("data-item",items.id);

        if(items.isFeedbackSubmitted=="1") {
            $("#singleModal2 .likes").hide();
            $("#singleModal2 .thanks").removeClass("uk-hidden");
        } else {
            $("#singleModal2 .likes").show();
            $("#singleModal2 .thanks").addClass("uk-hidden")
        }

        var facebookShareLink = "https://facebook.com/sharer/sharer.php?u=" + encodeURIComponent(scheme+ "://" +domain + "/search?filter=all-coupons&cid="+items.id);
        $('#facebook2').attr('href', facebookShareLink);
        
        var twitterShareLink = "https://twitter.com/intent/tweet/?text=" + encodeURIComponent(items.title) + "&url=" + encodeURIComponent(scheme+ "://" +domain + "/search?filter=all-coupons&cid="+items.id);
        $('#twitter2').attr('href', twitterShareLink);

        var whatsappShareLink = "whatsapp://send?text=" + encodeURIComponent(items.title) + ' ' + encodeURIComponent(scheme+ "://" +domain + "/search?filter=all-coupons&cid="+items.id);
        $('#whatsapp2').attr('href', whatsappShareLink);

        var telegramShareLink = "https://telegram.me/share/url?text=" + encodeURIComponent(items.title) + "&url=" + encodeURIComponent(scheme+ "://" +domain + "/search?filter=all-coupons&cid="+items.id);
        $('#telegram2').attr('href', telegramShareLink);

        // Open the redirect link in a new tab
        window.open(link, '_blank');
    }

        // Hide the modal initially
        UIkit.modal('#singleModal2').hide();

    // Attach click event handler to all "Get Code" buttons
    $('.c-open2').on('click', function (e) {
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
        $('.c-open2[data-id="' + cid + '"]').click();
    }

    // Attach click event handler to the "Copy" button inside the modal
    $('.copy2').on('click', function () {
        // Select the text in the coupon code element
        var couponCodeElement = document.getElementById('modalCouponCode2');
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
        $('.copy2').text('Copy');
    }

    // Add event listener to the modal close event
    UIkit.util.on('#singleModal2', 'hidden', function () {
        // Reset the "Copy" text
        resetCopyText();
    });
    var userId = "<?php if(isset($userInfo['user_id'])) echo $userInfo['user_id']; else echo ""; ?>";

    $('#singleModal2 .coupon_like,#singleModal2 .coupon_deslike').on('click', function () {
        var couponId = $('#singleModal2').data('couponId');
        var feedback = $(this).hasClass('coupon_like') ? 'like' : 'dislike';

        // alert(couponId);
        // alert(feedback);

        // Send AJAX request to submit feedback
        $.ajax({
            url: 'sections/views/feedbackSubmission.php', // Replace with the actual PHP file handling feedback
            type: 'POST',
            data: { coupon_id: couponId, feedback: feedback, user_id: userId },
            dataType: 'json',
            success: function (response) {
                if (response == "0") {
                    // Handle case where feedback is already submitted
                    $("#singleModal2 .likes").hide();
                    $("#singleModal2 .thanks").removeClass('uk-hidden');
                } else if (response == "1") {
                    // Update UI based on successful feedback submission
                    $("#singleModal2 .likes").hide();
                    $("#singleModal2 .thanks").css('display','block');
                    $("#singleModal2 .thanks").removeClass('uk-hidden');
                    $(".copen"+couponId).attr("issubmitted","1")
                    $(".copen2_"+couponId).attr("issubmitted","1")
                } else if (response == "2") {
                    // Handle case where feedback submission failed
                    $("#singleModal2 .likes").hide();
                } 
                else if (response == "3") {
                    // Handle case where feedback submission failed
                    $("#singleModal2 .thanks").css('display','block');
                    $("#singleModal2 .thanks").removeClass('uk-hidden');
                    $("#singleModal2 .thanks").addClass('uk-text-danger').text('Please log in to submit feedback').fadeOut(5000);
                }
                else {
                    // Handle other responses as needed
                    console.error('Feedback submission failed 22222222');
                }
            }
        });
    });
</script>


