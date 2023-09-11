<?php
if (isset($_POST['edit_cat'])) {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $stage = $_POST['stage'];
    $card_number  = $_POST['card_number'];
    $balance = $_POST['balance'];
    $status = $_POST['status'];
    $formerror = [];
    if (empty($name) || empty($stage) || empty($card_number)) {
        $formerror[] = '  من فضلك ادخل المعلومات كاملة  ';
    } 
 
    $stmt = $connect->prepare("SELECT * FROM students WHERE card_number = ? AND id != ?");
    $stmt->execute(array($card_number,$student_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' رقم الكارت موجود من قبل من فضلك ادخل رقم جديد  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE students SET  name=?,stage=?,card_number=?,balance=?,status=? WHERE id = ? ");
        $stmt->execute(array($name, $stage,$card_number,$balance,$status,$student_id));
        
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=students&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=students&page=report');
        exit();
    }
}
