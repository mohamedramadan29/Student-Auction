<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/bank.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.rtl.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="themes/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@500&display=swap" rel="stylesheet">
    <!-- ============================================================================================== -->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="themes/css/util.css">
    <link rel="stylesheet" type="text/css" href="themes/css/main.css">
    <!--===============================================================================================-->
</head>
<?php
ob_start();
session_start();
$nonavbar = "";
include "init.php";
?>

<body class="animsition bank_body">

    <div class="balance_account">
        <div class="container">
            <div class="data">
                <a href="index" class="return_home btn"> الرئيسية <i class="fa fa-home"></i> </a>
                <img src="images/bank.png" alt="">
                <h2> كشف حساب </h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box">
                        <label for=""> ادخل رقم الحساب الخاص بك </label>
                        <input required type="text" class="form-control" name="account_number" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php if (isset($_REQUEST['account_number'])) echo $_REQUEST['account_number']; ?>">
                    </div>
                    <div class="box">
                        <button id="show_balance" name="show_balance" type="submit" class="btn btn-primary"> كشف الحساب <i class="fa fa-eye"></i> </button>
                    </div>
                </form>
                <?php
                if (isset($_POST['show_balance'])) {
                    $account_number = filter_var($_POST['account_number'], FILTER_SANITIZE_NUMBER_INT);
                    $fromerror = [];
                    if (empty($account_number)) {
                        $fromerror[] = 'من فضلك ادخل رقم الحساب';
                    }
                    if (empty($fromerror)) {
                        $stmt = $connect->prepare("SELECT * FROM students WHERE card_number = ?");
                        $stmt->execute(array($account_number));
                        $acount_data = $stmt->fetch();
                        $count = $stmt->rowCount();
                        if ($count > 0) {
                ?>
                            <br>
                            <table class="table table-bordered table-hover table-primary">
                                <thead>
                                    <tr>
                                        <th> الاسم </th>
                                        <th> رقم الحساب </th>
                                        <th> الرصيد الكلي </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> <?php echo $acount_data['name'] ?> </td>
                                        <td> <?php echo $acount_data['card_number'] ?> </td>
                                        <td> <?php echo $acount_data['balance'] ?> ريال </td>
                                    </tr>
                                </tbody>
                            </table>
                            <h4 style="margin-bottom: 11px;color: #343333;font-size: 20px;"> كشف حساب الطالب </h4>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr style="background-color: #F5B62E;">
                                        <th> الرصيد </th>
                                        <th> التاريخ </th>
                                        <th> السبب </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM student_accounts WHERE student_id = ?");
                                    $stmt->execute(array($acount_data['id']));
                                    $allrecords = $stmt->fetchAll();
                                    foreach ($allrecords as $record) {
                                    ?>
                                        <tr>
                                            <td> <?php echo $record['price'] ?> </td>
                                            <td> <?php echo $record['date'] ?> </td>
                                            <td> <?php echo $record['reason'] ?> </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php
                            // insert into event show_balance
                            $stmt = $connect->prepare("INSERT INTO event_show_balance (event)
                        VALUES (:zevent)
                        ");
                            $stmt->execute(array(
                                "zevent" => "معرفة الرصيد",
                            ));
                        } else {
                        ?>
                            <p class="alert alert-danger error_message"> لا يوجد حساب بهذا الرقم </p>
                <?php
                        }
                    }
                }

                ?>
            </div>
        </div>
    </div>

    <?php
    include $tem . "footer.php";
    ob_end_flush();

    ?>