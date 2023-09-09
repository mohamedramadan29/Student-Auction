<!-- Header -->
<header class="header-v2">
    <!-- Header desktop -->
    <div class="container-menu-desktop trans-03">
        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop p-l-45">
                <!-- Logo desktop -->
                <a href="index" class="logo">
                    <img width="120px !important" src="images/bank.png" alt="IMG-LOGO">

                </a>
                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li <?php if (basename($_SERVER['PHP_SELF']) === 'index.php') echo 'class="active-menu"'; ?>>
                            <a href="index">الرئيسية</a>
                        </li>
                        <li <?php if (basename($_SERVER['PHP_SELF']) === 'balance.php') echo 'class="active-menu"'; ?>>
                            <a href="balance">بنك ثري</a>
                        </li>
                        <li <?php if (basename($_SERVER['PHP_SELF']) === 'products.php') echo 'class="active-menu"'; ?>>
                            <a href="products">مزاد ثري</a>
                        </li>
                        <li <?php if (basename($_SERVER['PHP_SELF']) === 'auction_page.php') echo 'class="active-menu"'; ?>>
                            <a href="auction_page">برنامج ثري</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <img width="180px" src="images/bank.png" alt="IMG-LOGO">
        </div>
        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">
            <li <?php if (basename($_SERVER['PHP_SELF']) === 'index.php') echo 'class="active-menu"'; ?>>
                <a href="index">الرئيسية</a>
            </li>
            <li <?php if (basename($_SERVER['PHP_SELF']) === 'balance.php') echo 'class="active-menu"'; ?>>
                <a href="balance">بنك ثري</a>
            </li>
            <li <?php if (basename($_SERVER['PHP_SELF']) === 'products.php') echo 'class="active-menu"'; ?>>
                <a href="products">مزاد ثري</a>
            </li>
            <li <?php if (basename($_SERVER['PHP_SELF']) === 'auction_page.php') echo 'class="active-menu"'; ?>>
                <a href="auction_page">برنامج ثري</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>