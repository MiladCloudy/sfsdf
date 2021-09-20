<?

function afterCloseTransaction($info) {
  $invoice_id = PaymentModel::fetch_invoice_by_hash($info['invoiceHash']);
  ProductModel::update_cartPayed_by_invoiceId($invoice_id);

}

?>