<div class="wrap">
  <div class="wrapright">
    <div class="wrapright-i" id="item-1" onClick=""><i class="icon ic-dashboard"></i>داشبورد</div>
    <div class="wrapright-i" id="item-PerviewInvoicePayed"><i class="icon ic-list w20f tac"></i>صورتحساب
      های پرداخت شده
    </div>
    <div class="wrapright-i" id="item-1" onClick="getperviewInvoiceNoPayed();"><i class="icon ic-list2 w20f tac"></i>صوتحساب
      های پرداخت نشده
    </div>
    <div class="wrapright-i" id="item-2" onClick=""><i class="icon ic-steam"></i>تنظیمات
    </div>
    <div class="wrapright-i" onClick="" style="border-bottom: 1px solid #ccc;"><i
        class="icon ic-exit"></i>خروج
    </div>
  </div>
  <div class="wrapleft">
    <div class="a-wrapleft-status">
      <span>به پنل کاربری فروشگاه سحام سرویس خوش آمدید</span>
            <span class="wrapleft-status-today">
            <?
              $jalali_date = jdate(getCurrentDateTime(), "امروز : 'd M Y'");
              echo $jalali_date;
              ?>
            </span>
    </div>
  </div>
</div>

