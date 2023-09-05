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
                    <img src="<?php echo $product_image; ?>" alt="">
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> اسم الطالب </th>
                                        <th> المرحلة </th>
                                        <th> رقم الكارت </th>
                                        <th> الرصيد </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM students   ORDER BY id DESC");
                                    $stmt->execute();
                                    $allstudents = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allstudents as $student) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo $student['name']; ?> </td>
                                            <td> <?php echo $student['stage']; ?> </td>
                                            <td> <?php echo $student['card_number']; ?> </td>
                                            <td>
                                                <input type="text" disabled class="form-control new_balance_element" data-id="<?php echo $student['id']; ?>" value="<?php echo $student['balance']; ?>">
                                            </td>
                                            <td>
                                                <?php
                                                if ($student['balance'] >= $last_price_after_step) {
                                                ?>
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                                                        <button type="submit" name="action_step" class="btn btn-primary btn-sm"> مزايدة </button>
                                                    </form>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>

<?php
if (isset($_POST['action_step'])) {
    $product_id = $last_product;
    $action_id = $action_id;
    $student_id = $_POST['student_id'];
    $step_price = $product_step;
    $stmt = $connect->prepare("INSERT INTO action_steps (action_id,student_id,step_price)
    VALUES (:zaction_id,:zstudent_id,:zstep_price)
    ");
    $stmt->execute(array(
        "zaction_id" => $action_id,
        "zstudent_id" => $student_id,
        "zstep_price" => $step_price
    ));
    if ($stmt) {
        // update last price 
        $last_price = $last_price + $step_price;
        $stmt = $connect->prepare("UPDATE auction_page SET last_price = ? WHERE id = ?");
        $stmt->execute(array($last_price, $action_id));
        header("Location:main?dir=auction_page&page=report");
    }
}

?>