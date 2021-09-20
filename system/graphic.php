<?


function getImageRatio($sourcePath) {
  list($width, $height) = getimagesize($sourcePath);
  $ratio                = $height / $width;
  return $ratio;
}



function resizeImage($sourcePath, $newWidth, $newHeight, $destination = null) {

  $parts = explode(".", $sourcePath);
  $ext   = $parts[count($parts)-1];

  if ($ext == 'jpg' || $ext == 'jpeg') {
    $format = 'jpg';
  } else {
    $format = 'png';
  }

  if ($format == 'jpg') {
    $sourceImage = imagecreatefromjpeg($sourcePath);
  } else if ($format == 'png') {
    $sourceImage = imagecreatefrompng($sourcePath);
  }

  list($srcWidth, $srcHeight) = getimagesize($sourcePath);
  $ratio = getImageRatio($sourcePath);

  if ($newHeight == 0) {
    $newHeight = $newWidth * $ratio;
  }

  if ($newWidth == 0) {
    $newWidth = $newHeight / $ratio;
  }

  $destinationImage  = imagecreatetruecolor($newWidth, $newHeight);
  imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);

  if ($destination == null) {

    if ($format == 'jpg') {
      header('Content-Type: image/jpeg');
      imagejpeg($destinationImage, null, 100);
    } else if ($format == 'png') {
      header('Content-type: image/png');
      imagepng($destinationImage);
    }

  } else {

    if ($format == 'jpg') {
      imagejpeg($destinationImage, $destination, 100);
    } else if ($format == 'png') {
      imagepng($destinationImage, $destination);
    }

  }

}

?>