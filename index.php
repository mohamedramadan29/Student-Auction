<?php
ob_start();
session_start();
$nonavbar = "";
include "init.php";

?>
<div class="home_page">
    <div class="container">
        <div class="data">
            <div class="row">
                <div class="col-lg-6">
                    <a href="balance">
                        <div class="info">
                            <img src="images/bank.png" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-lg-6">
                    <a href="products">
                        <div class="info">
                            <img src="images/action.png" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-lg-12">
                    <a href="auction_page">
                        <div class="info programme">
                            <img src="images/programme.png" alt="">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include $tem . "footer.php";
ob_end_flush();

?>