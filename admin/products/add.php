<?php
if (isset($_POST['add_cat'])) {
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
    if (empty($formerror)) {
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
        } else {
            $formerror[] = ' من فضلك ادخل صورة  المنتج   ';
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
        } else {
            $formerror[] = ' من فضلك ادخل صورة  المنتج   ';
        }
    }
    $stmt = $connect->prepare("SELECT * FROM products WHERE name = ?");
    $stmt->execute(array($name));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' المنتج موجود من قبل من فضلك ادخل منتج جديد  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO products (name,image,image_phone ,price_start_from,step_price,order_number,show_status)
        VALUES (:zname,:zimage,:zimage_phone,:zstart_from,:zstep_price,:zorder_number,:zshow_status)");
        $stmt->execute(array(
            "zname" => $name,
            "zimage" => $main_image_uploaded,
            "zimage_phone" => $main_image_uploaded_phone,
            "zstart_from" => $price_start_from,
            "zstep_price" => $step_price,
            "zorder_number" => $order_number,
            "zshow_status" => $show_status,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=products&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=products&page=report');
        exit();
    }
}
