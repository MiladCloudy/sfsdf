<script src="<?=baseUrl()?>/asset/js/home.min.js"></script>

<div class="row" style="padding: 0px 15px;">
  <div class="colx-3 colm-fill">
    <strong>مرتب سازی بر اساس</strong>
    <select id="sortType">
      <option value="price-asc">از ارزان به گران</option>
      <option value="price-desc">از گران به ارزان</option>
      <option value="rate-desc">محبوبیت</option>
      <option value="creationTime-asc">قدیمی تر به جدیدتر</option>
      <option value="creationTime-desc">جدیدتر به قدیمی تر</option>
    </select>
  </div>

  <div class="colx-3 colm-fill">
    <strong>جستجو</strong>
    <input type="text" value="" placeholder="جستجو" id="keyword" >
  </div>

  <div class="colx-2 colm-0">
    <div class="dif fg"></div>
    <div style="margin-right: 40px;" class="dib">
      <span  id="displayAsList" class="viewTypeBtn ic-list"></span>
      <span  id="displayAsGrid" class="viewTypeBtn ic-table2"></span>
      <input id="viewType" type="hidden" value="<?=session_get('viewType')?>">
    </div>

    <? if(isset($justWishList) && $justWishList == 1){ ?>
      <input id="filter" type="hidden" value="wish">
    <? } else { ?>
      <input id="filter" type="hidden" value="all">
    <? } ?>
  </div>

</div>

<div id="productsGrid" class="colm-0">

</div>

<div id="productsLinear" class="colm-fill">

</div>