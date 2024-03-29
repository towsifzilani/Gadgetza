<?php

require_once '../core.php';

$target_dir = "../images/";

// File Uploads settings

function allowedFileExt(){
    return array("jpg", "jpeg", "png", "gif");
}

function allowedFileSize(){

    /*
    
    1Mb = 1048576;
    2Mb = 2097152;
    3Mb = 3145728;
    4Mb = 4194304;

    */

    return 1048576;
}

?>