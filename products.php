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

<body class="animsition products">
	<!-- Product -->
	<div class="bg0">
		<div class="container">
			<div class="products_head">
				<div>
					<img src="images/action.png" alt="">
				</div>
				<div>
					<a href="index" class="btn return_home"> الرئيسية <i class="fa fa-home"></i> </a>
				</div>
			</div>
			<div class="row">
				<?php
				$stmt = $connect->prepare("SELECT * FROM products");
				$stmt->execute();
				$allproducts = $stmt->fetchAll();
				foreach ($allproducts as $product) {
				?>
					<div class="col-sm-6 col-md-4 col-lg-3 p-b-35">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="admin/products/images/<?php echo $product['image']; ?>" alt="IMG-PRODUCT">
							</div>
							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										<?php echo $product['name']; ?>
									</a>
									<?php
									if ($product['status'] == 0) {
									?>
										<p style="margin-bottom: 10px;"> تبدا المزايدة من : <span class="stext-105 cl3">
												<?php echo $product['price_start_from']; ?> ريال
											</span>
										</p>
										<p> المزايدة : <span class="stext-105 cl3">
												<?php echo $product['step_price']; ?> ريال
											</span>
										</p>
									<?php
									} else {
									?>
										<p style="color: #006F65;font-weight: bold;margin-top: 10px;"> تم بيع المنتج </p>
									<?php
									}

									?>

								</div>
							</div>
						</div>
					</div>
				<?php
				}

				?>

			</div>

		</div>
	</div>

	<?php
	include $tem . "footer.php";
	ob_end_flush();

	?>