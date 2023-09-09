<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> كشف حساب </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> كشف حساب </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<?php
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $stmt = $connect->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute(array($student_id));
    $student_data = $stmt->fetch();
    $name = $student_data['name'];
    /// get the balance report 
    $stmt = $connect->prepare("SELECT * FROM student_accounts WHERE student_id = ?");
    $stmt->execute(array($student_id));
    $allrecord = $stmt->fetchAll();
}

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
                                        <th> اسم الطالب </th>
                                        <th> القيمة </th>
                                        <th> التاريخ </th>
                                        <th> السبب </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($allrecord as $record) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo $name ?> </td>
                                            <td> <?php echo $record['price']; ?> </td>
                                            <td> <?php echo $record['date']; ?> </td>
                                            <td> <?php echo $record['reason']; ?> </td>
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