<div class="uk-width-1-1 reviews" id="reviews-item">

<h4 class="section_title_details"><?php echo echoOutput($translation['tr_51']); ?> (<?php echo echoOutput($itemDetails['total_reviews']); ?>)</h4>

<hr>

<div class="uk-grid-collapse" uk-grid>

<div class="uk-width-1-2 uk-flex uk-flex-left uk-flex-middle">

	<div class="rating uk-grid-small uk-flex uk-flex-middle" uk-grid>
		<?php if(formatRating($itemDetails['deal_rating'])): ?>
		<div class="uk-width-1-1 uk-width-auto@s">
			<p class="rate"><?php echo formatRating($itemDetails['deal_rating']); ?></p>
		</div>
		<?php endif; ?>
		<div class="uk-width-1-1 uk-width-expand@s uk-margin-remove uk-margin@s">
			<p class="stars">
			<?php echo showStars($itemDetails['deal_rating']); ?>
			</p>
			<span class="total"><?php echo echoOutput($itemDetails['total_reviews']); ?> <?php echo echoOutput($translation['tr_49']); ?></span>
		</div>
	</div>

</div>

<div class="uk-width-1-2 uk-flex uk-flex-right uk-flex-middle">
<a href="#submit-review" class="share" uk-toggle>
<?php echo echoOutput($translation['tr_79']); ?> <i class="ti ti-pencil"></i>
</a>
</div>

</div>

<hr>


<?php if(empty($resultsReviews)): ?>
    <p><?php echo echoOutput($translation['tr_80']); ?></p>
<?php endif; ?>

<?php if(!empty($resultsReviews)): ?>
    <?php foreach($resultsReviews as $item): ?>
        <article class="uk-comment review">
            <header class="uk-comment-header uk-margin-remove">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
                    <div class="avatar">
                        <?php echo firstLetter($item['user_name']); ?>
                    </div>
            </div>
            <div class="uk-width-expand">

                <div class="uk-grid-collapse uk-child-width-1-2" uk-grid>
                    <div class="uk-text-left uk-width-expand">
                        <span class="name uk-margin-remove"><?php echo echoOutput($item['user_name']); ?></span>
                    </div>
                    <div class="uk-text-right uk-width-auto"><span class="rating"><?php echo showStars($item['rating']); ?></span></div>
                </div>

                <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                    <li>
                    <span>
                        <?php echo formatDate($item['created']); ?>
                        <?php if($item['verified']): ?>
                        <span class="verified">
                            <i class="ti ti-check"></i>
                            <?php echo echoOutput($translation['tr_81']); ?></span>
                        <?php endif; ?>
                    </span>
                    </li>
                </ul>
            </div>
            </div>
            </header>
            <?php if(!empty($item['comment'])): ?>
            <div class="uk-comment-body">
            <p class="comment"><?php echo echoOutput($item['comment']); ?></p>
            </div>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(echoOutput($itemDetails['total_reviews']) > 6): ?>
<div class="uk-width-1-1">
    <a href="#reviews-modal" class="uk-button uk-button-default uk-flex uk-flex-center uk-text-capitalize uk-text-normal uk-flex-middle uk-border-rounded uk-text-light" uk-toggle>
    <?php echo echoOutput($translation['tr_82']); ?>
    <i class="ti ti-chevron-right uk-margin-small-left"></i>
    </a>
</div>
<?php endif; ?>

</div>

<?php require './sections/submit-review.php'; ?>
