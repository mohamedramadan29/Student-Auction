<?php
ob_start();
session_start();
include "init.php";
?>
<div class="wait_page">
    <div class="container">
        <div class="data">
            <img src="images/programme.png" alt="">
            <p> لا يوجد مزاد في الوقت الحالي </p>
            <p> انتظرنا قريبا </p>
        </div>
    </div>
</div>
<?php
include $tem . "footer.php";
ob_end_flush();

?>