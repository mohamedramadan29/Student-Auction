<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/bank.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.rtl.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="themes/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@500&display=swap" rel="stylesheet">
    <!-- ============================================================================================== -->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="themes/css/util.css">
    <link rel="stylesheet" type="text/css" href="themes/css/main.css">
    <!--===============================================================================================-->
</head>
<?php
ob_start();
session_start();
$nonavbar = "";
include "init.php";
?>

<body class="animsition index_page">

    <div class="home_page">
        <div class="container">
            <div class="index_header">
                <div>
                    <img src="images/programme.png" alt="">
                </div>
                <div>
                    <a href="auction_page" class="btn action_now"> مباشر المزاد الان <i class="fa fa-arrow-left"></i> </a>
                </div>
            </div>
            <div class="data">
                <div class="row">
                    <div class="col-lg-6">
                        <a href="balance">
                            <div class="info">
                                <img src="images/bank.png" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <a href="products">
                            <div class="info">
                                <img src="images/action.png" alt="">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include $tem . "footer.php";
    ob_end_flush();

    ?>