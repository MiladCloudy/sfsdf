$(function() {
  $("#item-PerviewInvoicePayed").on('click', function () {
    getPerviewInvoicePayed();
  });
});

function getPerviewInvoicePayed() {
  $.ajax('<?=baseUrl()?>/user/getPanelUser', {
    type: 'post',
    dataType: 'json',
    success: function (data) {
      //alert(data.html);
      $("#panel-user").html(data.html);
    }
  });
}

function getperviewInvoiceNoPayed() {
  $.ajax('<?=baseUrl()?>/product/perviewInvoiceNoPayed', {
    type: 'post',
    dataType: 'json',
    success: function (data) {
      //alert(data.html);
      $(".wrapleft").html(data.html);
    }
  });
}