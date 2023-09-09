<?php
// get the product data 
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    $stmt = $connect->prepare("INSERT INTO auction_page (product_id,last_price,date)
    VALUES (:zproduct_id,:zlast_price,:zdate)");
    $stmt->execute(array(
        "zproduct_id" => $product_id,
        "zlast_price" => $price,
        "zdate" => date("Y-m-d")
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
        <div class="card">
            <div class="d-flex justify-content-between" style="padding: 25px;">
                <form action="" method="post">
                    <input type="hidden" name="action_id" value="<?php echo $action_id; ?>">
                    <input type="hidden" name="student_owner" value="<?php echo $student_owner; ?>">
                    <button class="btn btn-primary btn-sm" name="end_auction"> انهاء المزاد <i class="fa fa-check"></i> </button>
                </form>
                <form action="" method="post">
                    <button name="cancel_action" class="btn btn-danger btn-sm"> الغاء المزاد <i class="fa fa-exclamation"></i> </button>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['cancel_action'])) {
            $action_id = $action_id;
            $stmt = $connect->prepare("DELETE FROM auction_page WHERE id = ?");
            $stmt->execute(array($action_id));
            header("Location:main?dir=products&page=report");
        }

        ?>
        <?php
        if (isset($_POST['end_auction'])) {
            $action_id = $action_id;
            $student_owner = $student_owner;
            $stmt = $connect->prepare("UPDATE auction_page SET student_win = ? WHERE id = ?");
            $stmt->execute(array($student_owner, $action_id));
            // update student balance 
            // get the old balance 
            $stmt = $connect->prepare("SELECT * FROM students WHERE id = ?");
            $stmt->execute(array($student_owner));
            $owner_data = $stmt->fetch();
            $owner_data_balance = $owner_data['balance'];
            $new_owner_balance = $owner_data_balance - $last_price;
            // update data 
            $stmt = $connect->prepare("UPDATE students SET balance = ? WHERE id = ?");
            $stmt->execute(array($new_owner_balance, $student_owner));
            // update in student accounts 
            $stmt = $connect->prepare("INSERT INTO student_accounts (student_id,price,date,reason,product_id)
            VALUES(:zstudent_id,:zprice,:zdate,:zreason,:zproduct)
            ");
            $stmt->execute(array(
                "zstudent_id" => $student_owner,
                "zprice" => - ($last_price),
                "zdate" => date("Y-m-d"),
                "zreason" => "شراء منتج من المزاد",
                "zproduct" => $last_product
            ));
            header("Location:main?dir=products&page=report");
        }

        ?>
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
                        <div class="students_data">
                            <div class="row">
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM students ORDER BY name ASC");
                                $stmt->execute();
                                $allstudents = $stmt->fetchAll();
                                foreach ($allstudents as $student) {
                                ?>
                                    <div class="col-lg-3">
                                        <div class="info">
                                            <h3> <?php echo $student['name']; ?> </h3>
                                            <p> <?php echo $student['stage']; ?> </p>
                                            <h2> <?php echo $student['balance']; ?> </h2>
                                            <?php
                                            if ($student['balance'] >= $last_price_after_step) {
                                            ?>
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                                                    <button type="submit" name="action_step" class="btn"> مزايدة </button>
                                                </form>
                                            <?php
                                            } else {
                                            ?>
                                                <button class="btn no-balance"> رصيد غير كافي </button>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
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