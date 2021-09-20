<script src="<?=baseUrl()?>/asset/js/header.min.js"></script>

<? $isGuest = isGuest(); ?>

<div id="header-wrapper" class="row">
  <div class="colx-1 colm-4 tar">
    <div class="cart tac m10lr">
      <span class="icon ic-cart" style="font-size: 10pt"></span>
      <span id="cart-items"></span>
    </div>

    <? if(!$isGuest) { ?>
      <a href="<?=baseUrl()?>/page/home" class="icon ic-bell w20f tac" style="font-size: 10pt"></a>
      <a href="<?=baseUrl()?>/product/wish" class="icon ic-star-full w20f tac" style="font-size: 10pt"></a>
      <a href="<?=baseUrl()?>/author/defineProduct" class="icon ic-printer w20f tac" style="font-size: 10pt"></a>
    <? } ?>
  </div>

  <div class="colx-5 colm-0"></div>
  <div class="colx-2 colm-4 tal">
    <? if ($isGuest){ ?>
      <a href="<?=baseUrl()?>/login" class="sbtn" style="margin-left: 10px;">ورود</a>
      <a href="<?=baseUrl()?>/register" class="sbtn" style="margin-left: 10px;">ثبت نام</a>
    <? } else { ?>
      <span style="margin-left: 10px"> <span>کاربر گرامی</span> <?=session_get('fullname');?></span>
      <a href="<?=baseUrl()?>/logout" class="sbtn" style="float: left; clear: both; margin-left: 10px;">خروج</a>
    <? } ?>
  </div>
</div>
