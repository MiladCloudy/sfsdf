<? $totalPrice = 0;?>

<? foreach($orders as $order) { ?>
  <? if ($orders[0] == 'notFound') { ?>
    <span class="notFound">سبد خرید خالی می باشد</span>
    <?return;?>
  <?}?>

  <?
    $productPriceWithDiscount = $order['price'] - ($order['price'] * $order['discount'] / 100);
    $totalPrice += $order['quantity'] * $productPriceWithDiscount;
  ?>
  <div class="cartPerviewPanel">
    <div class="cartPerviewProductThumbWrapper">
      <?
        if ($order['hasCover'] != 1){
          $path = baseUrl() . "/image/products/default.png";
        } else {
          $path = baseUrl() . "/image/products/" . $order['product_id'] . ".png";
        }
      ?>

      <img src="<?=$path?>" class="cartPerviewProductThumb">
    </div>

    <div class="cartPerviewPanelRightSide">
      <span class="cartPerviewProductName"><?=$order['title']?></span>

      <div style="display: flex;flex-direction: row-reverse;">
        <span class="cartPerviewQuantity"><?=$order['quantity']?></span>&nbsp;x&nbsp;
        <span class="cartPerviewCurrentPrice"><?=$productPriceWithDiscount;?></span>&nbsp;<span>R</span>
      </div>

    </div>

    <span class="ic-cross cartPerviewRemoveBtn" onclick="removeOrder(<?=$order['order_id']?>)"></span>
  </div>
<? } ?>


<div class="cartPerviewTotal">
  <span>مبلغ نهایی:</span>
  <span><?=$totalPrice;?></span>&nbsp;<span>ريال</span>
</div>

<a class="proceedBtn" href="/payment/pay/<?=$invoice_hash?>">
  <span class="icon ic-credit-card"></span>
  <span>پرداخت سبد خرید</span>
</a>

<a class="proceedBtn" href="/product/cart/">
  <span class="icon ic-cart"></span>
  <span>مشاهده سبد خرید</span>
</a>