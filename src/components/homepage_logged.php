<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."error/error_handler.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    require_once(VarUtils::getDocumentRoot()."database/database.php");
    require_once(VarUtils::getDocumentRoot()."database/product.php");
    ErrorHandler::init();
	Session::startSession();
?>
<main>
    <section class="welcome column flex-center">
        <div class="container column flex-center">
            <h1 class="welcome__name text-large">Welcome Back</h1>
            <a href="/Totalitarian/src/shop/shop.php" class="welcome__btn btn text-medium">Visit The Shop</a>
            <a href="#orders" class="welcome__btn btn text-medium">Recent Orders</a>
        </div>
    </section>

    <hr class="divider">

    <section class="orders column flex-center" id="orders">
        <div class="container column flex-center">
            <?php
            $db = new Database();
            $db->connect();
            $query = $db->prepare("SELECT * FROM orders WHERE buyer = ?");
            $db->bindParam($query, 's', Session::getSessionVar("email"));
            $db->execute($query);
            $orders = $db->getResult($query);
            $query->close();

            if($orders->num_rows < 0){
                $db->close();
                ErrorHandler::displayError("Internal Server Error", 500);
            }
            if($orders->num_rows == 0){
                $db->close();
                echo '<article class="orders__empty">
                        <img src="/Totalitarian/src/assets/logo_icon_white.svg" alt="Totalitarian Logo" class="orders__empty__img">
                        <h2 class="orders__empty__msg text-medium">Seems like you haven\'t ordered anything...  THAT\'S BAD</h2>
                    </article>';
            } else{
                $getOrderProducts = $db->prepare("SELECT * FROM OrderProducts WHERE order_id = ?");
                $getProduct = $db->prepare("SELECT * FROM products WHERE id = ?");

                while($order = $orders->fetch_assoc()){
                    $orderId = $order["id"];
                    $orderedOn = $order["ordered_on"];
                    $estimatedShipping = $order["estimated_shipping"];
                    $db->bindParam($getOrderProducts, 'i', $orderId);
                    $db->execute($getOrderProducts);
                    $orderProducts = $db->getResult($getOrderProducts);
                    if($orderProducts->num_rows <= 0){
                        $getOrderProducts->close();
                        $getProduct->close();
                        $db->close();
                        ErrorHandler::displayError("Internal Server Error", 500);
                    }
                    echo '<article class="orders__order">
                            <h2 class="orders__order__id text-medium">Order #'.$orderId.'</h2>
                            <p class="orders__order__dateorder text-small">Ordered On: '.date("Y-m-d",$orderedOn).'</p>
                            <p class="orders__order__dateshipping text-small">Estimated Shipping: '.date("Y-m-d",$estimatedShipping).'</p>';

                    while($orderProduct = $orderProducts->fetch_assoc()){
                        $productId = $orderProduct["product"];
                        $productQuantity = $orderProduct["ordered_quantity"];
                        $db->bindParam($getProduct, 'i', $productId);
                        $db->execute($getProduct);
                        $result = $db->getResult($getProduct);

                        if($result->num_rows != 1){
                            $getOrderProducts->close();
                            $getProduct->close();
                            $db->close();
                            ErrorHandler::displayError("Internal Server Error", 500);
                        }
                        $row = $result->fetch_assoc();
                        $product = Product::withRow($row);
                        echo '<article class="orders__order__product">
                                <img src="'.$product->getImage().'" alt="'.$product->getImageAlt().'" class="orders__order__product__img">
                                <h3 class="orders__order__product__name text-small">'.$product->getName().'</h3>
                                <p class="orders__order__product__quantity text-small">&#10005; '.$productQuantity.'</p>
                            </article>';
                    }

                    echo '</article>';
                }
                $getOrderProducts->close();
                $getProduct->close();
                $db->close();
            }
            ?>
        </div>
    </section>

    <a href="#" class="top-btn btn" aria-label="go back to top" role="button"><i class="fa-solid fa-arrow-up"></i></a>
</main>