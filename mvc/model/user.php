<?
class UserModel {

  public static function fetch_wish($userId, $resourceType, $resourceId) {
    $db = Db::getInstance();
    $wish = $db->query("
      SELECT  *
      FROM    user_wish

      WHERE   user_id = :user_id
          AND resource_id = :resource_id
          AND resourceType = :resourceType
    ", array(
      'user_id'      => $userId,
      'resource_id'  => $resourceId,
      'resourceType' => $resourceType,
    ));

    return $wish;
  }


  public static function insert_wish($userId, $resourceType, $resourceId) {
    $db = Db::getInstance();
    $lastId = $db->insert("
      INSERT INTO user_wish
      (
        user_id,
        resource_id,
        resourceType
      )
      VALUES
      (
        :user_id,
        :resource_id,
        :resourceType
      )
    ", array(
      'user_id'      => $userId,
      'resource_id'  => $resourceId,
      'resourceType' => $resourceType,
    ));

    return $lastId;
  }


  public static function remove_wish($userId, $resourceType, $resourceId) {
    $db = Db::getInstance();
    $db->modify("
      DELETE
      FROM    user_wish

      WHERE   user_id = :user_id
          AND resource_id = :resource_id
          AND resourceType = :resourceType
    ", array(
      'user_id'      => $userId,
      'resource_id'  => $resourceId,
      'resourceType' => $resourceType,
    ));
  }
}
?>