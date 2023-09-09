<?php
ob_start();
session_start();
include "init.php";
?>
<div class="home_page">
    <div class="container">
        <div class="data">
            <div class="row">
                <div class="col-lg-6">
                    <div class="info">
                        <img src="images/bank.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info">
                    <img src="images/action.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include $tem . "footer.php";
ob_end_flush();

?>