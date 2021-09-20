<?

function load_nusoap() {
  require_once(getcwd(). '/lib/nusoap/nusoap.php');
}



date_default_timezone_set('Asia/Tehran');

global $config;
require_once(getcwd(). '/config.php');
require_once(getcwd(). '/system/core.php');
require_once(getcwd(). '/system/access.php');
require_once(getcwd(). '/system/common.php');
require_once(getcwd(). '/system/project.php');
require_once(getcwd(). '/system/db.php');
require_once(getcwd(). '/system/view.php');
require_once(getcwd(). '/system/graphic.php');
require_once(getcwd(). '/system/net.php');
require_once(getcwd(). '/locale/' . $config['lang'] . '.php');

session_start();
initializeSettings();
?>