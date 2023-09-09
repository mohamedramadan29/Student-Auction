<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> عمليات البيع </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> عمليات البيع </li>
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
$product_id = $_GET['product_id'];
$stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute(array($product_id));
$product_data = $stmt->fetch();
$product_name = $product_data['name'];
$product_price = $product_data['price_start_from'];
$product_step_price = $product_data['step_price'];
$product_image  = $product_data['image'];
// get the num product sales 
$stmt = $connect->prepare("SELECT * FROM auction_page WHERE product_id = ? AND student_win !=''");
$stmt->execute(array($product_id));
$allwins  = $stmt->fetchAll();
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
                                        <th> سعر المنتج </th>
                                        <th> سعر المزايدة </th>
                                        <th> السعر النهائي للمزاد </th>
                                        <th> الفائز </th>
                                        <th> صورة المنتج </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_price = 0;
                                    $total_last_price = 0;
                                    $i = 0;
                                    foreach ($allwins as $win) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo $product_name; ?> </td>
                                            <td> <?php echo $product_price;
                                                    $total_price = $total_price + $product_price;
                                                    ?> </td>
                                            <td> <?php echo $product_step_price; ?> </td>
                                            <td> <?php echo $win['last_price'];
                                                    $total_last_price = $total_last_price + $win['last_price'];
                                                    ?> </td>
                                            <td> <?php
                                                    $stmt = $connect->prepare("SELECT * FROM students WHERE id =?");
                                                    $stmt->execute(array($win['student_win']));
                                                    $student_data = $stmt->fetch();
                                                    echo $student_data['name']; ?>
                                                <br>
                                            </td>
                                            <td> <img width="80px" src="products/images/<?php echo $product_image; ?>" alt=""> </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"> مجموع اسعار المنتج </td>
                                        <th> <?php echo $total_price; ?> </th>
                                        <td> السعر الكلي بعد المزاد </td>
                                        <th> <?php echo $total_last_price; ?> </th>
                                        <td> الربح </td>
                                        <th> <?php echo $total_last_price - $total_price; ?> </th>
                                    </tr>
                                </tfoot>
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