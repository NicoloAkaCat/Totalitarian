<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    require_once(VarUtils::getDocumentRoot()."database/database.php");
    require_once(VarUtils::getDocumentRoot()."database/product.php");
    
    ErrorHandler::init();
	Session::startSession();
	if(!VarUtils::checkIsSetInArray($_SESSION, "UID")){
        if(VarUtils::checkIsSetInArray($_COOKIE, "UID"))
            Session::loginWithCookie($_COOKIE["UID"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Totalitarian/src/styles/style.css">
    <link rel="stylesheet" href="/Totalitarian/src/styles/shop.css">
    <link rel="icon" href="/Totalitarian/src/assets/logo_icon_white.svg" type="image/x-icon">
    <title>Shop</title>
    <script src="https://kit.fontawesome.com/9d36b0df12.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include(VarUtils::getDocumentRoot()."components/header.php");
    ?>
    <main>
        <div class="container">
            <h1 class="page-title text-large">SHOP</h1>
            <section class="search">
                <form action="#" method="get" class="search__form row flex-center">
                    <label for="search">search box</label>
                    <input type="text" id="search" name="search" class="search__form__input text-small" placeholder="Search">
                    <button type="submit" class="search__form__btn text-small">search button<i class="fa-solid fa-search"></i></button>
                </form>
            </section>

            <section class="products column">
                <?php
                $db = new Database();
                $db->connect();
                if(VarUtils::checkIsSetInArray($_GET, "search") && !VarUtils::checkIsEmptyInArray($_GET, "search")){
                    $search = $_GET["search"];
                    $query = $db->prepare("SELECT * FROM products WHERE name LIKE ?");
                    $db->bindParam($query, 's', "%".$search."%");
                }
                else
                    $query = $db->prepare("SELECT * FROM products");
                $db->execute($query);
                $result = $db->getResult($query);
                $query->close();
                $db->close();

                while($product = Product::withRow($result->fetch_assoc())){
                    echo '<article class="products__item column flex-center">
                            <img class="products__item__img" src="'.$product->getImage().'" alt="'.$product->getImageAlt().'">
                            <h2 class="products__item__name text-medium">'.$product->getName().'</h2>
                            <span class="products__item__price text-medium">'.$product->getPrice().' $</span>
                            <a href="/Totalitarian/src/shop/view_product.php?id='.$product->getId().'" class="products__item__btn btn text-small">View product</a>
                        </article>';
                }
                ?>
            </section>
        </div>
    </main>
    <script src="/Totalitarian/src/scripts/main.js"></script>
</body>
</html>