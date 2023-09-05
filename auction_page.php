<?php
ob_start();
session_start();
include "init.php";
?>
<div class="auction_page">
    <div class="container">
        <div class="data">
            <?php
            // get the product data 
            if (isset($_POST['product_id'])) {
                $product_id = $_POST['product_id'];
                $price = $_POST['price'];
                $stmt = $connect->prepare("INSERT INTO auction_page (product_id,last_price)
    VALUES (:zproduct_id,:zlast_price)");
                $stmt->execute(array(
                    "zproduct_id" => $product_id,
                    "zlast_price" => $price,
                ));
                if ($stmt) {
                    header('Location:main?dir=auction_page&page=report');
                    exit();
                }
            }
            // get the last product to make auction
            $stmt = $connect->prepare("SELECT * FROM auction_page ORDER BY id DESC LIMIT 1");
            $stmt->execute();

            $action_data = $stmt->fetch();
            $last_product = $action_data['product_id'];
            $last_price = $action_data['last_price'];
            $action_id = $action_data['id'];
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
                        <h4 class="price_now"> سعر المزاد الان :: <span> <?php echo $last_price; ?> ريال </span> </h4>
                        <?php
                        $last_price_after_step = $last_price + $product_step;
                        ?>
                        <br>
                        <div class="student_win">
                            <!-- get the last and win student -->
                            <?php
                            $stmt = $connect->prepare("SELECT * FROM action_steps WHERE action_id = ? ORDER BY id DESC LIMIT 1");
                            $stmt->execute(array($action_id));
                            $last_action_step_data = $stmt->fetch();
                            $count = $stmt->rowCount();
                            if ($count > 0) {

                                $student_owner = $last_action_step_data['student_id'];
                                /////////////  get the studen data  ///////////// 
                                $stmt = $connect->prepare("SELECT * FROM students WHERE id = ?");
                                $stmt->execute(array($student_owner));
                                $student_data = $stmt->fetch();
                                $student_name = $student_data['name'];
                            ?>
                                <table class="table table-bordered table-active">
                                    <tr>
                                        <th> اسم الفائز حتي الان </th>
                                        <th> <?php echo $student_name; ?> </th>
                                        <th> السعر النهائي :: <?php echo $last_price ?> ريال </th>
                                    </tr>
                                </table>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <?php
                                if (isset($_SESSION['success_message'])) {
                                    $message = $_SESSION['success_message'];
                                    unset($_SESSION['success_message']);
                                ?>
                                    <?php
                                    ?>
                                    <script src="plugins/jquery/jquery.min.js"></script>
                                    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
                                    <script>
                                        $(function() {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'success',
                                                title: '<?php echo $message; ?>',
                                                showConfirmButton: false,
                                                timer: 2000
                                            })
                                        })
                                    </script>
                                    <?php
                                } elseif (isset($_SESSION['error_messages'])) {
                                    $formerror = $_SESSION['error_messages'];
                                    foreach ($formerror as $error) {
                                    ?>
                                        <div class="alert alert-danger alert-dismissible" style="max-width: 800px; margin:20px">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <?php echo $error; ?>
                                        </div>
                                <?php
                                    }
                                    unset($_SESSION['error_messages']);
                                }
                                ?>

                            </div>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
        </div>
    </div>
</div>
<?php
include $tem . "footer.php";
ob_end_flush();

?>