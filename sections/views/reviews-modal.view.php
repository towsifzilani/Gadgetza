<div id="reviews-modal" class="uk-flex-top reviews" uk-modal>
    <div class="tas-modal uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="modal_title"><?php echo echoOutput($translation['tr_51']); ?> (<?php echo echoOutput($itemDetails['total_reviews']); ?>)</h2>
        </div>
        <div class="uk-modal-body" uk-overflow-auto>

        <div id="content">

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

        </div>

        </div>

        <div class="uk-modal-footer">
        
        <?php if(!empty($resultsReviews)): ?>
        <div class="loadmore">
        <button class="uk-button uk-width-1-1 uk-button-primary uk-text-capitalize uk-text-normal uk-border-rounded" value="<?php echo echoOutput($translation['tr_83']); ?>" type="submit" id="loadBtn"><?php echo echoOutput($translation['tr_83']); ?></button>
        <input type="hidden" id="limit" value="<?php echo $site_config['reviews_page']; ?>">
        <input type="hidden" id="page" value="1">
		<input type="hidden" id="itemId" value="<?php echo $itemId; ?>">
        <input type="hidden" id="itemsCount" value="<?php echo $totalReviews; ?>">
        </div> 
        <?php endif; ?>

        </div>
    </div>
</div>