<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم المرحلة ';
    }
 
    $stmt = $connect->prepare("SELECT * FROM eduction_level WHERE level_name = ?");
    $stmt->execute(array($slug));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم المرحلة موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO eduction_level (level_name)
        VALUES (:zname)");
        $stmt->execute(array( 
            "zname" => $name
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=eduction_level&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=eduction_level&page=report');
        exit();
    }
}
