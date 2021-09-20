<? $isGuest = isGuest(); ?>

<div class="tac">
  <? if ($pageCount > 1) { ?>
    <?=pagination('', 5, 'navNoActiveBtn', 'navActiveBtn', $pageIndex, $pageCount, 'reloadData'); br(); br();?>
  <? } ?>
</div>

<? foreach($products as $product) { ?>
  <? if ($products[0] == 'notFound') { ?>
      <span class="notFound-linear">موردی یافت نشد</span>
      <?exit;?>
  <?}?>

  <div class="productPanel-linear">
    <div class="productThumbWrapper-linear">
      <img src="<?=$product['image_path']?>" class="productThumb-linear" alt="<?=$product['alt']?>">
    </div>

    <div class="productPanelRightSide-linear">
      <span class="productName-linear"><?=$product['title']?></span>

      <div class="priceWrapper-linear">
        <? if ($product['discount'] > 0){ ?>
          <span class="oldPrice-linear"><?=$product['price']?></span>&nbsp;<span>R</span>
        <? } ?>

        <span class="currentPrice-linear"><?=$product['price'] - ($product['price'] * $product['discount'] / 100)?>&nbsp;R</span>
      </div>

      <p class="productBrief-linear"><?=$product['brief']?></p>

      <div class="productBtnWrapper-linear">

        <?
        $wishBtnClass = $product['wish_id'] != null ? "wishBtnFilled-linear": "wishBtnEmpty-linear";
        ?>

        <? if(!$isGuest) { ?>
          <span class="wishBtn-linear ic-star-full <?=$wishBtnClass?>" data-product-id="<?=$product['product_id']?>" style="margin-left: 10px;"></span>
        <? } ?>

        <div class="addToCartBtn-linear" onclick="addOrder(<?=$product['product_id']?>)">
          <span class="icon ic-plus"></span>
          <span> &nbsp; اضافه به سبد خرید</span>
        </div>

      </div>
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
  $(".wishBtn-linear").on('click', function(){
    var wishBtn   = $(this);
    var productId = wishBtn.data('product-id');

    $.ajax({
      url: "/user/toggleWishList/1/" + productId,
      method: 'POST',
      dataType: 'JSON'
    }).done(function (output) {
      if(output.isInWishList == 1){
        wishBtn.removeClass('wishBtnEmpty-linear');
        wishBtn.addClass('wishBtnFilled-linear');
      } else {
        wishBtn.removeClass('wishBtnFilled-linear');
        wishBtn.addClass('wishBtnEmpty-linear');
      }
    });
  });

  $(function() {
    $('.productPanel-linear').hover(function () {
      $('#cartPerviewHolder').hide(1000);
    });
  });
</script>
