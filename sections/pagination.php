
<?php $pageNum = getNumPage(); ?>


<?php if ($numPages >= 2): ?>

<div class="uk-margin-large-top"></div>

<p class="uk-text-small uk-text-muted"><?php echo echoOutput($translation['tr_52']).' '.$pageNum." - ".$numPages; ?></p>

<hr>

<div class="tas-pagination uk-margin-top">
    <ul class="uk-pagination uk-flex-center" uk-margin>

    <?php if ($pageNum > 1): ?>
    <li><a class="change-page" data-page="<?php echo ($pageNum-1); ?>"><i class="ti ti-chevron-left"></i></a></li>
    <?php endif; ?>

    <?php if ($pageNum > 3): ?>
    <li><a class="change-page" data-page="1">1</a></li>
    <li><span>...</span></li>
    <?php endif; ?>

    <?php if ($pageNum-2 > 0): ?>
        <li>
            <a class="change-page" data-page="<?php echo ($pageNum-2); ?>"><?php echo $pageNum-2 ?></a>
        </li>
    <?php endif; ?>

    <?php if ($pageNum-1 > 0): ?>
        <li>
            <a class="change-page" data-page="<?php echo ($pageNum-1); ?>"><?php echo $pageNum-1 ?></a>
        </li>
    <?php endif; ?>

    <li class="uk-active"><span><?php echo $pageNum ?></span></li>

    <?php if ($pageNum+1 < $numPages+1): ?>
        <li>
            <a class="change-page" data-page="<?php echo ($pageNum+1); ?>"><?php echo $pageNum+1 ?></a>
        </li>
    <?php endif; ?>
    
    <?php if ($pageNum+2 < $numPages+1): ?>
        <li><a class="change-page" data-page="<?php echo ($pageNum+2); ?>"><?php echo $pageNum+2 ?></a></li>
    <?php endif; ?>

    <?php if ($pageNum < $numPages-2): ?>
        <li><span>...</span></li>
        <li><a class="change-page" data-page="<?php echo $numPages; ?>"><?php echo $numPages ?></a></li>
    <?php endif; ?>

    <?php if ($pageNum < $numPages): ?>
    <li><a class="change-page" data-page="<?php echo ($pageNum+1); ?>"><i class="ti ti-chevron-right"></i></a></li>
    <?php endif; ?>

</ul>
    </div>

    <?php endif; ?>

