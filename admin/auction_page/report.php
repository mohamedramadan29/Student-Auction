<?php
// get the product data 
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $stmt = $connect->prepare("INSERT INTO auction_page (product_id)
    VALUES (:zproduct_id)");
    $stmt->execute(array(
        "zproduct_id" => $product_id
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
        <div class="row">
            <div class="product_action">
                <img src="<?php echo $product_image; ?>" alt="">
                <h3> <?php echo $product_name ?> </h3>
                <p> المزاد يبدا من :: <span> <?php echo $product_start_from ?> ريال </span> </p>
                <p> سعر المزايدة :: <span> <?php echo $product_step ?> </span> ريال </p>
            </div>
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
                                        <th> الحالة </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM students ORDER BY id DESC");
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
                                            <td> <?php
                                                    if ($student['status'] == 1) {
                                                    ?>
                                                    <span class="badge badge-success"> مفعل </span>
                                                <?php
                                                    } else {
                                                ?>
                                                    <span class="badge badge-danger"> غير مفعل </span>
                                                <?php
                                                    } ?>
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