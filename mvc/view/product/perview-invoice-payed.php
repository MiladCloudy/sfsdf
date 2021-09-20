<? $totalPrice = 0;?>
<table id="perviewInvoicePayed">
  <colgroup>
    <col style="width: 100px">
    <col style="min-width: 30px;  max-width: 30px">
    <col style="min-width: 30px;  max-width: 30px">
    <col style="min-width: 75px;  max-width: 75px">
    <col style="min-width: 100px; max-width: 100px">
    <col style="min-width: 25px;  max-width: 25px">
    <col style="min-width: 25px;  max-width: 25px">
  </colgroup>

  <thead>
    <th>صورتحساب</th>
    <th>تاریخ صدور صورتحساب</th>
    <th>تاریخ پرداخت صورتحساب</th>
    <th>کد پیگیری پرداخت</th>
    <th>قیمت کل</th>
    <th>وضعیت</th>
    <th>مشاهد</th>
  </thead>


  <? foreach($invoicePayeds as $invoicePayed) { ?>

    <tr class="invoiceItemPayed" style="width: 100%">
      <? if ($invoicePayeds[0] == 'notFound') { ?>
        <span class="notFound">سبد خرید خالی می باشد</span>
        <?return;?>
      <? } ?>

      <td>
        <span>#</span>&nbsp;<span class="invoiceProductPayed"><?=$invoicePayed['transaction_id']?></span>
      </td>

      <td>
        <span class="invoiceProductPayed"><?=$invoicePayed['creationTime']?></span>
      </td>

      <td>
        <span class="invoiceProductPayed"><?=$invoicePayed['paymentTime']?></span>
      </td>

      <td>
        <span class="invoiceProductPayed"><?=$invoicePayed['reference']?></span>
      </td>

      <td>
        <span class="invoiceProductPayed"><?=$invoicePayed['price']?></span>&nbsp;<span>R</span>
      </td>

      <td>
        <? if ($invoicePayed['payed'] == 1) { ?>
          <span class="invoiceProductPayed">
            <span class="icon ic-checkmark"></span>
          </span>
        <? } ?>
      </td>

      <td>
        <a class="navNoActiveBtn" href="/product/viewPayedOrder/<?=$invoicePayed['invoice_id']?>">
          <span class="icon ic-credit-card"></span>
          <span class="invoiceProductPayed">مشاهده</span>
        </a>
      </td>

    </tr>
  <? } ?>
</table>