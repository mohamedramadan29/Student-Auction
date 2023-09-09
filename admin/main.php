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
    } elseif ($dir == 'students' && $page == 'accounts_report') {
        include "students/accounts_report.php";
    } elseif ($dir == 'students' && $page == 'student_win_products') {
        include "students/student_win_products.php";
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
    } elseif ($dir == 'products' && $page == 'sales_products') {
        include "products/sales_products.php";
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
    // START EDUCTION LEVEL 
    if ($dir == 'eduction_level' && $page == 'add') {
        include "eduction_level/add.php";
    } elseif ($dir == 'eduction_level' && $page == 'edit') {
        include "eduction_level/edit.php";
    } elseif ($dir == 'eduction_level' && $page == 'delete') {
        include 'eduction_level/delete.php';
    } elseif ($dir == 'eduction_level' && $page == 'report') {
        include "eduction_level/report.php";
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