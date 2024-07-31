<?php
/**
 * 
 * @package JingCodeGuy
 * @version 1.0.0
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 * 
 * @Copyright (c) 2024 JingCodeGuy and Tala Group Limited. All Rights Reserved.
 * @author JingCodeGuy <hello@JingCodeGuy.com>
 * @link https://jingcodeguy.com
 * 
 */

/**
 * Usage example: XXX.php filename.jpg
 */
if( isset($argv[1]) ) {
    if( file_exists( $argv[1] )  ) {
      print_r($argv);
    }
  } else {
    echo "usage example: XXX.php filename.jpg\r\n";
    exit();
  }

$filename = $argv[1];

/**
 * This function applies a watermark pattern (such as a logo or copyright image) to a given image.
 * The watermark is tiled across the image at a 45-degree angle, with adjustable opacity.
 * This design is inspired by the watermarking style of a local real estate company.
 *
 * @param string $filename The path to the image file that will receive the watermark.
 * @return object image
 *
 */
function sing_add_watermark($filename) {
    $original_filename = pathinfo($filename, PATHINFO_FILENAME);
    $watermark = 'logo-sample.png';
    
    // Load the original image
    $image = new Imagick(realpath($filename));
    $image->setImageFormat("png");

    // Load the watermark image
    $texture = new Imagick(realpath($watermark));
    $texture->setImageAlpha(0.05); // Set transparency

    // Create a large canvas for the watermark pattern
    $canvas_width = $image->getImageWidth() * 2.5;
    $canvas_height = $image->getImageHeight() * 2.5;
    $canvas = new Imagick();
    $canvas->newImage($canvas_width, $canvas_height, new ImagickPixel('none'));
    $canvas->setImageFormat("png");

    // Fill the canvas with the watermark texture
    for ($x = 0; $x < $canvas_width; $x += $texture->getImageWidth()) {
        for ($y = 0; $y < $canvas_height; $y += $texture->getImageHeight()) {
            $canvas->compositeImage($texture, Imagick::COMPOSITE_OVER, $x, $y);
        }
    }

    // Rotate the entire canvas
    $canvas->rotateImage(new ImagickPixel(), -45);

    // Composite the watermark onto the original image
    $offsetX = -($canvas_width - $image->getImageWidth()) / 2;
    $offsetY = -($canvas_height - $image->getImageHeight()) / 2;
    $image->compositeImage($canvas, Imagick::COMPOSITE_OVER, $offsetX, $offsetY);

    // Save the resulting image
    $output_path = 'output-' . $original_filename . '.jpg';
    $image->writeImage($output_path);

    // Clean up
    $texture->destroy();
    $canvas->destroy();

    return $image;
}

$image = sing_add_watermark($filename);

// Display the image in a web interface
if (!isset($argv[1])) {
    header("Content-Type: image/png");
    echo $image;
}
