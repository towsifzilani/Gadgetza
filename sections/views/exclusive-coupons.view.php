<?php
    $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
    $cid = isset($_GET['cid']) && !empty($_GET['cid']) ? $_GET['cid'] : '';
?>

<div class="uk-container uk-margin-medium-top uk-margin-large-bottom" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">
    <div class="tas_heading uk-grid-collapse uk-flex uk-flex-middle uk-grid uk-scrollspy-inview uk-animation-fade" uk-grid="" style="">
        <div class="uk-width-expand uk-first-column">
            <h3 class="uk-heading-line uk-text-left"><span>Exclusive Coupons</span></h3>
        </div>
        <div class="uk-width-auto">
            <a href="<?php echo $urlPath->search(['filter' => 'exclusive-coupon']); ?>" class="uk-button uk-button-default uk-border-pill btn">
                <?php echo echoOutput($translation['tr_21']); ?>
                <i class="ti ti-chevron-right"></i>
            </a>
        </div>
    </div>
    
    <div class="uk-grid-medium uk-grid-match uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-2@l uk-grid uk-scrollspy-inview uk-animation-fade" uk-grid="" style="">
        <?php $i=0;
            foreach($exclusiveCoupons as $item): 
        ?>
            <div class="uk-first-column">

                <div class="tas_card_4 uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin uk-grid" uk-grid="">

                    <div class="uk-card-media-left uk-cover-container uk-first-column">
                        <a 
                            class="c-open copen<?php echo $item['coupon_id'] ?>" 
                            data-id="<?php echo $item['coupon_id'] ?>" 
                            data-redirect="<?php echo echoOutput($item['coupon_link']); ?>"
                            data-title="<?php echo $item['coupon_title'] ?>" 
                            data-description="<?php echo $item['coupon_description'] ?>"
                            data-couponcode="<?php echo $item['coupon_code'] ?>" 
                            data-couponimage="<?php echo $urlPath->image($item['coupon_image']);  ?>" 
                            data-storetitle="<?php echo $item['store_title'];  ?>" 
                            data-storeslug="<?php echo $item['store_slug'];  ?>" 
                            href="#"
                            issubmitted="<?php if(in_array($item['coupon_id'], array_column($hasFeedback, 'coupon_id'))) echo "1"; else echo "0"; ?>"
                        >
                            <img 
                                src="<?php echo $urlPath->image($item['coupon_image']); ?>" 
                                alt="<?php echo echoOutput($item['coupon_title']); ?>"
                                uk-cover="" 
                                class="uk-cover" 
                                style="height: 200px; width: 372px;"
                            >
                            <canvas width="600" height="350"></canvas>
                        </a>
                    </div>

                    <div>
                        <div class="uk-card-body">
                            <div class="exclusive">Exclusive</div>
                                <a 
                                    class="c-open copen<?php echo $item['coupon_id'] ?>" 
                                    data-id="<?php echo $item['coupon_id'] ?>" 
                                    data-redirect="<?php echo echoOutput($item['coupon_link']); ?>"
                                    data-title="<?php echo $item['coupon_title'] ?>" 
                                    data-description="<?php echo $item['coupon_description'] ?>"
                                    data-couponcode="<?php echo $item['coupon_code'] ?>" 
                                    data-couponimage="<?php echo $urlPath->image($item['coupon_image']);  ?>" 
                                    data-storetitle="<?php echo $item['store_title'];  ?>" 
                                    data-storeslug="<?php echo $item['store_slug'];  ?>" 
                                    href="#"
                                    issubmitted="<?php if(in_array($item['coupon_id'], array_column($hasFeedback, 'coupon_id'))) echo "1"; else echo "0"; ?>"
                                >
                                    <h3 class="uk-card-title uk-text-truncate">
                                        <?php echo echoOutput($item['coupon_title']); ?>
                                    </h3>
                                </a>
                                <p class="uk-card-subtitle uk-text-truncate"><?php echo echoOutput($item['coupon_tagline']); ?></p>

                                <a 
                                    class="uk-button uk-width-1-1 btn c-open copen<?php echo $item['coupon_id'] ?>" 
                                    data-id="<?php echo $item['coupon_id'] ?>" 
                                    data-redirect="<?php echo echoOutput($item['coupon_link']); ?>"
                                    data-title="<?php echo $item['coupon_title'] ?>" 
                                    data-description="<?php echo $item['coupon_description'] ?>"
                                    data-couponcode="<?php echo $item['coupon_code'] ?>" 
                                    data-couponimage="<?php echo $urlPath->image($item['coupon_image']);  ?>"
                                    data-storetitle="<?php echo $item['store_title'];  ?>" 
                                    data-storeslug="<?php echo $item['store_slug'];  ?>"  
                                    href="#"
                                    issubmitted="<?php if(in_array($item['coupon_id'], array_column($hasFeedback, 'coupon_id'))) echo "1"; else echo "0"; ?>"
                                >
                                Get Code</a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            $i++; 
            endforeach; 
        ?>
    </div>
</div>

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
                    href="https://wicombit.com/demo/couponza/redirect/19"
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
                        href=""
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
                        href=""
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
                        href=""
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
                        href=""
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
    // Function to open the modal and redirect to the specified link
    function openModalAndRedirect(link, items) {
        // Open the modal
        UIkit.modal('#singleModal').show();

        $('#singleModal').data('couponId', items.id);
        $('#modalImage').attr('src', items.couponimage);
        $('#modalTitle').text(items.title);
        $('#modalCouponCode').text(items.couponCode);
        $('#modalCouponDescription').text(items.description);
        $('#modalCouponLink').attr('href', link);

        $('#modalStoreSlug').attr('href',link);
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

    if(cid !== '') {
        $('.c-open[data-id="' + cid + '"]').click();
    }

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

    $('.coupon_like, .coupon_deslike').on('click', function () {
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
                    $(".copen2_"+couponId).attr("issubmitted","1")
                } else if (response == "2") {
                    // Handle case where feedback submission failed
                    $("#singleModal .likes").hide();
                } else if (response == "3") {
                    // Handle case where feedback submission failed
                    $("#singleModal .thanks").css('display','block');
                    $("#singleModal .thanks").removeClass('uk-hidden');
                    $("#singleModal .thanks").addClass('uk-text-danger').text('Please log in to submit feedback').fadeOut(5000);
                }
                else {
                    // Handle other responses as needed
                    console.error('Feedback submission failed 22222222');
                }
            },
        });
    });
</script>


