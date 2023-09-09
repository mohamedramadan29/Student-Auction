<?php
ob_start();
session_start();
include "init.php";
?>
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