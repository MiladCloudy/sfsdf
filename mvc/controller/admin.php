<?
class AdminController {


  public function __construct() {
    grantAdmin();
  }



  public function promote_user_form() {
    View::render("admin/promote_user.php");
  }



  public function getUserAccess($userId) {
    $output['access'] = UserModel::get_user_access($userId);
    echo json_encode($output);
  }



  public function promote() {
    $userId = $_POST['userId'];
    $access = $_POST['access'];

    /*
    $accessArray = explode(',', $access);
    $nameAccess = implode('|', $accessArray);
    */

    $access = str_replace(' ', '', $access);
    $access = '|' . str_replace(',', '|', $access) . '|';

    UserModel::promote_user($userId, $access);
    echo "OK";
    //View::render("admin/promote_user.php");
  }
}
?>