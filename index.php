<?php
ob_start();
session_start();
$page_title = 'الرئيسية';
include "init.php";
?>

<div class="hero">
    <div class="overlay">
        <div class="container">
            <div class="data">
                <h2> <span> شركة </span> </h2>
                <h2 class="animate__animated animate__fadeInDown"> <span>البراق</span> <span> للخدمات المالية </span> </h2>
                <h5 class="element"></h5>
                <p> لا تضيع الوقت واستثمر مع شركة البراق للخدمات الماليه
                    وللاستثمار كن احد زبائننا
                    المميزين <br> وانضم إلى مجموعة متميزة من المتداولين والمستثمرين. </p>
               
                <a href="#compelete_form" class="btn btn-primary animate__animated animate__fadeInUp"> احجز الأن </a>
            </div>
        </div>
    </div>
</div>
<div class="about">
    <div class="container">
        <div class="data">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section2">
                        <h2> عن شركة البراق للخدمات الماليه </h2>
                        <p>
                            تفتخر شركة " البراق " بتوسعة عدد فروعها لتضم أكثر من 10 فروع موزعة في عموم أرجاء العراق، ومدعومة بفريق عمل متكامل يضم أكثر من 100 موظف وموظفة لتلبية احتياجات عملائنا وإجراء ومعالجة معاملاتهم وفق أعلى معايير الكفاءة والسرعة وبأسعار تنافسية مجدية.
                        </p>
                        <p>
                            تنفذ الشركة حالياً أكثر من 1,000 معاملة يومياً، وتأمل في أن تزيد من حصتها السوقية لتنافس كبرى شركات الصرافة في العراق بمستهدف أن يتم تحويل أكثر من 10 مليار دينار عبر شبكتها في عام 2023.</p>
                        <p> سواءً كان الزبون من الأفراد أو من المؤسسات، فإن شركة البراق للصرافة تفتح لهم آفاقاً واسعة من الإمكانيات وتقدم لهم حلولاً مالية تغطي حركة الأموال بكافة خياراتها.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section1">
                        <video id="player" playsinline controls data-poster="uploads/logo.webp">
                            <source src="uploads/video1.mp4" type="video/mp4" />
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="services">
    <div class="container">
        <div class="data">
            <h2 class="header"> تشمل خدماتنا </h2>
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="info">
                        <h3> التحويلات المالية </h3>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="info">
                        <h3> صرف العملات </h3>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="info">
                        <h3> منافذ السحب النقدي </h3>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="info">
                        <h3> الخدمات المساعدة الأخرى </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_REQUEST['send_request'])) {
    $name = sanitizeInput($_POST['name']);
    $price_request = sanitizeInput($_POST['price_request']);
    $city = sanitizeInput($_POST['city']);
    $phone = sanitizeInput($_POST['phone']);
    $request_order = sanitizeInput($_POST['request_order']);
    $formerror = [];
    if (empty($name) || empty($price_request) || empty($city) || empty($phone) || empty($request_order)) {
        $formerror[] = 'من فضلك اكمل جميع البيانات';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO requests (name,price_request,city,phone,request_order)
        VALUES(:zname,:zprice_request,:zcity,:zphone,:zrequest_order)
        ");
        $stmt->execute(array(
            "zname" => $name,
            "zprice_request" => $price_request,
            "zcity" => $city,
            "zphone" => $phone,
            "zrequest_order" => $request_order,
        ));
        if ($stmt) {
?>
            <script src='themes/js/jquery.min.js'></script>
            <script>
                $(document).ready(function() {
                    swal({
                        title: "تم ارسال طلبك بنجاح",
                        icon: "success",
                        buttons: {
                            cancel: "اغلاق ! ",
                            defeat: false,
                        },
                    })
                });
            </script>
        <?php
        }
    } else {
        foreach ($formerror as $error) {
        ?>
            <li class="alert alert-danger"> <?php echo $error; ?> </li>
<?php
        }
    }
}


?>
<div class="request_form" id="compelete_form">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h2> استمارة طلب الحصول علي مبلغ </h2>
                <div class="data">
                    <form action="" method="post">
                        <div class="group_form">
                            <label for="name"> الأسم بالكامل </label>
                            <input required type="text" class="form-control" name="name">
                        </div>
                        <div class="group_form">
                            <label for="name"> المبلغ المطلوب </label>
                            <input required type="number" class="form-control" name="price_request">
                        </div>
                        <div class="group_form">
                            <label for="name"> المحافطة </label>
                            <input required type="text" class="form-control" name="city">
                        </div>
                        <div class="group_form">
                            <label for="name"> رقم الهاتف </label>
                            <input required type="text" class="form-control" name="phone">
                        </div>
                        <div class="group_form">
                            <label for="name"> تاريخ استلام الطلب </label>
                            <input required type="date" class="form-control" name="request_order">
                        </div>
                        <div class="group_form">
                            <button class="btn" type="submit" name="send_request"> ارسال </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="data" style="margin-top: 65px;">
                    <video id="player2" playsinline controls>
                        <source src="uploads/video2.3GP" type="video/mp4" />
                    </video>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>