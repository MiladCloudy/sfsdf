<style>
  /* Style the tab */
  .tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
  }

  /* Style the buttons inside the tab */
  .tab button {
    background-color: inherit;
    float: right;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 10px 16px;
    transition: 0.3s;
    font-size: 17px;
  }

  /* Change background color of buttons on hover */
  .tab button:hover {
    background-color: #ddd;
  }

  /* Create an active/current tablink class */
  .tab button.active {
    background-color: #ccc;
  }

  /* Style the tab content */
  .tabcontent {
    border: 1px solid #ccc;
    border-top: none;
  }

  .dn {
    display: none;
  }

  .db {
    display: block;
  }

</style>

<? if (!isGuest()) { ?>
  <div class="tab">
    <button class="tablinks" onclick="openTabPanel(this, 'panel-user')">پنل کاربر</button>

    <? if (isRepairman()) { ?>
      <button class="tablinks" onclick="openTabPanel(this, 'panel-repairman')">پنل تعمیرکار</button>
    <? } ?>

    <? if (isColleague()) { ?>
      <button class="tablinks" onclick="openTabPanel(this, 'panel-colleague')">پنل همکار</button>
    <? } ?>

    <? if (isAdmin()) { ?>
      <button class="tablinks" onclick="openTabPanel(this, 'panel-admin')">پنل مدیر</button>
    <? } ?>

    <? if (isSuperAdmin()) { ?>
      <button class="tablinks" onclick="openTabPanel(this, 'panel-superadmin')">پنل مدیرکل</button>
    <? } ?>

  </div>

  <div id="panel-user" class="tabcontent dn"></div>

  <? if (isRepairman()) { ?>
    <div id="panel-repairman" class="tabcontent dn">
      <h3>پنل تعمیرکار</h3>
    </div>
  <? } ?>

  <? if (isColleague()) { ?>
    <div id="panel-colleague" class="tabcontent dn">
      <h3>پنل همکار</h3>
    </div>
  <? } ?>


  <? if (isAdmin()) { ?>
    <div id="panel-admin" class="tabcontent dn">
      <h3>پنل مدیر</h3>
    </div>
  <? } ?>

  <? if (isSuperAdmin()) { ?>
    <div id="panel-superadmin" class="tabcontent dn">
      <h3>پنل مدیرکل</h3>
    </div>
  <? } ?>

  <script>
    function getPanelUser() {
      $.ajax({
        url: '<?=baseUrl()?>/user/getPanelUser',
        method: 'POST',
        dataType: "JSON"
      }).done(function(output) {
        $("#panel-user").html(output.html);
      });
    }

    function openTabPanel(sender, panelId) {
      var activeClass = $(".tab").find(".active");
      activeClass.removeClass('active');

      sender = $(sender);
      sender.addClass('active');

      var tabcontent = $(".tabcontent");
      if (tabcontent.hasClass('db')) {
        tabcontent.removeClass('db');
        tabcontent.addClass('dn');
      }

      var tabcontentByPanelId = $(".tabcontent#" + panelId)

      if (tabcontentByPanelId.hasClass('dn')) {
        tabcontentByPanelId.removeClass('dn');
        tabcontentByPanelId.addClass('db');
      }

      if (panelId == 'panel-user') {
        getPanelUser();
      }
    }

    $(function () {
      openTabPanel(this, 'panel-user');
    });
  </script>
<? } ?>
<!---->
<!--<script>-->
<!--  function openTabPanel(evt, panelName) {-->
<!--    var i, tabcontent, tablinks;-->
<!--    tabcontent = document.getElementsByClassName("tabcontent");-->
<!--    for (i = 0; i < tabcontent.length; i++) {-->
<!--      tabcontent[i].style.display = "none";-->
<!--    }-->
<!--    tablinks = document.getElementsByClassName("tablinks");-->
<!--    for (i = 0; i < tablinks.length; i++) {-->
<!--      tablinks[i].className = tablinks[i].className.replace(" active", "");-->
<!--    }-->
<!--    document.getElementById(panelName).style.display = "block";-->
<!--    evt.currentTarget.className += " active";-->
<!--  }-->
<!--</script>-->
