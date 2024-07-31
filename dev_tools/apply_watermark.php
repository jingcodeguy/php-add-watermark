<?php
/**
 * Quick preview test for watermark development.
 * It is a GD based simple api.
 */

// apply_watermark.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $opacity = intval($_POST['opacity']);
    $positionX = intval($_POST['positionX']);
    $positionY = intval($_POST['positionY']);

    $originalImagePath = './jingcodeguy.jpg';
    $watermarkImagePath = './logo-sample.png';

    // Load images
    $baseImage = imagecreatefromjpeg($originalImagePath);
    $watermark = imagecreatefrompng($watermarkImagePath);

    // Set watermark opacity
    imagealphablending($watermark, true);
    imagesavealpha($watermark, true);

    // Get dimensions
    $baseWidth = imagesx($baseImage);
    $baseHeight = imagesy($baseImage);
    $watermarkWidth = imagesx($watermark);
    $watermarkHeight = imagesy($watermark);

    // Resize watermark if necessary
    // $watermark = imagescale($watermark, new_width, new_height); // Uncomment if resizing is needed

    // Apply watermark
    imagecopy($baseImage, $watermark, $positionX, $positionY, 0, 0, $watermarkWidth, $watermarkHeight);

    // Output image
    ob_start();
    imagepng($baseImage);
    $imageData = ob_get_contents();
    ob_end_clean();

    // Cleanup
    imagedestroy($baseImage);
    imagedestroy($watermark);

    // Send the image data as base64
    echo base64_encode($imageData);
}
?>
