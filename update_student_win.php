<?php
include "admin/connect.php";
// get the last product to make auction
$stmt = $connect->prepare("SELECT * FROM auction_page ORDER BY id DESC LIMIT 1");
$stmt->execute();
$action_data = $stmt->fetch();
$last_product = $action_data['product_id'];
$last_price = $action_data['last_price'];
$action_id = $action_data['id'];
?>
<h4 class="price_now"> سعر المزاد الان :: <span> <?php echo $last_price; ?> ريال </span> </h4>
<br>
<?php
//$last_price_after_step = $last_price + $product_step;
$stmt = $connect->prepare("SELECT * FROM action_steps WHERE action_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute(array($action_id));
$last_action_step_data = $stmt->fetch();
$count = $stmt->rowCount();
if ($count > 0) {
    $student_owner = $last_action_step_data['student_id'];
    /////////////  get the studen data  ///////////// 
    $stmt = $connect->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute(array($student_owner));
    $student_data = $stmt->fetch();
    $student_name = $student_data['name'];
?>
    <table class="table table-bordered table-active">
        <tr>
            <th> اسم الفائز حتي الان </th>
            <th> <?php echo $student_name; ?> </th>
            <th> السعر النهائي :: <?php echo $last_price ?> ريال </th>
        </tr>
    </table>
<?php
}


if ($action_data['student_win'] != null) {
    $student_win = $action_data['student_win'];
    $stmt = $connect->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute(array($student_win));
    $student_win_data = $stmt->fetch();
    $name = $student_win_data['name'];
    $stage = $student_win_data['stage'];
?>
    <div class="the_last_student_win">
        <div class="info">
            <h4> الفائز بالمزاد هو :: </h4>
            <h2> <?php echo $name ?> </h2>
            <p> <?php echo $stage; ?> </p>
        </div>
    </div>
<?php
}
?>