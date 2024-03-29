<!DOCTYPE html>
<html dir="<?php echo $langDir; ?>" <?php echo (isset($fullHeight)) ? ' class="uk-height-1-1"' : NULL ?>>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0"/>
<link rel="shortcut icon" href="<?php echo $urlPath->image($theme['th_favicon']); ?>">
<?php if(isset($titleSeoHeader) && !empty($titleSeoHeader)): ?>
<title><?php echo echoOutput($titleSeoHeader); ?></title>
<?php endif; ?>
<?php if(isset($descriptionSeoHeader) && !empty($descriptionSeoHeader)): ?>
<meta name="description" content="<?php echo echoOutput($descriptionSeoHeader); ?>">
<?php if(isset($itemDetails) && !empty($itemDetails)): ?>
<?php if(!empty($itemDetails['image'])): ?>
<meta property="og:image" content="<?php echo $urlPath->image($itemDetails['image']); ?>" />
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<link rel="stylesheet" href="<?php echo $urlPath->assets_css('styles.css'); ?>">
<?php if ($langDir == 'rtl'): ?>
<script type="text/javascript"> window.FontAwesomeConfig = { autoReplaceSvg: false }</script>
<link rel="stylesheet" href="<?php echo $urlPath->assets_css('uikit-rtl.css'); ?>">
<link rel="stylesheet" href="<?php echo $urlPath->assets_css('theme-rtl.css'); ?>">
<?php endif;?>
<script src="<?php echo $urlPath->assets_js('jquery.js'); ?>"></script>
<script src="<?php echo $urlPath->assets_js('uikit.js'); ?>"></script>
<script src="<?php echo $urlPath->assets_js('uikit-icons.js'); ?>"></script>
<?php if($settings['st_recaptcha_enable'] == 1): ?>
<script async src="https://www.google.com/recaptcha/api.js"></script>
<?php endif; ?>
<script type="text/javascript">
/* Global js vars */
var SITEURL = "<?php echo SITE_URL; ?>";
var IMAGES_FOLDER = "<?php echo $urlPath->image(); ?>";
var codeDiscount = null;
var plantaxes = null;
</script>
<?php if(isset($settings['st_analytics']) && !empty($settings['st_analytics'])): ?>
<?php echo $settings['st_analytics']; ?>
<?php endif; ?>
</head>

<body <?php echo (isset($fullHeight)) ? 'class="uk-height-1-1"' : NULL ?>>

<!-- <div id="preloader">
<div class="spinner">
<div class="uil-ripple-css" style="transform:scale(0.40);">
<div></div>
<div></div>
</div>
</div>
</div> -->

<?php if($maintenanceMode == 1): ?>
<?php if(isAdmin()): ?>
<div class="uk-alert-danger uk-margin-remove uk-text-center" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><i class="ti ti-alert-triangle uk-margin-small-right"></i> <?php echo echoOutput($translation['tr_maintenancetitle']); ?></p>
</div>
<?php endif; ?>
<?php endif; ?>

<?php if(isLogged()): ?>
<?php if($userInfo['user_verified'] == 0): ?>
<div class="tas-notify-warning uk-margin-remove uk-text-center uk-flex uk-flex-middle uk-flex-center" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p class="uk-margin-remove uk-text-small"><?php echo echoOutput($translation['tr_457']); ?></p>
    <a class="uk-button tas-notify-btn uk-margin-small-left uk-button-small uk-border-pill" href="<?php echo $urlPath->verify(['user' => echoOutput($userInfo['user_email'])]); ?>"><?php echo echoOutput($translation['tr_458']); ?></a>
</div>
<?php endif; ?>
<?php endif; ?>

<?php require './sections/sidemenu.php'; ?>
