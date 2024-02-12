<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    
    Session::startSession();
?>
<header>
    <div class="container">
        <div class="logo row">
            <a href="/Totalitarian/src/index.php" class="logo__img">
                <img src="/Totalitarian/src/assets/logo_icon_white.svg" alt="Totalitarian logo">
            </a>
            <a href="/Totalitarian/src/index.php" class="logo__title text-medium">Totalitarian</a>
            <div class="menu-hamburger"><button aria-label="menu"></button></div>
        </div>
        

        <nav class="nav">
            <ul class="nav__list">
                <li aria-hidden="true" class="nav__list__item">
                    <button class="nav__list__item__link text-small dux">DVX</button>
                </li>
                <li class="nav__list__item">
                    <a href="/Totalitarian/src/shop/shop.php" class="nav__list__item__link text-small"><i class="fa-solid fa-bag-shopping"></i><span>Shop</span></a>
                </li>
                <li class="nav__list__item">
                    <a href="/Totalitarian/src/shop/cart.php" class="nav__list__item__link text-small"><i class="fa-solid fa-cart-shopping"></i><span>Cart</span></a>
                </li>
                <?php
                if(VarUtils::checkIsSetInArray($_SESSION, "UID"))
                    echo '<li class="nav__list__item">
                            <a href="/Totalitarian/src/profile/show_profile.php" class="nav__list__item__link text-small"><i class="fa-solid fa-user"></i><span>Profile</span></a>
                        </li>
                        <li class="nav__list__item">
                            <a href="/Totalitarian/src/auth/logout.php" class="nav__list__item__link text-small"><i class="fa-solid fa-right-to-bracket"></i><span>Logout</span></a>
                        </li>';
                else
                    echo '<li class="nav__list__item">
                            <a href="/Totalitarian/src/auth/login.php" class="nav__list__item__link text-small"><i class="fa-solid fa-right-to-bracket"></i><span>Login</span></a>
                        </li>
                        <li class="nav__list__item">
                            <a href="/Totalitarian/src/auth/register.php" class="nav__list__item__link text-small"><i class="fa-solid fa-address-card"></i><span>Sign-In</span></a>
                        </li>';
                ?>
            </ul>
        </nav>
    </div>
</header>