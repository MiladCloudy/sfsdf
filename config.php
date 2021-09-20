<?
if (!defined('test')){
  echo "Forbidden Request";
  exit;
}

global $config;
$config['db']['host'] = 'localhost';
$config['db']['user'] = 'root';
$config['db']['pass'] = '';
$config['db']['name'] = 'sohamservice_shop';

$config['lang'] = 'fa';

$config['salt'] = 'miladcloudy13758082';
$config['base'] = "/sohamservice-shop";
$config['route'] = array(
  '/login'     => '/account/login',
  '/ورود'      => '/account/login',
  '/logout'    => '/account/logout',
  '/register'  => '/account/register',
  '/profile/*' => '/account/profile/$1',
);

$config['page']['title']    = "Shopping Home";
$config['page']['noindex']  = false;
$config['page']['nofollow'] = false;

$config['zarinpal']['merchantId'] = '556f6731-7994-41f3-8b0e-48a95bef37d4';

?>