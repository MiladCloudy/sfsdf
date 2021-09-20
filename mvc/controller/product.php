<?
class ProductController {



  public function search($pageIndex = 1) {
    $sortType = post('sortType');
    $keyword  = post('keyword');
    $viewType = post('viewType');
    $filter   = post('filter');


    // safe filter to prevent SQL Injection
    if($filter == 'wish'){
      $filter = "user_wish.wish_id IS NOT NULL";
    } else {
      $filter = "1=1";
    }


    // safe sortType to prevent SQL Injection
    $sortPhrase = '';
    $sortTypeParts = explode('-', $sortType);

    $sortField = $sortTypeParts[0];
    $sortBy    = $sortTypeParts[1];

    if($sortField == 'price' && $sortBy == 'asc') {
      $sortPhrase = 'ORDER BY pym_product.price ASC';

    } else if($sortField == 'price' && $sortBy == 'desc') {
      $sortPhrase = 'ORDER BY pym_product.price DESC';

    } else if($sortField == 'creationTime' && $sortBy == 'asc') {
      $sortPhrase = 'ORDER BY pym_product.creationTime ASC';

    } else if($sortField == 'creationTime' && $sortBy == 'desc') {
      $sortPhrase = 'ORDER BY pym_product.creationTime DESC';

    } else if($sortField == 'rate' && $sortBy == 'desc') {
      $sortPhrase = 'ORDER BY pym_product.rate DESC';
    }

    // ok, finally execute query
    $itemCount = 10;
    $itemIndex = ($pageIndex-1) * $itemCount;

    $db = Db::getInstance();
    $totalProducts = $db->query("SELECT * FROM pym_product LEFT OUTER JOIN user_wish ON pym_product.product_id=user_wish.resource_id AND user_wish.resourceType=1 AND user_id=:user_id OR user_id IS NULL WHERE $filter AND pym_product.title LIKE :keyword $sortPhrase", array(
      'user_id' => getUserId(),
      'keyword' => "%$keyword%",
    ));

    $products = $db->query("SELECT * FROM pym_product LEFT OUTER JOIN user_wish ON pym_product.product_id=user_wish.resource_id AND user_wish.resourceType=1 AND user_id=:user_id OR user_id IS NULL WHERE $filter AND pym_product.title LIKE :keyword $sortPhrase LIMIT $itemIndex, $itemCount", array(
      'user_id' => getUserId(),
      'keyword' => "%$keyword%",
    ));

    if ($products != null) {
      foreach ($products as &$product) {
        if ($product['hasCover'] != 1) {
          $path = "/image/products/default.png";
          $alt = "";
        } else {
          $path = "/image/products/" . $product['product_id'] . ".png";
          $alt = $db->first("SELECT alt FROM seo_image WHERE url=:url", array(
            'url' => $path,
          ), 'alt');
        }

        $product['image_path'] = $path;
        $product['alt']        = $alt;
      }

      $data['products'] = $products;

    } else { $data['products'] = array('notFound'); }


    $data['pageIndex'] = $pageIndex;
    $data['pageCount'] = floor(count($totalProducts) / $itemCount) + 1;

    // render proper view base on user selected view type
    if ($viewType == 'grid') {
      session_set('viewType', 'grid');
    } else {
      session_set('viewType', 'linear');
    }


    $html['grid']   = View::renderPartial("product/products-grid.php", $data, true);
    $html['linear'] = View::renderPartial("product/products-linear.php", $data, true);

    echo json_encode($html);
  }



  public function cart() {
    $cart = $this->getOpenCartOrCreate();

    $data['orders']       = ProductModel::fetch_orders_by_cartId($cart['cart_id']);
    $data['invoice_hash'] = PaymentModel::get_invoice_by_invoiceId($cart['invoice_id']);

    setNoIndex();
    setNoFollow();
    setPageTitle("Cart Details");
    View::render("product/cart.php", $data);
  }




  public function perviewCart() {
    $cart = $this->getOpenCartOrCreate();

    $data['orders']       = ProductModel::fetch_orders_by_cartId($cart['cart_id']);
    $data['invoice_hash'] = PaymentModel::get_invoice_by_invoiceId($cart['invoice_id']);

    View::render("product/cart-perview.php", $data);
  }



  public function removeFromCart($orderId) {
    ProductModel::remove_order_by_id($orderId);

    $cart = $this->getOpenCartOrCreate();
    $this->computeAndUpdateCartPrice($cart);
    $this->refreshCartPerview($cart);
  }



  public function addToCart($productId) {
    $cart = $this->getOpenCartOrCreate();

    $foundOrder = ProductModel::fetch_order_by_productId_and_cartId($productId, $cart['cart_id']);

    if ($foundOrder != null) {
      ProductModel::update_order_quantity_by_orderId($foundOrder['order_id'], $foundOrder['quantity'] + 1);
    } else {
      ProductModel::insert_order($cart['cart_id'], $productId, 1);
    }

    $this->computeAndUpdateCartPrice($cart);
    $this->refreshCartPerview($cart);
  }



  public function changeQuantity() {
    $orderId  = post('orderId');
    $quantity = post('quantity');

    ProductModel::update_order_quantity_by_orderId($orderId, $quantity);
  }



  public function refreshCartPerview($cart = null) {
    if ($cart == null) {
      $cart = $this->getOpenCartOrCreate();
    }


    // get rendered of preview cart view
    $previewData['orders']       = ProductModel::fetch_orders_by_cartId($cart['cart_id']);;
    $previewData['invoice_hash'] = PaymentModel::get_invoice_by_invoiceId($cart['invoice_id']);
    $cartPerview                 = View::renderPartial("product/cart-perview.php", $previewData, true);


    $data['cartPerview']    = $cartPerview;
    $data['cartItemsCount'] = ProductModel::get_orders_count_by_cartId($cart['cart_id']);;

    echo json_encode($data);
  }



  public function wish() {
    if (isGuest()) {
      $message = _msg_guest;
      message('fail', $message, true);

      header("Location: " . baseUrl() . "/login");
      return;
    }


//    $isWishClick = session_get('isWishClick');
//
//    if ($isWishClick == '1') {
//      session_set('isWishClick', '0');
//      $data['justWishList'] = 1;
//    } else {
//      session_set('isWishClick', '1');
//      $data['justWishList'] = 0;
//    }
//
//
//    View::render("page/home.php", $data);
    $data['justWishList'] = 1;
    View::render("page/home.php", $data);
  }



  private function computeAndUpdateCartPrice($cart = null) {
    if ($cart == null) {
      $cart = $this->getOpenCartOrCreate();
    }

    $orders = ProductModel::fetch_orders_by_cartId($cart['cart_id']);

    $cartPrice = 0;
    foreach ($orders as $order) {
      $cartPrice += computeDiscountedPrice($order['price'], $order['discount'], $order['quantity']);
    }

    ProductModel::update_cart_price_by_cartId($cart['cart_id'], $cartPrice);
    PaymentModel::update_invoice_price_by_invoiceId($cart['invoice_id'], $cartPrice);
    PaymentModel::update_transaction_price_by_invoiceId($cart['invoice_id'], $cartPrice);

    return $cartPrice;
  }



  private function findOpenCart() {
    $userId    = getUserId();
    $sessionId = session_id();

    $cart = null;

    if (!isGuest()) {
      $cart = ProductModel::fetch_openCart_by_userId($userId);

      if ($cart != null) {
        ProductModel::update_openCartSession_by_cartId($cart['cart_id']);
        return $cart;
      }
    }

    $cart = ProductModel::fetch_openCart_by_sessionId($sessionId);

    if ($cart != null) {
      if (!isGuest()) {
        ProductModel::update_openCartUserId_by_cartId($cart['cart_id'], $userId);
        PaymentModel::update_invoiceUserId_by_invoiceId($cart['invoice_id'], $userId);
      }
    }

    return $cart;
  }



  private function getOpenCartOrCreate() {
    $userId = getUserId();

    $cart = $this->findOpenCart();
    if ($cart != null) {
      return $cart;
    }

    $invoiceId = PaymentModel::create_invoice($userId, 0, getCurrentDateTime(), getCurrentDateTime(), 'سبد خرید');
    ProductModel::insert_cart($userId, $invoiceId);

    $cart = $this->findOpenCart();
    return $cart;
  }



  public function perviewInvoicePayed() {
    $db = Db::getInstance();

    $userId = getUserId();

    $invoicePayeds = $db->query("SELECT * FROM x_invoice LEFT OUTER JOIN x_transaction ON x_invoice.hash=x_transaction.invoice_hash AND x_invoice.user_id=x_transaction.user_id WHERE x_transaction.payed=:payed AND x_transaction.user_id=:user_id", array(
      'user_id' => $userId,
      'payed'   => 1,
    ));

    $data['invoicePayeds'] = $invoicePayeds;
    View::render("product/perview-invoice-payed.php", $data);
  }



  public function perviewInvoiceNoPayed() {
    $db = Db::getInstance();

    $userId = getUserId();

    $invoiceNoPayeds = $db->query("SELECT * FROM x_invoice LEFT OUTER JOIN x_transaction ON x_invoice.hash=x_transaction.invoice_hash AND x_invoice.user_id=x_transaction.user_id WHERE x_transaction.payed!=:payed AND x_transaction.user_id=:user_id", array(
      'user_id' => $userId,
      'payed'   => 1,
    ));

    $data['invoiceNoPayeds'] = $invoiceNoPayeds;
    View::render("product/perview-invoice-no-payed.php", $data);
  }



  public function viewPayedOrder($invoiceId) {
    $db = Db::getInstance();

    $userId = getUserId();

    $cartId = $db->first("SELECT * FROM pym_cart LEFT OUTER JOIN x_invoice ON pym_cart.invoice_id=x_invoice.invoice_id AND pym_cart.user_id=x_invoice.user_id WHERE pym_cart.payed=:payed AND x_invoice.user_id=:user_id", array(
      'user_id' => $userId,
      'payed'   => 1,
    ), 'cart_id');

    $payedOrders = $db->query("SELECT * FROM pym_order LEFT OUTER JOIN pym_product ON pym_order.product_id=pym_product.product_id WHERE pym_order.cart_id=:cart_id", array(
      'cart_id' => $cartId,
    ));

    $data['payedOrders'] = $payedOrders;
    View::render("product/view-payed-order.php", $data);
  }



  public function viewNoPayedOrder($invoiceId) {
    $db = Db::getInstance();

    $userId = getUserId();

    $cartId = $db->first("SELECT * FROM pym_cart LEFT OUTER JOIN x_invoice ON pym_cart.invoice_id=x_invoice.invoice_id AND pym_cart.user_id=x_invoice.user_id WHERE pym_cart.payed!=:payed AND x_invoice.user_id=:user_id", array(
      'user_id' => $userId,
      'payed'   => 1,
    ), 'cart_id');

    $noPayedOrders = $db->query("SELECT * FROM pym_order LEFT OUTER JOIN pym_product ON pym_order.product_id=pym_product.product_id WHERE pym_order.cart_id=:cart_id", array(
      'cart_id' => $cartId,
    ));

    $data['noPayedOrders'] = $noPayedOrders;
    View::render("product/view-no-payed-order.php", $data);
  }


}

?>