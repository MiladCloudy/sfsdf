<? $totalPrice = 0;?>
<table id="cartDetail">
  <colgroup>
    <col style="width: 100px">
    <col style="width: 100%">
    <col style="min-width: 30px; max-width: 30px">
    <col style="min-width: 75px; max-width: 75px">
    <col style="min-width: 100px; max-width: 100px">
    <col style="min-width: 25px; max-width: 25px">
  </colgroup>

  <thead>
    <th>تصویر</th>
    <th>نام محصول</th>
    <th>تعداد</th>
    <th>فی</th>
    <th>قیمت کل</th>
    <th>حذف</th>
  </thead>


  <? foreach($orders as $order) { ?>

    <tr class="cartItem" style="width: 100%">
      <? if ($orders[0] == 'notFound') { ?>
        <span class="notFound">سبد خرید خالی می باشد</span>
        <?return;?>
      <?}?>

      <?
      $productPriceWithDiscount = $order['price'] - ($order['price'] * $order['discount'] / 100);
      $totalPrice += $order['quantity'] * $productPriceWithDiscount;
      ?>

      <?
      if ($order['hasCover'] != 1){
        $path = baseUrl() . "/image/products/default.png";
      } else {
        $path = baseUrl() . "/image/products/" . $order['product_id'] . ".png";
      }
      ?>

      <td>
        <div class="cartProductThumbWrapper">
          <img src="<?=$path?>" class="cartProductThumb">
        </div>
      </td>

      <td>
        <span class="cartProductName"><?=$order['title']?></span>
      </td>

      <td>
        <input class="itemQuantity" data-order-id="<?=$order['order_id']?>" value="<?=$order['quantity']?>" type="number" min="1" max="10" autocomplete="off">
      </td>

      <td>
        <span class="cartCurrentPrice"><?=$productPriceWithDiscount;?></span>&nbsp;<span>R</span>
      </td>

      <td>
        <span class="cartTotalOrderPrice"><?=$productPriceWithDiscount;?></span>&nbsp;<span>R</span>
      </td>

      <td>
        <span class="ic-cross cartRemoveBtn" onclick="removeOrder(this, <?=$order['order_id']?>)"></span>
      </td>

    </tr>
  <? } ?>
</table>

<div id="cartTotal">
  <span>مبلغ نهایی:</span>
  <span id="spanTotalPrice"><?=$totalPrice;?></span>&nbsp;<span>ريال</span>
</div>

<a class="proceedBtn" href="<?=baseUrl()?>/payment/pay/<?=$invoice_hash?>">
  <span class="icon ic-credit-card"></span>
  <span>پرداخت سبد خرید</span>
</a>

<script>

  function updateTotalOrderPrice(control) {
    var quantity = control.val();

    var parent = control.parentsUntil(".cartItem").parent();
    var price  = parent.find('.cartCurrentPrice').text();
    parent.find('.cartTotalOrderPrice').text(price * quantity);
  }


  function updateTotalCartPrice() {
    $("#cartDetail").each(function() {
      var cartDetail = $(this);
      var totalCartPrice = 0;
      cartDetail.find('.cartTotalOrderPrice').each(function() {
        var totalOrderPrice = $(this).text();
        totalCartPrice += parseInt(totalOrderPrice);
      });

      $("#cartTotal").find('#spanTotalPrice').html(totalCartPrice);
    });
  }

  $(function() {
    $(".itemQuantity").each(function() {
      var control = $(this);
      updateTotalOrderPrice(control);
    });

    $(".itemQuantity").on('change', function() {
      var control   = $(this);
      updateTotalOrderPrice(control);
      updateTotalCartPrice();

      var quantity  = control.val();
      var orderId = control.data("order-id");

      $.ajax({
        url: "<?=baseUrl()?>/product/changeQuantity",
        method: 'POST',
        data: {
          'orderId'  : orderId,
          'quantity' : quantity
        }
      }).done(function(output) {
        refreshCartPerview();
      });
    });

    updateTotalCartPrice();
  });

  function removeOrder(sender, productId) {
    $.ajax({
      url: "<?=baseUrl()?>/product/removeFromCart/" + productId,
      method: 'POST',
      dataType: "JSON"
    }).done(function(output) {
      $(sender).parentsUntil(".cartItem").parent().remove();
      updateTotalCartPrice();
    });
  }
</script>