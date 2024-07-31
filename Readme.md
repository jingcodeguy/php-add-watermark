![X (formerly Twitter) Follow](https://img.shields.io/twitter/follow/jingcodeguy) ![Website](https://img.shields.io/website?url=https%3A%2F%2Fjingcodeguy.com&label=JingCodeGuy%20Website)

# Image Watermarking Tools

This tool is designed to watermark any single image with a logo image. A watermark is essential for:
- Adding copyright information, although some modern AI tools can remove logos from videos or images.
- Building brand recognition for marketing purposes.
- Protecting images from unauthorized linking or bandwidth theft.

The idea for this project originated in May 2023, when I noticed that photos from some local real estate companies had automatic watermarks. This inspired me to try using the same method on my own products. Since I am familiar with WordPress and PHP development and know about the Imagick tool, I chose PHP as the development medium. The outcome successfully achieved the intended purpose.

## Functionality Details:
It adds any single image with opacity in PNG format, creates a pattern with a preset angle, and overlays it on any given image, outputting the final result in JPEG format.

## Technical Requirements:
Tested and developed with:
- macOS 14.5 M1
- PHP 8.39 (Should work with PHP 7.x)
- Imagick 3.7.0

## Use Cases:
This simple and functional tool offers many possibilities.
It can be further developed for various integrations, including but not limited to WordPress plugins and standalone tools.

## Installation: 
Download from this repository using this in the command line
```
git clone https://github.com/jingcodeguy/php-add-watermark.git
cd php-add-watermark
```

Usage example in Command Line
default settings: 
- The logo, `logo-sample.png`, is applied with 0.5 (half) opacity, where the logo is in black color.
- The output image will be saved in the folder where the PHP script is run.

```
php add_watermark.php image-to-watermark.jpg
# Default output name is output-xxxxxxxx.jpg where xxxxxxxx is the original filename  
```

You may refer to the examples in the "Sample" folder for images.

---

# 圖片加水印工具

這個工具旨在將任何單張圖片加上Logo水印。水印對於以下方面是必不可少的：

- 添加版權信息，儘管現代某些AI工具可以從視頻或圖片中移除Logo。
- 建立品牌識別，助力市場推廣。
- 保護圖片免受未經授權的鏈接或盜用帶寬。

這個項目的意念源於2023年5月時，在瀏覽一些本地地產公司時，見到相片會有自動的水印，所以生意了一個想要嘗試用相同的方法在自己的產品上。因為熟悉 WordPress 和 PHP 開發還有知道 Imagick 這個工具，所以選用了 PHP 作為開發媒介。效果上是有做到了想要達到的目的。

## 功能細節： 
該工具會將任何單張PNG格式的圖片添加透明度，並以預設的角度創建一個圖案，再將其添加到任何給定的圖片上，最後輸出JPEG格式的圖片。

## 技術要求：
測試和開發環境：
- macOS 14.5 M1
- PHP 8.39（應該也適用於PHP 7.x版本）
- Imagick 3.7.0

## 安裝：
使用以下命令在命令行中從這個存儲庫下載
預設設定：
- 將 `logo-sample.png` 的不透明度設為0.5（即一半），且Logo為黑色。
- 輸出圖片將保存在執行PHP腳本的資料夾中。

```
git clone https://github.com/jingcodeguy/php-add-watermark.git
cd php-add-watermark
```

## 使用場景：
這個簡單且實用的工具有許多潛在的用途。  
它可以進一步開發用於任何整合，包括但不限於WordPress插件、獨立工具等。

在命令元/終端機的範例使用方法：
```
php add_watermark.php image-to-watermark.jpg
# 預設輸出名稱為 output-xxxxxxxx.jpg，其中 xxxxxxxx 是原始文件名。
```

可參考 Sample 資料夾裡的圖像例子。