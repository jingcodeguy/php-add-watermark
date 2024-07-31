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
      
        // Load the watermark image
        $texture = new Imagick();
        $texture->setBackgroundColor(new ImagickPixel('none')); // Keyword: "transparent" also work
        $texture->readImage(realpath($watermark));
        $texture->evaluateImage(Imagick::EVALUATE_MULTIPLY, $opacity, Imagick::CHANNEL_ALPHA);
      
        // Create a larger canvas to accommodate the rotated watermark pattern
        $diagonal = ceil(sqrt(pow($image->getImageWidth(), 2) + pow($image->getImageHeight(), 2)));
        $canvas = new Imagick();
        $canvas->newImage($diagonal, $diagonal, new ImagickPixel('none'));
        $canvas->setImageFormat("png");
      
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
        // $output_path = 'output-' . $original_filename . '.jpg';
        // $image->writeImage($output_path);
      
        // Clean up
        // $texture->destroy();
        // $canvas->destroy();

        // If destroy here, the image will be emptied and nothing will return.
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
