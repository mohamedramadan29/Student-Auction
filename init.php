<?php
//include 'location_currancy.php';
include 'admin/connect.php';
$tem = "include/";
$css = "themes/css/";
$js = "themes/js/";
$fonts = "themes/fonts/";
$uploads = "uploads/";
//include $tem . "header.php";
if (!isset($nonavbar)) {
    include $tem . "navbar.php";
}
date_default_timezone_set('Asia/Riyadh');
    // user Cookies
