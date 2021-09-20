<?
class TempController {

 public function populateData() {

   $j = 0;
    for ($i=0; $i<50; $i++) {
      $productName = "#" . $i;
      ProductModel::add_product("Product ID " . $productName, "Description for " . $productName, "Brief for " . $productName, 100 * $i, 0, 0);
      $j++;
    }

    message('success', "add Product is Number " . $j , true);
  }


  public function generateSampleJson() {
    $json = array(
      "Computer Config 1" => array(
        "CPU" => "Intel 4790k",
        "RAM" => "KingStone HyperX 16GB",
      ),

      "Computer Config 2" => array(
        "CPU" => "AMD 965",
        "RAM" => "Patriot 32GB",
      ),

    );

    $jsonEncoded = json_encode($json);
    echo $jsonEncoded;
  }
}


?>