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
if (isset($argv[1])) {
  if (file_exists($argv[1])) {
      print_r($argv);
      $filename = $argv[1];
      try {
          $image = sing_add_watermark($filename);
          // Additional code to handle the watermarked image
      } catch (Exception $e) {
          echo "Error: " . $e->getMessage() . "\r\n";
      }
  } else {
      echo "Error: The file does not exist.\r\n";
  }
} else {
  echo "Usage example: XXX.php filename.jpg\r\n";
  exit();
}

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
  $canvas->rotateImage(new ImagickPixel('none'), -45); // Ensure background remains transparent

  // Calculate offset to center the watermark pattern on the original image
  $offsetX = ($image->getImageWidth() - $canvas->getImageWidth()) / 2;
  $offsetY = ($image->getImageHeight() - $canvas->getImageHeight()) / 2;

  // Composite the watermark onto the original image
  $image->compositeImage($canvas, Imagick::COMPOSITE_OVER, $offsetX, $offsetY);

  // Save the resulting image
  $output_path = 'output-' . $original_filename . '.jpg';
  $image->writeImage($output_path);

  // Clean up
  $texture->destroy();
  $canvas->destroy();

  // If destroy here, the image will be emptied and nothing will return.
  $image->clear();
  $image->destroy();

//   return $image;
}

// Possible way to display the image in a web interface
// if (!isset($argv[1])) {
//     header("Content-Type: image/png");
//     echo $image;
// }