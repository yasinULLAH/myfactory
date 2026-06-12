<?php
namespace App\Helpers;

class CaptchaHelper {
    public static function generate($length = 5) {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $operators = ['+', '-'];
        $operator = $operators[rand(0, 1)];
        
        if ($operator === '+') {
            $result = $num1 + $num2;
        } else {
            if ($num1 < $num2) {
                $temp = $num1;
                $num1 = $num2;
                $num2 = $temp;
            }
            $result = $num1 - $num2;
        }
        
        $_SESSION['captcha'] = (string)$result;
        return "$num1 $operator $num2 = ?";
    }

    public static function render($equation) {
        // Prevent caching
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Type: image/png');
        
        $width = 150;
        $height = 50;
        $image = imagecreatetruecolor($width, $height);
        
        $bg = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bg);
        
        // Add noise (dots)
        for ($i = 0; $i < 100; $i++) {
            $noise_color = imagecolorallocate($image, rand(150, 220), rand(150, 220), rand(150, 220));
            imagesetpixel($image, rand(0, $width), rand(0, $height), $noise_color);
        }
        
        // Add strokes (lines)
        for ($i = 0; $i < 5; $i++) {
            $line_color = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(100, 200));
            imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
        }
        
        $text_color = imagecolorallocate($image, 30, 41, 59); // Slate-800
        $font_size = 5; // GD built-in font size
        
        // Center text
        $text_width = imagefontwidth($font_size) * strlen($equation);
        $text_height = imagefontheight($font_size);
        $x = ($width - $text_width) / 2;
        $y = ($height - $text_height) / 2;
        
        imagestring($image, $font_size, $x, $y, $equation, $text_color);
        
        // Output image and clean up
        ob_clean(); // Ensure no output buffering causes broken image
        imagepng($image);
        imagedestroy($image);
        exit;
    }
}
