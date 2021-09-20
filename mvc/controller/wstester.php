<?
class WstesterController {


  public function test() {
    message('success', 'Hello', true);
  }



  public function test1($sortTypeIndex = 1, $keyword = '') {
    $postData    = array(
      'keyword' => $keyword,
    );

    $url  = "http://bettydoll.local/webservice/list_of_products/" . $sortTypeIndex;
    $data = curl_request($url, $postData);

    $products = json_decode($data, true);

    echo "<table style='border: 1px solid red'>";
      foreach ($products as $product) {
        echo "<tr style='border: 1px solid red'>";
        echo "<td style='border: 1px solid red'>" . $product['product_id'] . "</td>";
        echo "<td style='border: 1px solid red'>" . $product['title']      . "</td>";
        echo "<td style='border: 1px solid red'>" . $product['brief']      . "</td>";
        echo "<td style='border: 1px solid red'>" . $product['price']      . "</td>";
        echo "<td style='border: 1px solid red'>" . $product['discount']   . "</td>";
        echo "</tr>";
      }
    echo "</table>";

  }

}

?>