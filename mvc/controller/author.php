<?
class AuthorController {


  public function __construct() {
    grantAuthor();
  }



  public function defineProduct() {
    $title = post('title');

    if ($title == null) {
      View::render("author/define-product.php");
      return;
    }

    $description = post('description') | 'd';
    $brief       = post('brief')       | 'b';
    $price       = post('price')       | '0';
    $discount    = post('discount')    | '0';

    if ($_FILES['image']['size'] == 0) {
      $hasCover = 0;
    } else {
      $hasCover = 1;
    }

    $productId = ProductModel::add_product($title, $description, $brief, $price, $discount, $hasCover);

    if ($hasCover) {
      $file = $_FILES['image']['tmp_name'];
      $ext  = $_FILES['image']['type'];
      $ext  = str_replace('image/', '.', $ext);
      //$filename = $_FILES['image']['name'];

      $thumbPath    = getcwd() . "/image/products/" . $productId . $ext;
      $originalPath = getcwd() . "/image/products/original/" . $productId . $ext;

      resizeImage($file, 150, 0, $thumbPath);
      copy($file, $originalPath);
    }

    message('success', _product_defined, true, array(
      'number' => $productId,
    ));
  }
}
?>