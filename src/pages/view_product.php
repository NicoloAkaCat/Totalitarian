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
            Session::checkRememberCookie($_COOKIE["UID"]);
    }

    if(!VarUtils::checkIsSetInArray($_GET, "id") || VarUtils::checkIsEmptyInArray($_GET, "id"))
        ErrorHandler::displayError("Server Error", 500);

    $db = new Database();
    $db->connect();
    $query = $db->prepare("SELECT * FROM products WHERE id = ?");
    $db->bindParam($query, 'i', $_GET["id"]);
    $db->execute($query);
    $result = $db->getResult($query);
    $query->close();

    if($result->num_rows != 1){
        $db->close();
        ErrorHandler::displayError("Server Error", 500);
    }
    $product = Product::withRow($result->fetch_assoc());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Totalitarian/src/styles/style.css">
    <link rel="stylesheet" href="/Totalitarian/src/styles/product.css">
    <link rel="icon" href="/Totalitarian/src/assets/logo_icon_white.svg" type="image/x-icon">
    <title><?php echo $product->getName();?></title>
    <script src="https://kit.fontawesome.com/9d36b0df12.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include(VarUtils::getDocumentRoot()."components/header.php");
    ?>
    <main>
        <div class="container column flex-center">
            <div class="product column flex-center">
                <img src="<?php echo $product->getImage();?>" alt="<?php echo $product->getImageAlt();?>" class="product__image">
                <div class="product__info">
                    <h1 class="product__info__name text-medium"><?php echo $product->getName();?></h1>
                    <p class="product__info__description text-small"><?php echo $product->getDescription();?></p>
                    <div class="product__info__score text-small">
                        <span>Reviews:</span>
                        <?php 
                        for($i = 0; $i < $product->getScore(); $i++)
                            echo '<span class="star">&#9733;</span>'
                        ?>
                    </div>
                    <div class="product__info__categories row">
                        <?php
                        $query = $db->prepare("SELECT name FROM categories WHERE product = ?");
                        $db->bindParam($query, 'i', $product->getId());
                        $db->execute($query);
                        $result = $db->getResult($query);
                        $query->close();
                        $db->close();
                        while($row = $result->fetch_assoc()){
                            echo '<span class="product__info__categories__category text-small">'.$row["name"].'</span>';
                        }
                        ?>
                    </div>
                    <p class="product__info__stock text-small">In Stock: <?php echo $product->getQuantity();?></p>
                    <div class="product__info__buy">
                        <div class="product__info__buy__price text-medium"><?php echo $product->getPrice();?> $</div>
                        <a href="#" class="product__info__buy__btn btn text-medium">Add to Cart</a>
                    </div>
                </div>
            </div>

            <a href="/Totalitarian/src/pages/shop.php" class="back-button btn"><span>&#x25c0;</span>Back to Shop</a>
        </div>
    <script src="/Totalitarian/src/scripts/main.js"></script>
</body>
</html>