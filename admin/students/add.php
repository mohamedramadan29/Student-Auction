<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $stage = $_POST['stage'];
    $card_number  = $_POST['card_number'];
    $balance = $_POST['balance'];
    $formerror = [];
    if (empty($name) || empty($stage) || empty($card_number) || empty($balance)) {
        $formerror[] = '  من فضلك ادخل المعلومات كاملة  ';
    }
    $stmt = $connect->prepare("SELECT * FROM students WHERE card_number = ?");
    $stmt->execute(array($card_number));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' رقم الكارت موجود من قبل من فضلك ادخل رقم جديد  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO students (name, stage,card_number,balance)
        VALUES (:zname,:zstage,:zcard_number,:zbalance)");
        $stmt->execute(array(
            "zname" => $name,
            "zstage" => $stage,
            "zcard_number" => $card_number,
            "zbalance" => $balance,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=students&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=students&page=report');
        exit();
    }
}
