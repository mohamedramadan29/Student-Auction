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


<!-- DOM/Jquery table start -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> أضافة طالب جديد <i class="fa fa-plus"></i> </button>
                    </div>
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
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> اسم الطالب </th>
                                        <th> المرحلة </th>
                                        <th> رقم الكارت </th>
                                        <th> الرصيد </th>
                                        <th> الحالة </th>
                                        <th> المنتجات </th>
                                        <th> التحكم في الرصيد </th>
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
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $student['name']; ?> </td>
                                            <td> <?php echo  $student['stage']; ?> </td>
                                            <td> <?php echo  $student['card_number']; ?> </td>
                                            <td> <?php echo  $student['balance']; ?> </td>
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
                                            <td> <a href="#" class="btn btn-primary btn-sm"> منتجات الطالب </a> </td>
                                            <td> <input type="number" class="form-control" value="balance_change" placeholder="ادخال رصيد"> </td>

                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $student['id']; ?>"> <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=students&page=delete&cat_id=<?php echo $student['id']; ?>" class="confirm btn btn-danger btn-sm"> <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
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
                                                                <input required id="Company-2" name="stage" type="text" class="form-control required" value="<?php echo  $student['stage'] ?>">
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
                                        <input required id="Company-2" name="stage" type="text" class="form-control required">
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