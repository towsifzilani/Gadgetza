<?php include './sections/page-title.php'; ?>

<div class="uk-container">
	<div class="uk-grid-large" uk-grid>

		<div class="uk-width-expand@m">

			<?php if(!empty($itemDetails['page_content'])): ?>
				<?php echo $itemDetails['page_content']; ?>
			<?php endif; ?>

		</div>
	</div>
</div>
