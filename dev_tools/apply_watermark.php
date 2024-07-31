<?php
/**
 * Quick preview test for watermark development.
 * It is a GD based simple api.
 */

// apply_watermark.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    function sing_add_watermark($filename) {
        $opacity = $_POST['opacity'];
        $angle = intval($_POST['angle']);
        
        $original_filename = pathinfo($filename, PATHINFO_FILENAME);
        $watermark = 'logo-sample.png';
        
        // Load the original image
        $image = new Imagick(realpath($filename));
        $image->setImageFormat("png");
        $image_width = $image->getimagewidth();
      
        // Load the watermark image
        $texture = new Imagick();
        $texture->setBackgroundColor(new ImagickPixel('none')); // Keyword: "transparent" also work
        $texture->readImage(realpath($watermark));

        // ref: https://www.php.net/manual/en/imagick.constants.php#imagick.constants.channel-alpha
        $texture->evaluateImage(Imagick::EVALUATE_MULTIPLY, $opacity, Imagick::CHANNEL_ALPHA);
      
        // Create a larger canvas to accommodate the rotated watermark pattern
        // Always maintain this ratio of the watermark to the content image.
        $ideal_watermark_width = 1 / 5 * $image_width;

        // Scaling the watermark to maintain its visual appeal.
        $watermark_width = $texture->getimagewidth();
        $watermark_height = $texture->getimageheight();
        $scale_factor = $ideal_watermark_width / $texture->getImageWidth();
        $texture->scaleimage(intval($watermark_width * $scale_factor), intval($watermark_height * $scale_factor));

        $diagonal = ceil(sqrt(pow($image->getImageWidth(), 2) + pow($image->getImageHeight(), 2)));
        $canvas = new Imagick();
        $canvas->newImage($diagonal, $diagonal, 'none');
        $canvas->setImageFormat("png");
        $canvas->setImageAlphaChannel(Imagick::ALPHACHANNEL_SET);
      
        // Fill the canvas with the watermark texture
        for ($x = 0; $x < $diagonal; $x += $texture->getImageWidth()) {
            for ($y = 0; $y < $diagonal; $y += $texture->getImageHeight()) {
                $canvas->compositeImage($texture, Imagick::COMPOSITE_OVER, $x, $y);
            }
        }
      
        // Rotate the entire canvas
        $canvas->rotateImage(new ImagickPixel('none'), $angle); // Ensure background remains transparent
      
        // Calculate offset to center the watermark pattern on the original image
        $offsetX = ($image->getImageWidth() - $canvas->getImageWidth()) / 2;
        $offsetY = ($image->getImageHeight() - $canvas->getImageHeight()) / 2;
      
        // Composite the watermark onto the original image
        $image->compositeImage($canvas, Imagick::COMPOSITE_OVER, intval($offsetX), intval($offsetY));
      
        // Save the resulting image
        $output_path = 'output-' . $original_filename . '.jpg';
        // $image->writeImage($output_path);
      
        // Clean up
        // $texture->destroy();
        // $canvas->destroy();
        // $image->clear();
        // $image->destroy();
      
        return $image;
    }

    $filename = './jingcodeguy.jpg';
    $imageData = sing_add_watermark($filename);

    // var_dump(($imageData));
    // var_dump(base64_encode($imageData));
    
    // Send the image data as base64
    echo base64_encode($imageData);
    $imageData->clear();
    $imageData->destroy();
}
?>
