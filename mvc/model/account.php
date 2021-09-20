<?
class AccountModel {



  public static function insert($email, $name, $nickname, $hashedPassword, $registerTime, $lastVisitTime) {
    $db = Db::getInstance();
    $db->insert("INSERT INTO x_user (email,   fullname,  nickname,  password,  registerTime,  lastVisitTime) VALUES
                                    (:email, :fullname, :nickname, :password, :registerTime, :lastVisitTime)", array(
      'email'         => $email,
      'fullname'      => $name,
      'nickname'      => $nickname,
      'password'      => $hashedPassword,
      'registerTime'  => $registerTime,
      'lastVisitTime' => $lastVisitTime,
    ));
  }



  public static function fetch_by_email($email) {
    $db = Db::getInstance();
    $record = $db->first("SELECT * FROM x_user WHERE email=:email", array(
      'email' => $email,
    ));

    return $record;
  }



  public static function promote_user($userId, $access) {
    $db = Db::getInstance();
    $record = $db->modify("UPDATE x_user SET access=:access WHERE user_id=:user_id", array(
      'user_id' => $userId,
      'access'  => $access,
    ));

    return $record;
  }



  public static function get_user_access($userId) {
    $db = Db::getInstance();
    $record = $db->first("SELECT access FROM x_user WHERE user_id=:user_id", array(
      'user_id' => $userId,
    ));

    return $record['access'];
  }

}
?>