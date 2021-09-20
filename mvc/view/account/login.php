<div class="tac">
  <br>
  <br>
  <img src="<?=baseUrl()?>/image/shop.png" width="15%">
  <br>
  <br>
  <br>

  <form action="<?=baseUrl()?>/login" method="post">

    <span class="db"><?=_ph_email?></span>
    <br>
    <div class="input-icons">
      <i class="icon ic-mail4"></i>
      <input id="email" type="text" class="dib wrong ltr tac"  placeholder="<?=_ph_email?>" name="email">
    </div>
    <br>

    <span class="db"><?=_ph_password?></span>
    <br>
    <div class="input-icons">
      <i class="icon ic-key"></i>
      <input id="password" type="password" class="dib wrong ltr tac" placeholder="<?=_ph_password?>" name="password">
    </div>
    <br>
    <br>

    <span class="db"><?=_ph_captcha?></span>
    <br>

    <div class="captcha-holder">
      <?=session_set('captcha', generateRand());?>
      <img src="<?=baseUrl()?>/account/captcha/<?=session_get('captcha');?>">
      <input id="captcha1" type="hidden" value="<?=session_get('captcha');?>">
    </div>

    <div class="input-icons">
      <i class="icon ic-lock"></i>
      <input id="captcha"  type="number" name="captcha" class="dib wrong ltr tac" placeholder="<?=_ph_captcha?>" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1'); javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  maxlength="4" rule="captcha">
    </div>
    <br>

    <? if (isset($msg_error)) { ?>
      <div class="dib alert alertDanger">کد امنیتی صحیح وارد نشده است,مجددا امتحان کنید</div>
      <br>
    <? } ?>

    <button id="login" type="submit" class="btn" name="btn-submit" style="vertical-align: middle;" disabled>
        <span class="icon ic-user"></span>
        <span><?=_btn_login?></span>
    </button>
  </form>

  <br>
  <a href="<?=baseUrl()?>/register"><?=_btn_signup?></a>
</div>

<script src="<?=baseUrl()?>/asset/js/account.min.js"></script>