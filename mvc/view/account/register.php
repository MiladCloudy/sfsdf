<div class="tac">
  <br>
  <br>
  <img src="<?=baseUrl()?>/image/shop.png" width="15%">
  <br>
  <br>
  <br>
  <form action="<?=baseUrl()?>/register" method="post">
    <span class="db"><?=_ph_email?></span>
    <br>

    <div class="input-icons">
      <i class="icon ic-mail4"></i>
      <input id="email" type="text" class="dib wrong ltr tac" placeholder="<?=_ph_email?>" name="email">
    </div>
    <br>
    <br>

    <span class="db"><?=_ph_password?></span>
    <br>
    <div class="input-icons">
      <i class="icon ic-key"></i>
      <input id="password1" type="password" class="dib wrong ltr tac"  placeholder="<?=_ph_password?>" name="password1">
    </div>

    <div class="input-icons">
      <i class="icon ic-key"></i>
      <input id="password2" type="password" class="dib wrong ltr tac" placeholder="<?=_ph_confirm_password?>" name="password2">
    </div>
    <br>
    <br>

    <span class="db"><?=_ph_name?></span>
    <br>

    <div class="input-icons">
      <i class="icon ic-info"></i>
      <input id="name" type="text" class="dib wrong rtl tac" placeholder="<?=_ph_name?>" name="name">
    </div>


    <div class="input-icons">
      <i class="icon ic-user-tie"></i>
      <input id="nickname" type="text" class="dib wrong rtl tac" placeholder="<?=_ph_nickname?>" name="nickname">
    </div>
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


    <button id="register" type="submit" class="btn" name="btn-submit" style="vertical-align: middle;">
      <span class="icon ic-user-plus"></span>
      <span><?=_btn_register?></span>
    </button>

  </form>

  <br>
  <a href="<?=baseUrl()?>/login" style="vertical-align: middle;"><?=_btn_login?></a>

</div>

<script src="<?=baseUrl()?>/asset/js/account.min.js"></script>
