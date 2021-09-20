<?

function hr($return = false) {
  if ($return) { return "<hr>\n"; } echo "<hr>\n";
}



function br($return = false) {
  if ($return) { return "<br>\n"; } echo "<br>\n";
}



function dump($var, $return = false) {
  if (is_array($var)) {
    $out = print_r($var, true);
  } else if (is_object($var)) {
    $out = var_export($var, true);
  } else {
    $out = $var;
  }

  if ($return) {
    return "\n<pre style='direction: ltr'>$out</pre>\n";
  }

  echo "\n<pre style='direction: ltr'>$out</pre>\n";
}



function getUserId(){
  if(session_isset('user_id')){
    return session_get('user_id');
  }

  return 0;
}



function getCurrentDateTime() {
  return date("Y-m-d H:i:s");
}



function encryptPassword($password) {
  global $config;
  return md5($password . $config['salt']);
}



function getFullUrl() {
  $fullurl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  return $fullurl;
}



function getRequestUri() {
  return $_SERVER['REQUEST_URI'];
}



function baseUrl() {
  global $config;
  return $config['base'];
}



function fullBaseUrl() {
  global $config;
  return 'http://' . $_SERVER['HTTP_HOST'] . $config['base'];
}



function strhas($string, $search, $caseSensitive = false) {
  if ($caseSensitive) {
    return strpos($string, $search) !== false;
  } else {
    return strpos(strtolower($string), strtolower($search)) !== false;
  }
}



function message($type, $message, $mustExit = false, $args = array()) {
  $data['message'] = $message;
  $string = View::renderPartial("message/$type.php", $data, true);

  foreach ($args as $arg=>$value) {
    $string = str_replace(':' . $arg, $value, $string);
  }

  $content = $string;
  require_once(getcwd(). "/theme/default.php");

  if ($mustExit) {
    exit;
  }
}



function twoDigitNumber($number) {
  return ($number < 10) ? $number = "0" . $number : $number;
}



//1970-01-01 00:00:00 = 1348-10-11 00:00:00
function jdate($date, $format = "Y-m-d") {
  $timestamp = strtotime($date);
  $secondsInOneDay = 24 * 60 * 60;
  $daysPassed = floor($timestamp / $secondsInOneDay) + 1;

  $days = $daysPassed;
  $day = 11;
  $month = 11;
  $year = 1348;

  $days -= 19;

  $daysInMonths = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
  $monthNames = array(
    'فروردین',
    'اردیبهشت',
    'خرداد',
    'تیر',
    'مرداد',
    'شهریور',
    'مهر',
    'آبان',
    'آذر',
    'دی',
    'بهمن',
    'اسفند'
  );

  while (true) {
    if ($days > $daysInMonths[$month - 1]) {
      $days -= $daysInMonths[$month - 1];
      $month++;
      if ($month == 13) {
        $year++;
        if (($year - 1347) % 4 == 0) {
          $days--;
        }

        $month = 1;
      }
    } else {
      break;
    }
  }

  $month = twoDigitNumber($month);
  $days  = twoDigitNumber($days);

  header('Content-Type: text/html; charset=utf-8');
  $monthName = $monthNames[$month - 1];

  $output = $format;
  $output = str_replace("Y", $year, $output);
  $output = str_replace("m", $month, $output);
  $output = str_replace("d", $days, $output);
  $output = str_replace("M", $monthName, $output);

  return $output;
}



function pagination($url, $showCount, $activeClass, $deactiveClass, $currentPageIndex, $pageCount, $jsFunction = null){
  ob_start();

  if ($jsFunction){
    $tags = "span";
    $action = 'onclick="' . $jsFunction . '(#)"';
  } else {
    $tags = "a";
    $action = 'href="' . $url . '/#"';
  }
  ?>

  <? $rAction = str_replace("#", "1", $action);?>

  <? if ($currentPageIndex != 1) { ?>
    <<?=$tags?> <?=$rAction?> class="<?=$activeClass?>">1</<?=$tags?>>
    <? } else { ?>
    <<?=$tags?> <?=$rAction?> class="<?=$deactiveClass?>">1</<?=$tags?>>
    <? } ?>

  <span>..</span>
  <? for ($i=$currentPageIndex - $showCount; $i <=$currentPageIndex + $showCount; $i++) { ?>
    <? if ($i <= 1) { continue; }?>
    <? if ($i >= $pageCount) { continue; }?>
    <? if ($i == $currentPageIndex) { ?>
      <span class="<?=$deactiveClass?>"><?=$i?></span>
    <? } else { ?>
      <? $rAction = str_replace("#", $i, $action);?>
      <<?=$tags?> <?=$rAction?> class="<?=$activeClass?>"><?=$i?></<?=$tags?>>
    <? } ?>
  <? } ?>
  <span>..</span>
  <? $rAction = str_replace("#", $pageCount, $action);?>

  <? if ($currentPageIndex != $pageCount) { ?>
    <<?=$tags?> <?=$rAction?> class="<?=$activeClass?>"><?=$pageCount?></<?=$tags?>>
    <? } else { ?>
    <<?=$tags?> <?=$rAction?> class="<?=$deactiveClass?>"><?=$pageCount?></<?=$tags?>>
    <? } ?>

  <?

  $output = ob_get_clean();
  return $output;
}



function generateHash($length = 32) {
  $characters = '2345679acdefghjkmnpqrstuvwxyz';
  $charactersLength = strlen($characters);
  $randomString = '';

  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }

  return $randomString;
}


function generateRand() {
  return rand(1000, 9999);
}

function initializeSettings(){
  session_set_if_undefined('viewType', 'grid');
  session_set_if_undefined('isWishClick', '0');
}



function session_get($field, $default = null){
  if(isset($_SESSION[$field])){
    return $_SESSION[$field];
  }

  return $default;
}



function session_set($field, $value){
  $_SESSION[$field] = $value;
}



function session_set_if_undefined($field, $value){
  if(!isset($_SESSION[$field])){
    $_SESSION[$field] = $value;
  }
}



function session_isset($field){
  return isset($_SESSION[$field]);
}



function post_isset($field){
  return isset($_POST[$field]);
}



function post($field, $default = null){
  if(isset($_POST[$field])){
    return $_POST[$field];
  }

  return $default;
}



function computeDiscountedPrice($price, $discount, $quantity = 1){
  return  $quantity * ($price - $discount * $price / 100);
}



function setPageTitle($title) {
  global $config;
  $config['page']['title'] = "Shopping | " . $title;
}



function setNoIndex() {
  global $config;
  $config['page']['noindex'] = true;
}



function setNoFollow() {
  global $config;
  $config['page']['nofollow'] = true;
}



function getRobotState() {
  global $config;

  if ($config['page']['noindex']) {
    $pattern[] = 'noindex';
  } else {
    $pattern[] = 'index';
  }

  if ($config['page']['nofollow']) {
    $pattern[] = 'nofollow';
  } else {
    $pattern[] = 'follow';
  }

  $patternStr = implode(',', $pattern);
  return $patternStr;
}



?>