<?php
ob_start();
session_start();
include "init.php";
?>
<!-- Product -->
<div class="bg0 m-t-23 p-b-140">
	<div class="container">
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
									<p> تبدا المزايدة من : <span class="stext-105 cl3">
											<?php echo $product['price_start_from']; ?> ريال
										</span>
									</p>
									<p> المزايدة : <span class="stext-105 cl3">
											<?php echo $product['step_price']; ?> ريال
										</span>
									</p>
								<?php
								}else{
									?>
									<p> تم بيع المنتج  </p>
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