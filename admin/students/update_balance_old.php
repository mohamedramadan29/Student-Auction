<?php
include '../connect.php';
if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    $balance_change = floatval($_POST['balance_change']);
    // get the student balance 
    $stmt = $connect->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute(array($student_id));
    $student_data = $stmt->fetch();
    $old_balance = floatval($student_data['balance']);
    $new_balance = number_format($old_balance + $balance_change, 2); // Format to 2 decimal places
    $stmt = $connect->prepare("UPDATE students SET balance = ? WHERE id = ?");
    $stmt->execute(array($new_balance, $student_id));
}
