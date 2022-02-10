<?php

namespace App\Services;

use Exception;

/**
 * Display and verify a captcha verification.
 *
 * IMPORTANT: In the CI Global Calendar project we are not using Google ReCaptcha,
 * because it's not working properly in China, due to the restrictions for Google.
 *
 * @author Davide Casiraghi
 */
class CaptchaService
{

    /**
     * Prime the captcha - Generate random string and store it in session.
     *
     * @param  int  $length
     * @return void
     */
    public function prime (int $length = 4): void
    {
        $char = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $max = strlen($char) - 1;
        $random = "";
        for ($i=0; $i<=$length; $i++) {
            $random .= substr($char, rand(0, $max), 1);
        }
        session(['captcha' => $random]);
    }

    /**
     * Draw the captcha image.
     *
     * @param  int  $output
     * @param  int  $width
     * @param  int  $height
     * @param  int  $fontsize
     * @param  string  $font
     *
     * @return string
     * @throws Exception
     */
    public function draw (int $output=1, int $width=300, int $height=50, int $fontsize=24, string $font="webfonts/open_sans/OpenSans-Regular.ttf"): string
    {
        $font = public_path('webfonts/open_sans/OpenSans-Regular.ttf');

        // (B1) OOPS.
        if (!session()->has('captcha')) {
            throw new Exception("CAPTCHA NOT PRIMED");
        }

        // (B2) CREATE BLANK IMAGE
        $captcha = imagecreatetruecolor($width, $height);

        // (B3) FUNKY BACKGROUND IMAGE
        $background =  public_path('images/captcha-back.jpg');
        list($bx, $by) = getimagesize($background);
        if ($bx-$width<0) { $bx = 0; }
        else { $bx = rand(0, $bx-$width); }
        if ($by-$height<0) { $by = 0; }
        else { $by = rand(0, $by-$height); }
        $background = imagecreatefromjpeg($background);
        imagecopy($captcha, $background, 0, 0, $bx, $by, $width, $height);

        // (B4) THE TEXT SIZE
        $text_size = imagettfbbox($fontsize, 0, $font, session('captcha'));
        $text_width = max([$text_size[2], $text_size[4]]) - min([$text_size[0], $text_size[6]]);
        $text_height = max([$text_size[5], $text_size[7]]) - min([$text_size[1], $text_size[3]]);

        // (B5) CENTERING THE TEXT BLOCK
        $centerX = CEIL(($width - $text_width) / 2);
        $centerX = $centerX<0 ? 0 : $centerX;
        $centerX = CEIL(($height - $text_height) / 2);
        $centerY = $centerX<0 ? 0 : $centerX;

        // (B6) RANDOM OFFSET POSITION OF THE TEXT + COLOR
        if (rand(0,1)) { $centerX -= rand(0,55); }
        else { $centerX += rand(0,55); }
        $colornow = imagecolorallocate($captcha, rand(120,255), rand(120,255), rand(120,255)); // Random bright color
        imagettftext($captcha, $fontsize, rand(-10,10), $centerX, $centerY, $colornow, $font, session('captcha'));

        // (B7) OUTPUT AS JPEG IMAGE
        if ($output==0) {
            header("Content-type: image/png");
            imagejpeg($captcha);
            imagedestroy($captcha);
        }

        // (B8) OUTPUT AS BASE 64 ENCODED HTML IMG TAG
        ob_start();
        imagejpeg($captcha);
        $ob = base64_encode(ob_get_clean());
        return "<img src='data:image/jpeg;base64,$ob'/>";

    }

    /**
     * Verify captcha.
     *
     * @param  string  $check
     * @return bool
     * @throws Exception
     */
    function verify (string $check): bool
    {
        // (C1) CAPTCHA NOT SET!
        if (!session()->has('captcha')) {
            throw new Exception("CAPTCHA NOT PRIMED");
        }

        // (C2) CHECK
        if ($check == session('captcha')) {
            session()->forget('captcha');
            return true;
        }

        return false;
    }
}