<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"> الرئيسية </h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
          <li class="breadcrumb-item active"> فري </li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <!-- ./col -->
      <?php
      $stmt = $connect->prepare("SELECT * FROM students");
      $stmt->execute();
      $allstudents = count($stmt->fetchAll());
      ?>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3> <?php echo $allstudents; ?> </h3>
            <p class="text-bold"> الطلاب </p>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <a href="main.php?dir=students&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <?php
      $stmt = $connect->prepare("SELECT * FROM products");
      $stmt->execute();
      $allproducts = count($stmt->fetchAll());
      ?>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3> <?php echo $allproducts; ?> </h3>
            <p class="text-bold"> المنتجات </p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="main.php?dir=products&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <?php
      $stmt = $connect->prepare("SELECT * FROM eduction_level");
      $stmt->execute();
      $alllevels = count($stmt->fetchAll());
      ?>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3> <?php echo $alllevels; ?> </h3>
            <p class="text-bold"> المراحل الدراسية </p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="main.php?dir=eduction_level&page=report" class="small-box-footer"> التقاصيل <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>
</div>