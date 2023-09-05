<?php
include '../connect.php';

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Fetch the new balances for all students from the database
    $stmt = $connect->prepare("SELECT id, balance FROM students");
    $stmt->execute();

    $newBalances = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $newBalances[$row['id']] = $row['balance'];
    }

    echo json_encode($newBalances);
}
