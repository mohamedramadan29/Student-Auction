<?php
if (isset($_POST['edit_cat'])) {
    $stage_id = $_POST['stage_id'];
    $name = $_POST['name'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم المرحلة ';
    }

    $stmt = $connect->prepare("SELECT * FROM eduction_level WHERE level_name = ?");
    $stmt->execute(array($name));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم المرحلة  موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE eduction_level SET level_name=? WHERE id = ? ");
        $stmt->execute(array($name, $stage_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=eduction_level&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=eduction_level&page=report');
        exit();
    }
}
