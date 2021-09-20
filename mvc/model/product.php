<?
  class ProductModel {



    public static function fetch_orders_by_cartId($cartId){
      $db = Db::getInstance();

      $orders = $db->query("SELECT * FROM pym_order LEFT OUTER JOIN pym_product ON pym_order.product_id=pym_product.product_id WHERE pym_order.cart_id=:cart_id", array(
        'cart_id' => $cartId,
      ));

      return $orders;
    }



    public static function remove_order_by_id($orderId){
      $db = Db::getInstance();

      $db->modify("DELETE FROM pym_order WHERE order_id=:order_id", array(
        'order_id' => $orderId,
      ));
    }



    public static function fetch_order_by_productId_and_cartId($productId, $cartId){
      $db = Db::getInstance();

      $order = $db->first("SELECT * FROM pym_order WHERE product_id=:product_id AND cart_id=:cart_id", array(
        'product_id' => $productId,
        'cart_id'    => $cartId,
      ));

      return $order;
    }



    public static function update_order_quantity_by_orderId($orderId, $quantity){
      $db = Db::getInstance();

      $db->modify("UPDATE pym_order SET quantity=:quantity WHERE order_id=:order_id", array(
        'order_id' => $orderId,
        'quantity' => $quantity,
      ));
    }



    public static function insert_order($cartId, $productId, $quantity) {
      $db = Db::getInstance();

      $lastId = $db->insert("INSERT INTO pym_order (product_id, quantity, cart_id) VALUES (:product_id, :quantity, :cart_id)", array(
        'product_id' => $productId,
        'quantity'   => $quantity,
        'cart_id'    => $cartId,
      ));

      return $lastId;
    }



    public static function insert_cart($userId, $invoiceId) {
      $db = Db::getInstance();

      $lastId = $db->insert("INSERT INTO pym_cart (user_id, session_id, payed, invoice_id) VALUES (:user_id, :session_id, :payed, :invoice_id)", array(
        'invoice_id' => $invoiceId,
        'user_id'    => $userId,
        'session_id' => session_id(),
        'payed'      => 0,
      ));

      return $lastId;
    }



    public static function update_cart_price_by_cartId($cartId, $price) {
      $db = Db::getInstance();

      $db->modify("UPDATE pym_cart SET price=:price WHERE cart_id=:cart_id", array(
        'cart_id' => $cartId,
        'price'   => $price,
      ));
    }



    public static function update_cartPayed_by_invoiceId($invoice_id) {
      $db = Db::getInstance();

      $db->modify("UPDATE pym_cart SET payed=1 WHERE invoice_id=:invoice_id", array(
        'invoice_id' => $invoice_id,
      ));
    }



    public static function get_orders_count_by_cartId($cartId) {
      $db = Db::getInstance();

      $total = $db->first("SELECT COUNT(pym_order.order_id) AS total FROM pym_order LEFT OUTER JOIN pym_cart ON pym_order.cart_id=pym_cart.cart_id WHERE pym_order.cart_id=:cart_id", array(
        'cart_id' => $cartId,
      ), 'total');

      return $total;
    }



    public static function fetch_openCart_by_userId($userId) {
      $db = Db::getInstance();

      $cart = $db->first("SELECT * FROM pym_cart WHERE payed IS NULL OR payed!=1 AND user_id=:user_id", array(
        'user_id' => $userId,
      ));

      return $cart;
    }



    public static function fetch_openCart_by_sessionId($sessionId) {
      $db = Db::getInstance();

      $cart = $db->first("SELECT * FROM pym_cart WHERE payed IS NULL OR payed!=1 AND session_id=:session_id", array(
        'session_id' => $sessionId,
      ));

      return $cart;
    }



    public static function update_openCartSession_by_cartId($cartId) {
      $db = Db::getInstance();

      $db->modify("UPDATE pym_cart SET session_id=:session_id WHERE cart_id=:cart_id", array(
        'session_id' => session_id(),
        'cart_id'    => $cartId,
      ));
    }



    public static function update_openCartUserId_by_cartId($cartId, $userId) {
      $db = Db::getInstance();

      $db->modify("UPDATE pym_cart SET user_id=:user_id WHERE cart_id=:cart_id", array(
        'user_id' => $userId,
        'cart_id' => $cartId,
      ));
    }



    public static function add_product($title, $description, $brief, $price, $discount, $hasCover) {
      $db   = Db::getInstance();
      $time = getCurrentDateTime();

      $productId = $db->insert("INSERT INTO pym_product (title, description, brief, price, discount, hasCover, creationTime) VALUES (:title, :description, :brief, :price, :discount, :hasCover, :creationTime)", array(
        'title'        => $title,
        'description'  => $description,
        'brief'        => $brief,
        'price'        => $price,
        'discount'     => $discount,
        'hasCover'     => $hasCover,
        'creationTime' => $time,

      ));

      return $productId;
    }



  }
?>