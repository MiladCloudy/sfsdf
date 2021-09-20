<? $totalPrice = 0;?>
<table id="perviewInvoice">
  <colgroup>
    <col style="width: 100px">
    <col style="min-width: 30px;  max-width: 30px">
    <col style="min-width: 30px;  max-width: 30px">
    <col style="min-width: 25px;  max-width: 25px">
    <col style="min-width: 25px;  max-width: 25px">
  </colgroup>

  <thead>
  <th>صورتحساب</th>
  <th>تاریخ صدور صورتحساب</th>
  <th>قیمت کل</th>
  <th>وضعیت</th>
  <th>مشاهد</th>
  </thead>


  <? foreach($invoiceNoPayeds as $invoiceNoPayed) { ?>

    <tr class="invoiceItem" style="width: 100%">
      <? if ($invoiceNoPayeds[0] == 'notFound') { ?>
        <span class="notFound">سبد خرید خالی می باشد</span>
        <?return;?>
      <? } ?>

      <td>
        <span>#</span>&nbsp;<span class="invoiceProductPayed"><?=$invoiceNoPayed['transaction_id']?></span>
      </td>

      <td>
        <span class="invoiceProductPayed"><?=$invoiceNoPayed['creationTime']?></span>
      </td>

      <td>
        <span class="invoiceProductPayed"><?=$invoiceNoPayed['price']?></span>&nbsp;<span>R</span>
      </td>

      <td>
        <? if ($invoiceNoPayed['payed'] == 0) { ?>
          <span class="invoiceProductPayed">
            <span class="icon ic-cross"></span>
          </span>
        <? } ?>
      </td>

      <td>
        <a class="navActiveBtn" href="<?=baseUrl()?>/product/viewNoPayedOrder/<?=$invoiceNoPayed['invoice_id']?>">
          <span class="icon ic-credit-card"></span>
          <span class="invoiceProductPayed">مشاهده</span>
        </a>
      </td>

    </tr>
  <? } ?>
</table>