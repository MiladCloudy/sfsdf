<form action="<?=baseUrl()?>/admin/promote" method="post">
  <div class="ltr">
    <input type="text" name="userId" id="userId" placeholder="User ID">
    <br>
    <br>
    <input type="text" name="access" id="access" style="width: 300px;" placeholder="Access Names ( Seperated By , )">
    <br>
    <br>
    <button class="btn" type="submit">Promote</button>
  </div>
</form>

<script>
  $(function(){
    $('#userId').on('keyup', function(){
      var value = $(this).val();
      $.ajax('<?=baseUrl()?>/admin/getUserAccess/' + value, {

        dataType: 'json',
        success: function(data){
          var access = data.access.replaceAll(/\|/g, ',', data.access);
          access = access.substring(1, access.length - 1);
          $('#access').val(access);
        }

      });
    });
  });
</script>