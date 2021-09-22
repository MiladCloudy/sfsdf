
function refreshCartPerview() {
  $.ajax({
    url: "/product/refreshCartPerview",
    method: 'POST',
    dataType: "JSON"
  }).done(function(output) {
    $("#cart-items").text(output.cartItemsCount);
    $("#cartPerviewHolder").html(output.cartPerview);
  });
}


$(function() {
  refreshCartPerview();

  $('#cart-items').on('click', function() {
    $('#cartPerviewHolder').toggle(1000);
  });

  $('#cart-items').hover(function() {
    //$('#cartPerviewHolder').show(1000);
  });
});

