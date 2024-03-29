<div class="page-title">
<div class="uk-container">
    <h1 class="title"><span><?php echo echoOutput($pageTitle); ?></span></h1>
    <?php if(isset($pageSummary) && !empty($pageSummary)): ?>
    	<p class="summary"><?php echo echoOutput($pageSummary); ?></p>
    <?php endif; ?>
    </div>
</div>