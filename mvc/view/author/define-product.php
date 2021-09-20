<br>
<br>
<br>
<div class="db">
  <form method="post" action="<?=baseUrl()?>/author/defineProduct" enctype="multipart/form-data">
    <input                  class="wrong w200f" name="title"       placeholder="نام محصول"                             ><br><br>

    <textarea               class="wrong w100"  name="description" placeholder="توضیحات محصول"       style="resize: none;" rows="10"></textarea><br><br>
    <textarea               class="wrong w100"  name="brief"       placeholder="توضیحات کوتاه محصول" style="resize: none;" rows="5"></textarea><br><br>

    <input    type="number" class="wrong w200f" name="price"       placeholder="قیمت محصول"          min="0"           ><br><br>
    <input    type="number" class="wrong w200f" name="discount"    placeholder="تخفیف"               min="0" max="100" ><br><br>
    <input    type="file"   class="wrong"       name="image"       placeholder="تصویر محصول"         accept=".png"><br><br>

    <button   type="submit" class="btn">درج محصول    </button>
    <button   type="reset"  class="btn">خالی کردن فرم</button><br><br>
  </form>
</div>

<script>
  $(function() {

    $('.wrong').on('keypress', function() {
      var wrongBtn = $(this);

      if (wrongBtn.val() == '') {
        wrongBtn.removeClass('correct');
        wrongBtn.addClass('wrong');
      } else {
        wrongBtn.removeClass('wrong');
        wrongBtn.addClass('correct');
      }
    });

    $('.wrong').on('change', function() {
      var wrongBtn = $(this);

      if (wrongBtn.val() == '') {
        wrongBtn.removeClass('correct');
        wrongBtn.addClass('wrong');
      } else {
        wrongBtn.removeClass('wrong');
        wrongBtn.addClass('correct');
      }
    });

  });
</script>