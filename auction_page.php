<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title> المزاد مباشر </title>
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

<body class="animsition action_body">
    <div class="auction_page">
        <div class="container">
            <div class="data">

                <?php
                // get the last product to make auction
                $stmt = $connect->prepare("SELECT * FROM auction_page ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                $action_data = $stmt->fetch();
                $last_product = $action_data['product_id'];
                $last_price = $action_data['last_price'];
                $action_id = $action_data['id'];
                $last_studdent_win  = $action_data['student_win'];
                if ($last_studdent_win != null) {
                    header("Location:wait_page");
                }
                ////
                $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->execute(array($last_product));
                $product_data = $stmt->fetch();
                $product_name = $product_data['name'];
                $product_start_from = $product_data['price_start_from'];
                $product_step = $product_data['step_price'];
                $product_image = "products/images/" . $product_data['image'];
                ?>
                <!-- DOM/Jquery table start -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="product_action">
                            <a href="index" class="btn return_home"> الرئيسية <i class="fa fa-home"></i> </a>
                            <div class="product_data">

                                <div>
                                    <img src="admin/<?php echo $product_image; ?>" alt="">
                                </div>
                                <div>
                                    <h3> <?php echo $product_name ?> </h3>
                                    <p> المزاد يبدا من :: <span> <?php echo $product_start_from ?> ريال </span> </p>
                                    <p> سعر المزايدة :: <span> <?php echo $product_step ?> ريال </span> </p>
                                </div>
                            </div>
                            <div class="student_win">
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php
    include $tem . "footer.php";
    ob_end_flush();

    ?>