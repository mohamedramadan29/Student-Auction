<?php
ob_start();
$pagetitle = 'Home';
session_start();
include 'init.php';

if (isset($_SESSION['admin_username'])) {
    include 'include/navbar.php';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php
    $page = '';
    if (isset($_GET['page']) && isset($_GET['dir'])) {
        $page = $_GET['page'];
        $dir = $_GET['dir'];
    } else {
        $page = 'manage';
    }
    // start Website Routes 
    // STRAT DASHBAORD
    if ($dir == 'dashboard' && $page == 'dashboard') {
        include 'dashboard.php';
    } elseif ($dir == 'dashboard' && $page == 'emp_dashboard') {
        include 'emp_dashboard.php';
    }
    // END DASHBAORD
    // START Students 
    if ($dir == 'students' && $page == 'add') {
        include "students/add.php";
    } elseif ($dir == 'students' && $page == 'edit') {
        include "students/edit.php";
    } elseif ($dir == 'students' && $page == 'delete') {
        include 'students/delete.php';
    } elseif ($dir == 'students' && $page == 'report') {
        include "students/report.php";
    }
    // START Products
    if ($dir == 'products' && $page == 'add') {
        include "products/add.php";
    } elseif ($dir == 'products' && $page == 'edit') {
        include "products/edit.php";
    } elseif ($dir == 'products' && $page == 'delete') {
        include 'products/delete.php';
    } elseif ($dir == 'products' && $page == 'report') {
        include "products/report.php";
    }
    // START auction_page صفحة المزاد 
    if ($dir == 'auction_page' && $page == 'add') {
        include "auction_page/add.php";
    } elseif ($dir == 'auction_page' && $page == 'edit') {
        include "auction_page/edit.php";
    } elseif ($dir == 'auction_page' && $page == 'delete') {
        include 'auction_page/delete.php';
    } elseif ($dir == 'auction_page' && $page == 'report') {
        include "auction_page/report.php";
    }
    ?>

</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>



<?php
include $tem . "footer.php";
?>