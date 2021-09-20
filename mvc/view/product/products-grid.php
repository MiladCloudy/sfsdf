<? $isGuest = isGuest(); ?>

<div class="tac">
  <? if ($pageCount > 1) { ?>
    <?=pagination('', 5, 'navNoActiveBtn', 'navActiveBtn', $pageIndex, $pageCount, 'reloadData'); br(); br();?>
  <? } ?>
</div>

<? foreach ($products as $product) { ?>
  <? if ($products[0] == 'notFound') { ?>
    <span class="notFound">موردی یافت نشد</span>
    <? exit; ?>
  <? } ?>

  <div class="productPanel">
    <div class="productThumbWrapper">
      <img src="<?=$product['image_path']?>" class="productThumb" alt="<?=$product['alt']?>">
    </div>

    <span class="productName"><?= $product['title'] ?></span>

    <? if ($product['discount'] > 0) { ?>
      <span class="discountFlag">فروش ویژه</span>
    <? } else { ?>
      <span class="saleFlag">موجود</span>
    <? } ?>


    <?
      $wishBtnClass = $product['wish_id'] != null ? "wishBtnFilled": "wishBtnEmpty";
    ?>

    <? if(!$isGuest) { ?>
      <span class="wishBtn ic-star-full <?=$wishBtnClass?>" data-product-id="<?=$product['product_id']?>"></span>
    <? } ?>


    <div class="priceWrapper">
      <? if ($product['discount'] > 0) { ?>
        <span class="oldPrice"><?= $product['price'] ?></span>&nbsp;<span>R</span>
      <? } ?>

      <span class="currentPrice"><?= $product['price'] - ($product['price'] * $product['discount'] / 100) ?>
        &nbsp;R</span>
    </div>

    <div class="addToCartBtn" onclick="addOrder(<?= $product['product_id'] ?>)">
      <span class="icon ic-plus"></span>
      <span> &nbsp; اضافه به سبد خرید</span>
    </div>
  </div>
<? } ?>

<div class="tac">
  <? if ($pageCount > 1) { ?>
    <? br();?>
    <?=pagination('', 5, 'navNoActiveBtn', 'navActiveBtn', $pageIndex, $pageCount, 'reloadData');?>
  <? } ?>
</div>

<script>
  $(".wishBtn").on('click', function(){
    var wishBtn   = $(this);
    var productId = wishBtn.data('product-id');

    $.ajax({
      url: "<?=baseUrl()?>/user/toggleWishList/1/" + productId,
      method: 'POST',
      dataType: 'JSON'
    }).done(function (output) {
      if(output.isInWishList == 1){
        wishBtn.removeClass('wishBtnEmpty');
        wishBtn.addClass('wishBtnFilled');
      } else {
        wishBtn.removeClass('wishBtnFilled');
        wishBtn.addClass('wishBtnEmpty');
      }
    });
  });

  $(function() {
    $('.productPanel').hover(function () {
     // $('#cartPerviewHolder').hide(1000);
    });
  });
</script>
