<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> منتجات الطالب </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> منتجات الطالب </li>
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
$student_id = $_GET['student_id'];

?>

<!-- DOM/Jquery table start -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
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
                                        <th> السعر النهائي </th>
                                        <th> تاريخ المزاد  </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // get the win products 
                                    $stmt = $connect->prepare("SELECT * FROM auction_page WHERE student_win = ?");
                                    $stmt->execute(array($student_id));
                                    $allwins = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allwins as $win) {
                                        $i++;
                                        $product_id = $win['product_id'];
                                        $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                        $stmt->execute(array($product_id));
                                        $product = $stmt->fetch();
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo $product['name']; ?> </td>
                                            <td> <?php echo $product['price_start_from']; ?> </td>
                                            <td> <?php echo $product['step_price']; ?> </td>
                                            <td> <img width="80px" src="products/images/<?php echo $product['image']; ?>" alt=""> </td>
                                            <td> <?php echo $win['last_price']; ?> </td>
                                            <td> <?php echo $win['date']; ?> </td>
                                        </tr>
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