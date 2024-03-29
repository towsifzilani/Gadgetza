<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Dashboard</title>
    <link href="../assets/images/favicon.png" rel="shortcut icon">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/customScroll/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="../assets/icons/dripicons/dripicons.css">
    <link rel="stylesheet" href="../assets/icons/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/normalize.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/sweetalert.css">
    <link rel="stylesheet" href="../assets/css/lightbox.css">
    <link rel="stylesheet" href="../assets/css/fileuploader.css">
    <link rel="stylesheet" href="../assets/css/checkbox.css">
    <link rel="stylesheet" href="../assets/css/flag-icons.min.css">
    <link rel="stylesheet" href="../assets/css/select2.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-colorpicker.css">
    <link rel="stylesheet" href="../assets/plugins/date-range/daterangepicker.css">

    <script type="text/javascript">
    /* Global js vars */
    var TINYMCELANG = "en";
    var TIMEIN24H = true;
    var IMAGES_FOLDER = "<?php echo $target_dir; ?>";
    var ST_SAVECHANGES = "<?php echo _SAVECHANGES; ?>";
    var ST_CHANGESSAVED = "<?php echo _CHANGESSAVED; ?>";
    var ST_PROCESSING = "<?php echo _PROCESSING; ?>";
    var ST_SENDBUTTON = "<?php echo _EMAILSENDBUTTON; ?>";
    var ST_AREYOUSURE = "<?php echo _AREYOUSURE; ?>";
    var ST_YOUWILLNOT = "<?php echo _YOUWILLNOT; ?>";
    var ST_YESDELETEIT = "<?php echo _YESDELETEIT; ?>";
    var ST_CANCELBUTTONALERT = "<?php echo _CANCELBUTTONALERT; ?>";
    var ST_DUPLICATETITLE = "<?php echo _DUPLICATETITLE; ?>";
    var ST_DUPLICATETEXT = "<?php echo _DUPLICATETEXT; ?>";
    var ST_DUPLICATEDONE = "<?php echo _DUPLICATEDONE; ?>";
    var ST_DUPLICATECOMPLETED = "<?php echo _DUPLICATECOMPLETED; ?>";
    var ST_FILEUPLOADERCHOOSE = "<?php echo _FILEUPLOADERCHOOSE; ?>";
    var ST_FILEUPLOADERSELECT = "<?php echo _FILEUPLOADERSELECT; ?>";
    var ST_FILEUPLOADERYOUHAVE = "<?php echo _FILEUPLOADERYOUHAVE; ?>";
    var ST_FILEUPLOADERFILE = "<?php echo _FILEUPLOADERFILE; ?>";
    var ST_FILEUPLOADERFILES = "<?php echo _FILEUPLOADERFILES; ?>";
    var ST_FILEUPLOADERDELETEALERT = "<?php echo _FILEUPLOADERDELETEALERT; ?>";
    var ST_BYDELETINGTHEUSER = "<?php echo _BYDELETINGTHEUSER; ?>";
    var DETAILSITEM = "<?php echo _DETAILSITEM; ?>";
    var EDITITEM = "<?php echo _EDITITEM; ?>";
    var VIEWITEM = "<?php echo _VIEWITEM; ?>";
    var DELETEITEM = "<?php echo _DELETEITEM; ?>";
    var APPROVEITEM = "<?php echo _APPROVEITEM; ?>";
    var VERIFYITEM = "<?php echo _VERIFYITEM; ?>";
    var REMOVEITEM = "<?php echo _REMOVEITEM; ?>";
    var ENTERVALUE = "<?php echo _ENTERVALUE; ?>";
    var INVOICE = "<?php echo _TABLEFIELDINVOICE; ?>";
    var STATS = "<?php echo _ITEMSTATS; ?>";
    var ALLOWEDFILEEXT = <?php echo json_encode(allowedFileExt()); ?>;
    var ALLOWEDFILESIZE = "<?php echo (allowedFileSize()/1024/1024); ?>";

    </script>

    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../assets/js/sweetalert.js"></script>
    <script src="../assets/js/jquery-ui.js"></script>
    <script src="../assets/js/fileuploader.min.js"></script>
    <script src="../assets/js/jquery.uploadPreview.js"></script>
    <script src="../assets/plugins/tinymce/tinymce.min.js"></script>
    <script src="../assets/js/jquery.mswitch.js"></script>
    <script src="../assets/js/bootstrap-colorpicker.js"></script>
    <script src="../assets/js/header.js"></script>

</head>
<body>