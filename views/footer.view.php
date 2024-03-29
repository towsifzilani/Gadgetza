
<script src="<?php echo $urlPath->assets_js('cookieconsent.min.js'); ?>"></script>
<script src="<?php echo $urlPath->assets_js('nice-select.min.js'); ?>"></script>
<script src="<?php echo $urlPath->assets_js('datatables.min.js'); ?>"></script>
<script src="<?php echo $urlPath->assets_js('datatables.uikit.min.js'); ?>"></script>
<script src="<?php echo $urlPath->assets_js('rating.min.js'); ?>"></script>
<script src="<?php echo $urlPath->assets_js('jquery.upload.js'); ?>"></script>
<script src="<?php echo $urlPath->assets_js('main.js'); ?>"></script>
<script src="<?php echo $urlPath->assets_js('clipboard.min.js'); ?>"></script>

<?php if($settings['st_cookie_consent'] == 1): ?>
<script>
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#efefef",
      "text": "#404040"
    },
    "button": {
      "background": "#8ec760",
      "text": "#ffffff"
    }
  },
  "theme": "classic",
  "content": {
    "message": "<?php echo echoOutput($translation['tr_115']); ?>",
    "dismiss": "<?php echo echoOutput($translation['tr_117']); ?>",
    "link": "<?php echo echoOutput($translation['tr_114']); ?>",
    "href": '<?php echo $urlPath->terms(); ?>'
  }
});
</script>
<?php endif; ?>

</body>
</html>