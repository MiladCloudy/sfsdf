<?
class View {
  public static function render($filePath, $data = array()){
    extract($data);

    ob_start();
    require_once(getcwd(). "/mvc/view/" . $filePath);

    // don't remove below $content that requires for rendering template
    $content = ob_get_clean();

    require_once(getcwd(). "/theme/default.php");
  }

  public static function renderPartial($filePath, $data = array(), $return = false){
    extract($data);

    if($return) {
      ob_start();
    }

    require_once(getcwd(). "/mvc/view/" . $filePath);

    if($return) {
      return ob_get_clean();
    }
  }
}

?>