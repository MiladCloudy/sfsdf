<?
  class PaymentModel {



    public static function open_transaction($price, $userId, $authority, $invoiceHash){
      $db = Db::getInstance();
      $time = getCurrentDateTime();

      $db->modify("DELETE FROM x_transaction WHERE invoice_hash=:invoice_hash AND payed=:payed", array(
        'invoice_hash' => $invoiceHash,
        'payed'        => 0,
      ));

      $db->insert("INSERT INTO x_transaction (price, user_id, authority, creationTime, payed, invoice_hash) VALUES (:price, :user_id, :authority, :creationTime, :payed, :invoice_hash)", array(
        'price'        => $price,
        'user_id'      => $userId,
        'authority'    => $authority,
        'creationTime' => $time,
        'payed'        => 0,
        'invoice_hash' => $invoiceHash,
      ));
    }



    public static function close_transaction($reference, $invoiceHash){
      $db = Db::getInstance();
      $time = getCurrentDateTime();
      $db->modify("UPDATE x_transaction SET reference=:reference, payed=:payed, paymentTime=:paymentTime WHERE invoice_hash=:invoice_hash", array(
        'reference'    => $reference,
        'payed'        => 1,
        'paymentTime'  => $time,
        'invoice_hash' => $invoiceHash,
      ));
    }



    public static function get_invoice_by_invoiceId($invoiceId) {
      $db = Db::getInstance();

      $invoiceHash = $db->first("SELECT * FROM x_invoice WHERE invoice_id=:invoice_id", array(
        'invoice_id' => $invoiceId,
      ), 'hash');

      return $invoiceHash;
    }



    public static function fetch_invoice_by_hash($invoiceHash){
      $db = Db::getInstance();
      $record = $db->first("SELECT * FROM x_invoice LEFT OUTER JOIN x_user ON x_invoice.user_id=x_user.user_id WHERE x_invoice.hash=:invoice_hash", array(
        'invoice_hash' => $invoiceHash,
      ));

      return $record;
    }



    public static function create_invoice($userId, $price, $startDate, $endDate, $title = null){
      $db = Db::getInstance();
      $hash = generateHash(32);

      if ($title == null){
        $title = 'یک فاکتور تستی';
      }

      $record = $db->insert("INSERT INTO x_invoice (user_id, price, startDate, endDate, hash, title) VALUES (:user_id, :price, :startDate, :endDate, :hash, :title)", array(
        'hash'      => $hash,
        'price'     => $price,
        'user_id'   => $userId,
        'title'     => $title,
        'startDate' => $startDate,
        'endDate'   => $endDate,
      ));

      return $record;
    }



    public static function is_invoice_payed($invoiceHash){
      $db = Db::getInstance();
      $record = $db->first("SELECT * FROM x_invoice LEFT OUTER JOIN x_transaction ON x_invoice.hash=x_transaction.invoice_hash WHERE x_invoice.hash=:invoice_hash", array(
        'invoice_hash' => $invoiceHash,
      ));

      return $record['payed'];
    }



    public static function fetch_pending_invoices($userId){
      $db = Db::getInstance();
      $records = $db->query("SELECT x_invoice.* FROM x_invoice LEFT OUTER JOIN x_transaction ON x_invoice.hash=x_transaction.invoice_hash WHERE x_invoice.user_id=:user_id AND (x_transaction.payed IS NULL OR x_transaction.payed=:payed)", array(
        'user_id' => $userId,
        'payed'   => 0,
      ));

      return $records;
    }



    public static function found_payed_invoice_for_current_date($userId){
      $db = Db::getInstance();
      $date = getCurrentDateTime();

      $record = $db->first("SELECT x_invoice.* FROM x_invoice LEFT OUTER JOIN x_transaction ON x_invoice.hash=x_transaction.invoice_hash WHERE x_invoice.user_id=:user_id AND x_transaction.payed=:payed AND x_invoice.startDate<:startDate AND x_invoice.endDate>:endDate", array(
        'user_id'   => $userId,
        'payed'     => 1,
        'startDate' => $date,
        'endDate'   => $date,
      ));

      return $record != null;
    }



    public static function update_invoice_price_by_invoiceId($invoiceId, $price){
      $db = Db::getInstance();

      $db->modify("UPDATE x_invoice SET price=:price WHERE invoice_id=:invoice_id", array(
        'invoice_id' => $invoiceId,
        'price'      => $price,
      ));
    }




    public static function update_transaction_price_by_invoiceId($invoiceId, $price){
      $db = Db::getInstance();

      $invoiceHash = PaymentModel::get_invoice_by_invoiceId($invoiceId);

      $db->modify("UPDATE x_transaction SET price=:price WHERE invoice_hash=:invoice_hash", array(
        'invoice_hash' => $invoiceHash,
        'price'        => $price,
      ));
    }



    public static function update_invoiceUserId_by_invoiceId($invoice, $userId) {
      $db = Db::getInstance();

      $db->modify("UPDATE x_invoice SET user_id=:user_id WHERE invoice_id=:invoice_id", array(
        'user_id'    => $userId,
        'invoice_id' => $invoice,
      ));
    }

  }
?>