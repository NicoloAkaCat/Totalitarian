<?
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
            <div class="menu column flex-center" aria-label="menu button"><div class="menu__hamburger"></div></div>
        </div>
        

        <nav class="nav">
            <ul class="nav__list">
                <li class="nav__item">
                    <a href="/Totalitarian/src/pages/shop.php" class="nav__link text-small"><i class="fa-solid fa-cart-shopping"></i>Shop</a>
                </li>
                <?php
                if(VarUtils::checkIsSetInArray($_SESSION, "UID"))
                    echo '<li class="nav__item">
                            <a href="/Totalitarian/src/auth/logout.php" class="nav__link text-small"><i class="fa-solid fa-right-to-bracket"></i>Logout</a>
                        </li>';
                else
                    echo '<li class="nav__item">
                            <a href="/Totalitarian/src/auth/login.php" class="nav__link text-small"><i class="fa-solid fa-right-to-bracket"></i>Login</a>
                        </li>
                        <li class="nav__item">
                            <a href="/Totalitarian/src/auth/register.php" class="nav__link text-small"><i class="fa-solid fa-address-card"></i>Sign-In</a>
                        </li>';
                ?>
            </ul>
        </nav>
    </div>
</header>