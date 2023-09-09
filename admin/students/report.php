<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> الطلاب </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> الطلاب </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content-header -->
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
<?php
/********************** ADD NEW BALANCE TO STUDENT */ //////
if (isset($_POST['add_balance'])) {
    $balance_amounts = $_POST['balance_amounts'];
    $students_id = $_POST['students_id'];
    // Make sure both arrays have the same number of elements
    if (count($balance_amounts) === count($students_id)) {
        for ($i = 0; $i < count($balance_amounts); $i++) {
            $balance_amount = $balance_amounts[$i];
            $student_id = $students_id[$i];
            if (!empty($balance_amount)) {
                $stmt = $connect->prepare("INSERT INTO student_accounts(student_id, price, date)
                                VALUES(:zstudent_id,:zprice,:zdate)");
                $stmt->execute(array(
                    "zstudent_id" => $student_id,
                    "zprice" => $balance_amount,
                    "zdate" => date("Y-m-d"),
                ));
                if ($stmt) {
                    $stmt = $connect->prepare("SELECT * FROM students WHERE id=?");
                    $stmt->execute(array($student_id));
                    $student_data = $stmt->fetch();
                    $old_balance = $student_data['balance'];
                    $new_balance = $old_balance + $balance_amount;
                    $stmt = $connect->prepare("UPDATE students SET balance = ? WHERE id = ?");
                    $stmt->execute(array($new_balance, $student_id));
                }
                if ($stmt) {
                    $_SESSION['success_message'] = "تم التعديل بنجاح ";
                    header('Location:main?dir=students&page=report');
                }
            }
        }
    } else {
        echo "The number of balance amounts does not match the number of student IDs.";
    }
}
?>
<!-- DOM/Jquery table start -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="" method="post">
                    <div class="card">
                        <div class="card-header ">
                            <button style="margin-left: 20px;" type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> أضافة طالب جديد <i class="fa fa-plus"></i> </button>
                            <button name="add_balance" class="btn btn-danger btn-sm"> اضافة رصيد للكل <i class="fa fa-paypal"></i> </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="my_table2" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> اسم الطالب </th>
                                            <th> المرحلة </th>
                                            <th> رقم الكارت </th>
                                            <th> الرصيد </th>
                                            <th> المنتجات </th>
                                            <th> التحكم في الرصيد </th>
                                            <th> كشف حساب </th>
                                            <th> </th>
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
                                                <td> <?php echo $i;    ?> </td>
                                                <td> <?php echo $student['name']; ?> </td>
                                                <td> <?php echo $student['stage']; ?> </td>
                                                <td> <?php echo $student['card_number']; ?> </td>
                                                <td>
                                                    <input type="text" disabled class="form-control new_balance_element" data-id="<?php echo $student['id']; ?>" value="<?php echo $student['balance']; ?>">
                                                </td>
                                                <td> <a href="main.php?dir=students&page=student_win_products&student_id=<?php echo $student['id']; ?>" class="btn btn-primary btn-sm"> منتجات الطالب </a>
                                                    <!-- get the products number student win -->
                                                    <?php
                                                    $stmt = $connect->prepare("SELECT * FROM auction_page WHERE student_win = ?");
                                                    $stmt->execute(array($student['id']));
                                                    $product_sum = count($stmt->fetchAll());
                                                    ?>
                                                    <span class="badge badge-warning"> <?php echo $product_sum ?> </span>
                                                </td>
                                                <td>
                                                    <input name="students_id[]" type="hidden" value="<?php echo $student['id']; ?>">
                                                    <input name="balance_amounts[]" type="number" class="form-control balance-input" data-student-id="<?php echo $student['id']; ?>" placeholder="ادخال رصيد">
                                                </td>
                                                <td> <a href="main.php?dir=students&page=accounts_report&student_id=<?php echo $student['id']; ?>" class="btn btn-info btn-sm"> كشف حساب </a> </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $student['id']; ?>"> <i class='fa fa-pen'></i> </button>
                                                    <a href="main.php?dir=students&page=delete&cat_id=<?php echo $student['id']; ?>" class="confirm btn btn-danger btn-sm"> <i class='fa fa-trash'></i> </a>
                                                </td>
                                            </tr>
                </form>
                <!-- EDIT NEW CATEGORY MODAL   -->
                <div class="modal fade" id="edit-Modal_<?php echo $student['id']; ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> تعديل الطالب </h4>
                            </div>
                            <form method="post" action="main.php?dir=students&page=edit" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type='hidden' name="student_id" value="<?php echo $student['id']; ?>">
                                        <label for="Company-2" class="block">الأسم </label>
                                        <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo  $student['name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> المرحلة </label>
                                        <select required name="stage" id="" class="select2">
                                            <option value=""> اختر المرحلة </option>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM eduction_level");
                                            $stmt->execute();
                                            $allstags = $stmt->fetchAll();
                                            foreach ($allstags as $stag) {
                                            ?>
                                                <option <?php if ($stag['level_name'] == $student['stage']) echo 'selected'; ?> value="<?php echo $stag['level_name']; ?>"> <?php echo $stag['level_name']; ?> </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> رقم البطاقة </label>
                                        <input required id="Company-2" name="card_number" type="number" class="form-control required" value="<?php echo  $student['card_number'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الرصيد </label>
                                        <input required id="Company-2" name="balance" type="number" class="form-control required" value="<?php echo  $student['balance'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> حالة الطالب </label>
                                        <select name="status" class="form-control select2" id="">
                                            <option value=""> حالة الطالب </option>
                                            <option <?php if ($student['status'] == 1) echo 'selected'; ?> value="1"> مفعل </option>
                                            <option <?php if ($student['status'] == 0) echo 'selected'; ?> value="0">غير مفعل </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="edit_cat" class="btn btn-primary waves-effect waves-light "> تعديل </button>
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">رجوع</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                                        }
            ?>
            </table>
            </div>
        </div>
    </div>

    <!-- ADD NEW CATEGORY MODAL   -->
    <div class="modal fade" id="add-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">أضافة طالب </h4>
                </div>
                <form action="main.php?dir=students&page=add" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Company-2" class="block"> الأسم </label>
                            <input required id="Company-2" name="name" type="text" class="form-control required" value="<?php if (isset($_REQUEST['name'])) echo $_REQUEST['name']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="Company-2" class="block"> المرحلة </label>
                            <select required name="stage" id="" class="select2">
                                <option value=""> اختر المرحلة </option>
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM eduction_level");
                                $stmt->execute();
                                $allstags = $stmt->fetchAll();
                                foreach ($allstags as $stag) {
                                ?>
                                    <option value="<?php echo $stag['level_name']; ?>"> <?php echo $stag['level_name']; ?> </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Company-2" class="block"> رقم البطاقة </label>
                            <input required id="Company-2" name="card_number" type="number" class="form-control required">
                        </div>
                        <div class="form-group">
                            <label for="Company-2" class="block"> الرصيد </label>
                            <input required id="Company-2" name="balance" type="number" class="form-control required">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_cat" class="btn btn-primary waves-effect waves-light "> حفظ </button>
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal"> رجوع </button>
                    </div>
                </form>
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