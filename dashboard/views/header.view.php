    <!DOCTYPE html>
    <html dir="<?php echo $langDir; ?>" <?php echo (isset($fullHeight)) ? 'class="uk-height-1-1"' : NULL ?>>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo $urlPath->image($theme['th_favicon']); ?>">
    <title><?php echo echoOutput($translation['tr_231']); ?></title>
    <link rel="stylesheet" href="./assets/css/uikit.min.css" />
    <link rel="stylesheet" href="./assets/css/flag-icons.min.css" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/sweetalert.css">
    <link rel="stylesheet" href="./assets/css/font/font-fileuploader.css" />
    <link rel="stylesheet" href="./assets/css/jquery.fileuploader.min.css" />
    <script src="./assets/js/jquery.min.js" ></script>
    <script src="./assets/js/uikit.min.js" ></script>
    <script src="./assets/js/uikit-icons.min.js" ></script>
    <script src="./assets/js/chart.min.js" ></script>
    <script src="./assets/js/fileuploader.min.js" ></script>
    <script async src="https://www.google.com/recaptcha/api.js"></script>
    </head>
    <body class="uk-background-muted">
    <script type="text/javascript">
    /* Global js vars */
    var SITEURL = "<?php echo SITE_URL; ?>";
    var IMAGES_FOLDER = "<?php echo $urlPath->image(); ?>";
    var ST_AREYOUSUREDELETE = "<?php echo echoOutput($translation['tr_313']); ?>";
    var ST_AREYOUSUREDISABLE = "<?php echo echoOutput($translation['tr_317']); ?>";
    var ST_AREYOUSUREENABLE = "<?php echo echoOutput($translation['tr_319']); ?>";
    var ST_YOUWILLNOT = "<?php echo echoOutput($translation['tr_314']); ?>";
    var ST_YESDELETE = "<?php echo echoOutput($translation['tr_316']); ?>";
    var ST_YESDISABLE = "<?php echo echoOutput($translation['tr_318']); ?>";
    var ST_YESENABLE = "<?php echo echoOutput($translation['tr_320']); ?>";
    var ST_CANCELBUTTONALERT = "<?php echo echoOutput($translation['tr_315']); ?>";
    var ST_CONFIRMCANCEL = "<?php echo echoOutput($translation['tr_425']); ?>";
    var ST_AREYOUSURECANCEL = "<?php echo echoOutput($translation['tr_426']); ?>";
    var ST_YESCANCEL = "<?php echo echoOutput($translation['tr_427']); ?>";
    var ST_CANCELBUTTON = "<?php echo echoOutput($translation['tr_428']); ?>";
    var ST_PAYCOMPLETED = "<?php echo echoOutput($translation['tr_429']); ?>";
    var ST_PAYUNKNOWN = "<?php echo echoOutput($translation['tr_430']); ?>";
    var ST_AREYOUSUREDELETEACCOUNT = "<?php echo echoOutput($translation['tr_433']); ?>";
    var ST_ALLCLICKS = "<?php echo echoOutput($translation['tr_235']); ?>";
    var ST_UNIQUECLICKS = "<?php echo echoOutput($translation['tr_236']); ?>";
    </script>
