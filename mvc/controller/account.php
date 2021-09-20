<?
class AccountController {

  public function __construct() {}



  public function logout() {
    session_destroy();
    header("Location: " . fullBaseUrl());

    session_start();
    session_regenerate_id();

    initializeSettings();
  }



  public function profile($userId) {
    echo "User Profile: " . $userId;
  }



  public function login() {
    $email = null;
    $data['msg_error'] = array();

    if(post_isset('btn-submit')) {
      if(post('captcha') == session_get('captcha')) {
        $email = post('email');

      } else {
        $data['msg_error'] = true;
        View::render("account/login.php", $data);
      }
    }


    if (!isGuest()) {
      $message = _already_logged_in . session_get('email');
      message('success', $message, true);

      header("Location: " . baseUrl() . "/page/home");
      return;
    }


    // show login form if not provided
    if ($email == null) {
      setPageTitle("Login");
      View::render("account/login.php");
      return;
    }


    // check login information to be valid
    $email     =  post('email');
    $password  =  post('password');

    $record = AccountModel::fetch_by_email($email);

    if ($record == null) {
      setPageTitle("Login Failure");
      message('fail', _email_not_registered, true);
    } else {
      $hashedPassword = encryptPassword($password);
      if ($hashedPassword == $record['password']){

        session_set('email', $record['email']);
        session_set('fullname', $record['fullname']);
        session_set('nickname', $record['nickname']);
        session_set('user_id', $record['user_id']);
        session_set('access', $record['access']);

        setPageTitle("Login Succeed");
        message('success', _login_welcome, true);
      } else {
        message('fail', _invalid_password, true);
      }
    }
  }



  public function captcha($nums) {
    header('Content-text:image/png');

    if (session_isset('captcha')) {

      $width  = 170;
      $height = 40;
      $image  = imagecreate($width, $height);

      imagecolorallocatealpha($image, 30, 30, 30, 190);

      $numbers_color = imagecolorallocate($image, 220, 180, 18);
      $font_size     = 25;
      $angle         = 2;
      $font          = realpath('asset/font/captcha/MATURASC.TTF');

      $image_width  = imagesx($image);
      $image_height = imagesy($image);

      // Get Bounding Box Size
      $text_box = imagettfbbox($font_size, $angle, $font, $nums);

      // Get your Text Width and Height
      $text_width  = $text_box[2] - $text_box[0];
      $text_height = $text_box[7] - $text_box[1];

      // Calculate coordinates of the text
      $x = ($image_width/2)  - ($text_width/2);
      $y = ($image_height/2) - ($text_height/2);

      // Add text to image
      imagettftext($image, $font_size, $angle, $x, $y, $numbers_color, $font, $nums);

      imagepng($image);
      imagedestroy($image);

    } else {
      echo 'no';
    }
  }



  public function register() {
    $email = null;
    $data['msg_error'] = array();

    if(post_isset('btn-submit')) {
      if(post('captcha') == session_get('captcha')) {
        $email = post('email');

      } else {
        $data['msg_error'] = true;
        View::render("account/register.php", $data);
      }
    }

    setPageTitle("Register an account");

    // show registeration form if not provided
    if ($email == null) {
      View::render("account/register.php", array());
      return;

    }


    // check registeration info and register if is valid information
    $email     = post('email');
    $name      = post('name');
    $nickname  = post('nickname');

    $password1 = post('password1');
    $password2 = post('password2');

    $time = getCurrentDateTime();

    $record = AccountModel::fetch_by_email($email);

    if ($record != null){
      message('fail', _already_registered, true);
    }

    if (strlen($password1) < 3 || strlen($password2) < 3){
      message('fail', _weak_password, true);
    }

    if ($password1 != $password2){
      message('fail', _password_not_matach, true);
    }

    $hashedPassword = encryptPassword($password1);

    AccountModel::insert($email, $name, $nickname, $hashedPassword, $time, $time);

    message('success', _successfully_registered, true);
  }



  //
  private function loginCheck() {}
  private function loginForm() {}
  private function registerCheck() {}
  private function registerForm() {}

}
?>