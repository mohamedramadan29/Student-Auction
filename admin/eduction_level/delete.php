<?php
if (isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];
    $stmt = $connect->prepare('SELECT * FROM eduction_level WHERE id= ?');
    $stmt->execute([$cat_id]);
    $cat_data = $stmt->fetch();
    $cat_image = $cat_data['image'];
    if (!empty($cat_image)) {
        $cat_image = "category_images/" . $cat_image;
        unlink($cat_image);
    }
    $stmt = $connect->prepare('DELETE FROM eduction_level WHERE id=?');
    $stmt->execute([$cat_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location: main?dir=eduction_level&page=report');
        exit(); // Terminate the script after redirecting
    }
}
