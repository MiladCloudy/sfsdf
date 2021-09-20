<?
class PaymentController {



  public function pay($invoiceHash) {
    if(isGuest()){
      $message = "ابتدا عضو سایت شوید تا مرحله پرداخت قابل انجام باشد.";
      $this->fail($message);
    }

    $invoice = PaymentModel::fetch_invoice_by_hash($invoiceHash);
    $payed = PaymentModel::is_invoice_payed($invoiceHash);

    if($payed){
      $message = "این فاکتور قبلاً پرداخت شده و نیاز به پرداخت مجدد نیست.";
      $this->success($message);
    }

    $geteway = isset($_POST['geteway']) ? $_POST['geteway'] : 'zarinpal';

    $userId              = $_SESSION['user_id'];
    $info['userId']      = $invoice['user_id'];
    $info['invoiceHash'] = $invoiceHash;

    if($userId != $info['userId']){
      $message = "این شماره فاکتور متعلق به شما نیست و قابلیت پرداخت برای آن وجود ندارد";
      $this->fail($message);
    }

    $info['price']  = $invoice['price'];
    $info['email']  = $invoice['email'];
    $info['mobile'] = $invoice['mobile'];
    $info['title']  = $invoice['title'];


    if ($geteway == 'zarinpal'){
      $this->zarinpalPaymentRequest($info);
    }

  }



  private function zarinpalPaymentRequest($info) {
    global $config;
    load_nusoap();

    $client = new nusoap_client('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
    $client->soap_defencoding = 'UTF-8';
    $result = $client->call('PaymentRequest', array(
        array(
          'MerchantID'     => $config['zarinpal']['merchantId'],
          'Amount'         => $info['price'],
          'Description'    => $info['title'],
          'Email'          => $info['email'],
          'Mobile'         => $info['mobile'] == null ? '' : $info['mobile'],
          'CallbackURL'    => fullBaseUrl() . '/payment/zarinpalVerify/' . $info['invoiceHash'],
        ),
      )
    );

    $authority = $result['Authority'];

    $info['authority'] = $authority;
    $this->openTransaction($info);

    if ($result['Status'] == 100) {
      header('Location: https://sandbox.zarinpal.com/pg/StartPay/' . $authority);
    } else {
      $code = $result['Status'];
      $message = 'فرآیند پرداخت با خطا مواجه شد. کد خطا: ';
      $this->fail($message, $code);
    }
  }



  public function zarinpalVerify($invoiceHash) {
    global $config;
    load_nusoap();

    $invoice = PaymentModel::fetch_invoice_by_hash($invoiceHash);

    if ($_GET['Status'] == 'OK') {
      $authority = $_GET['Authority'];

      $client = new nusoap_client('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
      $client->soap_defencoding = 'UTF-8';

      $result = $client->call('PaymentVerification',  array(
        array(
          'MerchantID'     => $config['zarinpal']['merchantId'],
          'Authority'      => $authority,
          'Amount'         => $invoice['price'],
        ),
      )
      );

      if ($result['Status'] == 100) {
        $info['invoiceHash'] = $invoiceHash;
        $info['reference'] = $result['RefID'];
        $info['authority'] = $authority;
        $this->closeTransaction($info);

        $code = $result['RefID'];
        $message = 'فرآیند پرداخت موفقیت آمیز بود. سند رهگیری: ';
        $this->success($message, $code);

      } else if ($result['Status'] == 101) {
        $code = $result['Status'];
        $message = 'فرآیند پرداخت، قبلاً انجام شده و نیاز به تأیید مجدد نیست.';
        $this->success($message, $code);

      } else {
        $code = $result['Status'];
        $message = 'فرآیند پرداخت با خطا مواجه شد. کد خطا:';
        $this->fail($message, $code);

      }
    } else {
      $message = 'فرآیند پرداخت توسط یوزر لغو شد.';
      $this->fail($message);
    }
  }



  private function openTransaction($info) {
    PaymentModel::open_transaction($info['price'], $info['userId'], $info['authority'], $info['invoiceHash']);

  }



  private function closeTransaction($info){
    PaymentModel::close_transaction($info['reference'], $info['invoiceHash']);
    afterCloseTransaction($info);
  }



  private function success($message, $code = ''){
    message('success', $message . $code, true);
  }



  private function fail($message, $code = ''){
    message('fail', $message . $code, true);
  }


}

?>