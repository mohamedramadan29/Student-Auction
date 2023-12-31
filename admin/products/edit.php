<?php
if (isset($_POST['edit_cat'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price_start_from = $_POST['price_start_from'];
    $step_price  = $_POST['step_price'];
    $order_number = $_POST['order_number'];
    $show_status = $_POST['show_status'];
    $formerror = [];
    if (empty($name) || empty($price_start_from) || empty($step_price)) {
        $formerror[] = '  من فضلك ادخل المعلومات كاملة  ';
    }
    // main image
    if (!empty($_FILES['main_image']['name'])) {
        $main_image_name = $_FILES['main_image']['name'];
        $main_image_name = str_replace(' ', '-', $main_image_name);
        $main_image_temp = $_FILES['main_image']['tmp_name'];
        $main_image_type = $_FILES['main_image']['type'];
        $main_image_size = $_FILES['main_image']['size'];
        // حصل على امتداد الصورة من اسم الملف المرفوع
        $image_extension = pathinfo($main_image_name, PATHINFO_EXTENSION);
        $main_image_uploaded = $main_image_name . '.' . $image_extension;
        move_uploaded_file(
            $main_image_temp,
            'products/images/' . $main_image_uploaded
        );
    }
    if (!empty($_FILES['main_image_phone']['name'])) {
        $main_image_name_phone = $_FILES['main_image_phone']['name'];
        $main_image_name_phone = str_replace(' ', '-', $main_image_name_phone);
        $main_image_temp_phone = $_FILES['main_image_phone']['tmp_name'];
        $main_image_type_phone = $_FILES['main_image_phone']['type'];
        $main_image_size_phone = $_FILES['main_image_phone']['size'];
        // حصل على امتداد الصورة من اسم الملف المرفوع
        $image_extension_phone = pathinfo($main_image_name_phone, PATHINFO_EXTENSION);
        $main_image_uploaded_phone = $main_image_name_phone . '.' . $image_extension_phone;
        move_uploaded_file(
            $main_image_temp_phone,
            'products/phone_images/' . $main_image_uploaded_phone
        );
    }
    $stmt = $connect->prepare("SELECT * FROM products WHERE name = ? AND id !=?");
    $stmt->execute(array($name, $product_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' المنتج موجود من قبل من فضلك ادخل منتج جديد  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE products SET name=?,price_start_from=?,step_price=?,order_number=?,show_status=? WHERE id = ? ");
        $stmt->execute(array($name, $price_start_from, $step_price, $order_number, $show_status, $product_id));
        if (!empty($_FILES['main_image']['name'])) {
            $stmt = $connect->prepare("UPDATE products SET  image=?  WHERE id = ? ");
            $stmt->execute(array($main_image_uploaded, $product_id));
        }
        if (!empty($_FILES['main_image_phone']['name'])) {
            $stmt = $connect->prepare("UPDATE products SET  image_phone=?  WHERE id = ? ");
            $stmt->execute(array($main_image_uploaded_phone, $product_id));
        }
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=products&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=students&page=report');
        exit();
    }
}
