<?
class WebserviceController {


  public function test() {
    $json = array(
      'message' => 'success',
      'code'    => '100',
    );

    echo json_encode($json);
  }


  public function list_of_products($sortTypeIndex) {
    $db = Db::getInstance();

    $keyword = post('keyword');
    if ($keyword == null) {
      $searchPhrase = '1=1';
    } else {
      $searchPhrase = 'title LIKE "%' . $keyword . '%"';
    }

    switch ($sortTypeIndex) {
      case 1: $sortType = "price"; break;
      case 2: $sortType = "discount"; break;
      case 3: $sortType = "creationTime"; break;
      default: $sortType = "price"; break;
    }

    $result = $db->query("SELECT * FROM pym_product WHERE $searchPhrase ORDER BY $sortType DESC");
    echo json_encode($result);
  }
}

?>