<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> المنتجات </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> المنتجات </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> أضافة منتج جديد <i class="fa fa-plus"></i> </button>
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
                                        <th> اسم المنتج </th>
                                        <th> يبدا من </th>
                                        <th> رقم المزايدة </th>
                                        <th> صورة المنتج </th>
                                        <th> صورة الموبايل </th>
                                        <th> مزايدة </th>
                                        <th> عمليات البيع </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM products ORDER BY id DESC");
                                    $stmt->execute();
                                    $allproducts = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allproducts as $product) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo $product['name']; ?> </td>
                                            <td> <?php echo $product['price_start_from']; ?> </td>
                                            <td> <?php echo $product['step_price']; ?> </td>
                                            <td> <img width="80px" src="products/images/<?php echo $product['image']; ?>" alt=""> </td>
                                            <td> <img width="80px" src="products/phone_images/<?php echo $product['image_phone']; ?>" alt=""> </td>
                                            <td>
                                                <?php
                                                if ($product['status'] == 0) {
                                                ?>
                                                    <form action="main?dir=auction_page&page=report" method="post">
                                                        <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
                                                        <input type="hidden" name="price" value="<?php echo $product['price_start_from'] ?>">
                                                        <button type="submit" class="btn btn-warning btn-sm"> زايد <i class="fa fa-eye"></i> </button>
                                                    </form>
                                                <?php
                                                } else {
                                                ?>
                                                    <span class="badge badge-danger"> تمت المزايدة </span>
                                                <?php
                                                }
                                                ?>

                                            </td>
                                            <td> <a href="main.php?dir=products&page=sales_products&product_id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm"> عمليات البيع </a>
                                                <?php
                                                $stmt = $connect->prepare("SELECT * FROM auction_page WHERE product_id = ? AND student_win !=''");
                                                $stmt->execute(array($product['id']));
                                                $allwins  = count($stmt->fetchAll());
                                                ?>
                                                <br>
                                                <span class="badge badge-danger"> <?php echo $allwins; ?> </span>

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $product['id']; ?>"> <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=products&page=delete&cat_id=<?php echo $product['id']; ?>" class="confirm btn btn-danger btn-sm"> <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $product['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل المنتج </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=products&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="product_id" value="<?php echo $product['id']; ?>">
                                                                <label for="Company-2" class="block">الأسم </label>
                                                                <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo  $product['name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> يبدا من </label>
                                                                <input required id="Company-2" name="price_start_from" type="number" class="form-control required" value="<?php echo  $product['price_start_from'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> سعر المزايدة </label>
                                                                <input required id="Company-2" name="step_price" type="number" class="form-control required" value="<?php echo  $product['step_price'] ?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> تعديل صورة المنتج </label>
                                                                <input id="Company-2" name="main_image" type="file" class="form-control required" accept="image/*">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> تعديل صورة الموبايل </label>
                                                                <input id="Company-2" name="main_image_phone" type="file" class="form-control required" accept="image/*">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> تريب المنتج </label>
                                                                <input required id="Company-2" name="order_number" type="number" class="form-control required" value="<?php echo  $product['order_number'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> حالة المنتج </label>
                                                                <select name="show_status" id="" class="form-control select2">
                                                                    <option value=""> -- اختر الحالة -- </option>
                                                                    <option <?php if ($product['show_status'] == 1) echo "selected"; ?> value="1"> مفعل </option>
                                                                    <option <?php if ($product['show_status'] == 0) echo "selected"; ?> value="0"> غير مفعل </option>
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
                                <h4 class="modal-title">أضافة منتج جديد </h4>
                            </div>
                            <form action="main.php?dir=products&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> اسم المنتج </label>
                                        <input required id="Company-2" name="name" type="text" class="form-control required" value="<?php if (isset($_REQUEST['name'])) echo $_REQUEST['name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> يبدا من </label>
                                        <input required id="Company-2" name="price_start_from" type="number" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> سعر المزايدة </label>
                                        <input required id="Company-2" name="step_price" type="number" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> صورة المنتج </label>
                                        <input required id="Company-2" name="main_image" type="file" class="form-control required" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> صورة الموبايل </label>
                                        <input required id="Company-2" name="main_image_phone" type="file" class="form-control required" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> تريب المنتج </label>
                                        <input required id="Company-2" name="order_number" type="number" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> حالة المنتج </label>
                                        <select name="show_status" id="" class="form-control select2">
                                            <option value=""> -- اختر الحالة -- </option>
                                            <option value="1"> مفعل </option>
                                            <option value="0"> غير مفعل </option>
                                        </select>
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