
<? $isGuest = isGuest(); ?>

<div id="header-wrapper" class="row">
  <div class="colx-2 tar">
    <div class="cart tac m10lr">
      <span class="icon ic-cart" style="font-size: 10pt"></span>
      <span id="cart-items"></span>
    </div>


    <? if(!$isGuest) { ?>
      <div class="dib p5 fs16">
        <a href="<?=baseUrl()?>/product/wish" class="icon ic-star-full w20f tac" style="font-size: 10pt"></a>
        <a href="<?=baseUrl()?>/product/perviewInvoicePayed" class="icon ic-list w20f tac" style="font-size: 10pt"></a>
        <a href="<?=baseUrl()?>/product/perviewInvoiceNoPayed" class="icon ic-list2 w20f tac" style="font-size: 10pt"></a>
        <a href="<?=baseUrl()?>/product/viewInvoice" class="icon ic-bell w20f tac" style="font-size: 10pt"></a>
        <a href="<?=baseUrl()?>/" class="icon ic-home w20f tac" style="font-size: 10pt"></a>
      </div>
    <? } ?>

    <? if(isVipAuthor()) { ?>
      <div class="dib fs16">
        <a href="<?=baseUrl()?>/author/defineProduct" class="icon ic-eye-plus w20f tac" style="font-size: 10pt"></a>
      </div>
    <? } ?>

  </div>

  <div class="colx-6 tal">
    <? if ($isGuest) { ?>
      <a href="<?=baseUrl()?>/login" class="sbtn" style="margin-left: 10px; vertical-align: middle;">
        <span class="icon ic-user"></span>
        <span><?=_btn_login?></span>
      </a>

      <a href="<?=baseUrl()?>/register" class="sbtn" style="margin-left: 10px; vertical-align: middle;">
        <span class="icon ic-user-plus"></span>
        <span><?=_btn_register?></span>
      </a>

    <? } else { ?>
      <div class="dif" style="vertical-align: middle;">
        <span class="ic-user-check" style="margin-left: 5px; color: #1c1;"></span>
        <span>کاربر گرامی</span>&nbsp; &nbsp; <span><?=session_get('fullname');?></span>
      </div>

      <a href="<?=baseUrl()?>/logout" class="sbtn" style="margin-left: 4px; margin-right: 10px; vertical-align: middle;">
        <span class="icon ic-exit"></span>
        <span><?=_btn_logout?></span>
      </a>

    <? } ?>
  </div>
</div>
