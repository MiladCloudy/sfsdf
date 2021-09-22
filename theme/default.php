<!DOCTYPE html>
<html lang="fa">
<head>
  <?global $config?>
  <meta charset="utf-8">
  <!--  <link rel="canonical" href="https://bettydoll.ir/" />-->
  <meta name="robots" content="<?= getRobotState() ?>">
  <meta name="description" content="This is home page for Shopping project created at https://savis-depc.ir"/>
  <meta name="keyword" content="shopping, market, tutorial, sample project"/>
  <link rel="stylesheet" href="<?= baseUrl() ?>/asset/style/grid.min.css">
  <link rel="stylesheet" href="<?= baseUrl() ?>/asset/style/theme.min.css?v107">
  <link rel="stylesheet" type="text/css" href="<?= baseUrl() ?>/asset/font/menu-panel-user/font-awesome.min.css">


  <title><?=$config['page']['title']?></title>
  <script src="<?= baseUrl() ?>/asset/js/jquery-3.4.1.min.js"></script>
  <script src="<?= baseUrl() ?>/asset/js/common.js"></script>
  <script src="<?= baseUrl() ?>/asset/js/header.min.js"></script>

  <script type="text/javascript" src="<?= baseUrl() ?>/asset/js/menu-panel-user/functions.js"></script>

  <!--<script src="https://www.zarinpal.com/webservice/TrustCode" type="text/javascript"></script>-->
</head>
<body>

<? require_once('header.php'); ?>

<div id="cartPerviewHolder"></div>


<div id="content">
  <?=$content?>
</div>

<br>
<br>
<br>
<? require_once('footer.php'); ?>

</body>
</html>
