<div class="wrap">
  <div class="wrapright">
    <div class="wrapright-i" id="user-dashboard" onClick="getDashboard()"><i class="icon ic-dice"></i>داشبورد</div>
    <div class="wrapright-i" id="user-perviewInvoicePayed" onClick="getPerviewInvoicePayed()"><i
        class="icon ic-list w20f tac"></i>صورتحساب
      های پرداخت شده
    </div>
    <div class="wrapright-i" id="user-perviewInvoiceNoPayed" onClick="getPerviewInvoiceNoPayed()"><i class="icon ic-list2 w20f tac"></i>صوتحساب
      های پرداخت نشده
    </div>
    <div class="wrapright-i" id="user-setting" onClick=""><i class="icon ic-cog"></i>تنظیمات
    </div>
    <div class="wrapright-i" id="user-exit" onclick="location.href='<?=baseUrl()?>/logout'" style="border-bottom: 1px solid #ccc;">
      <i class="icon ic-exit"></i>خروج
    </div>
  </div>
  <div class="wrapleft">
    <div class="wrapleft-status">
      <div class="user-dashboard"></div>
    </div>
  </div>
</div>

<script>
  function getDashboard() {
    $.ajax('<?=baseUrl()?>/user/getDashboard', {
      type: 'POST',
      dataType: 'JSON',
      success: function (data) {
        //alert(data.html);
        $(".wrapleft").html(data.html);
      }
    });
  }

  function getPerviewInvoicePayed() {
    $.ajax('<?=baseUrl()?>/product/perviewInvoicePayed', {
      type: 'POST',
      dataType: 'JSON',
      success: function (data) {
        //alert(data.html);
        $(".wrapleft").html(data.html);
      }
    });
  }

  function getPerviewInvoiceNoPayed() {
    $.ajax('<?=baseUrl()?>/product/perviewInvoiceNoPayed', {
      type: 'POST',
      dataType: 'JSON',
      success: function (data) {
        //alert(data.html);
        $(".wrapleft").html(data.html);
      }
    });
  }

  $(function () {
    getDashboard();
  });
</script>