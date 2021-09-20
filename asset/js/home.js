function reloadData(pageIndex) {
  pageIndex = pageIndex || 1;

  var sortType = $("#sortType").val();
  var keyword  = $("#keyword").val();
  var viewType = $("#viewType").val();
  var filter   = $("#filter").val();

  $.ajax({
    url: '/product/search/' + pageIndex,
    method: 'POST',
    dataType: 'JSON',
    data: {
      'sortType': sortType,
      'keyword' : keyword,
      'viewType': viewType,
      'filter'  : filter
    }
  }).done(function(output) {
    $("#productsGrid").empty();
    $("#productsLinear").empty();

    $("#productsGrid").append(output.grid);
    $("#productsLinear").append(output.linear);

    if (viewType == "linear") {
      $("#productsLinear").show();
      $("#productsGrid").hide();
    } else {
      $("#productsLinear").hide();
      $("#productsGrid").show();
    }

  });
}

function addOrder(productId) {
  $.ajax({
    url: "/product/addToCart/" + productId,
    method: 'POST',
    dataType: "JSON"
  }).done(function(output) {
    $("#cart-items").text(output.cartItemsCount);
    $("#cartPerviewHolder").html(output.cartPerview);
  });

  refreshCartPerview();
}

function removeOrder(productId) {
  $.ajax({
    url: "/product/removeFromCart/" + productId,
    method: 'POST',
    dataType: "JSON"
  }).done(function(output) {
    $("#cart-items").text(output.cartItemsCount);
    $("#cartPerviewHolder").html(output.cartPerview);
  });

  refreshCartPerview();
}

$(function() {

  $("#sortType").on('change', function () {
    reloadData();
  });

  $("#displayAsList").on('click', function () {
    $('#viewType').val('linear');
    reloadData();
  });

  $("#displayAsGrid").on('click', function () {
    $('#viewType').val('grid');
    reloadData();
  });

  $("#keyword").on('keyup', function () {
    reloadData();
  });

  reloadData();
});
