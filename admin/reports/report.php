<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> تقرير شامل </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> تقرير شامل </li>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> عدد المنتجات </th>
                                        <th> عدد المنتجات المباعه </th>
                                        <th> عدد المنتجات المتبقي </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM products");
                                    $stmt->execute();
                                    $allproducts = count($stmt->fetchAll());
                                    ?>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM products WHERE status = 0 ");
                                    $stmt->execute();
                                    $allproductnossale = count($stmt->fetchAll());
                                    $sale = $allproducts - $allproductnossale;
                                    ?>
                                    <tr>
                                        <td> <?php echo $allproducts; ?> </td>
                                        <td> <?php echo $sale; ?> </td>
                                        <td> <?php echo $allproductnossale; ?> </td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> منتجات تمت المزايدة </th>
                                        <th> السعر قبل المزاد </th>
                                        <th> سعر البيع </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM auction_page WHERE student_win !='' ");
                                    $stmt->execute();
                                    $allactions = $stmt->fetchAll();
                                    $price_start = 0;
                                    $last_price = 0;
                                    foreach ($allactions as $action) {
                                        $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                        $stmt->execute(array($action['product_id']));
                                        $product = $stmt->fetch();
                                    ?>
                                        <tr>
                                            <td> <?php echo $product['name'];  ?> </td>
                                            <td> <?php echo $product['price_start_from']; ?> </td>
                                            <td> <?php echo $action['last_price']; ?> </td>
                                        </tr>
                                    <?php
                                        $price_start = $price_start + $product['price_start_from'];
                                        $last_price = $last_price + $action['last_price'];
                                    }
                                    ?>
                                <tfoot>
                                    <tr style="background-color: #3498db; color:#fff">
                                        <td> المجموع قبل البيع </td>
                                        <th colspan="2"> <?php echo $price_start; ?> </th>
                                    </tr>
                                    <tr style="background-color: #3498db; color:#fff">
                                        <td> المجموع بعد البيع </td>
                                        <th colspan="2"> <?php echo $last_price; ?> </th>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> اسم المرحلة </th>
                                        <th> عدد الطلاب </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM eduction_level ORDER BY id DESC");
                                    $stmt->execute();
                                    $allcat = $stmt->fetchAll();
                                    $i = 0;
                                    $all_student = 0;
                                    foreach ($allcat as $cat) {
                                    ?>
                                        <tr>
                                            <td> <?php echo $cat['level_name']; ?> </td>
                                            <td>
                                                <?php
                                                $stmt = $connect->prepare("SELECT * FROM students WHERE stage = ?");
                                                $stmt->execute(array($cat['level_name']));
                                                $student_num = count($stmt->fetchAll());
                                                echo $student_num; ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $all_student = $all_student + $student_num;
                                    }
                                    ?>
                                <tfoot>
                                    <tr style="background-color: #3498db; color:#fff">
                                        <td> مجموع عدد الطلاب </td>
                                        <th> <?php echo $all_student; ?> </th>
                                    </tr>
                                    <tr style="background-color: #3498db; color:#fff">
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM students");
                                        $stmt->execute();
                                        $allstudents = $stmt->fetchAll();
                                        $allbalance = 0;
                                        foreach ($allstudents as $student) {
                                            $allbalance = $allbalance + $student['balance'];
                                        }
                                        ?>
                                        <td> مجموع ارصدة الطلاب </td>
                                        <th colspan="2"> <?php echo $allbalance; ?> </th>
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