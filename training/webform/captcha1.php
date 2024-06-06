<?php
   session_start();
   $width = 100;
   $height = 38;
   $length = 5;
   $font = './arial.ttf';
   $font_size = 12;
   $bg_color = array(240, 240, 240);
   $chars = 'ABCDEFGHKMNPQRSTUVWXYZ23456789';
   if (extension_loaded('gd') == false)
   {
      die("The GD extension is required for CAPTCHA!");
   }
   if (function_exists('imagettftext') == false)
   {
      die("The function 'imagettftext' is required for CAPTCHA!");
   }
   $img = imagecreatetruecolor($width, $height);
   $bkgr = imagecolorallocate($img, $bg_color[0], $bg_color[1], $bg_color[2]);
   imagefilledrectangle($img, 0, 0, $width, $height, $bkgr);

   $code = '';
   for ($i = 0; $i < $length; $i++)
   {
      $code .= $chr = $chars[mt_rand(0, strlen($chars)-1)];
      $r = rand(0, 192);
      $g = rand(0, 192);
      $b = rand(0, 192);
      $color = imagecolorallocate($img, $r, $g, $b);
      $angle = rand(-35, 35);
      $x = 5+$i*(4/3*$font_size+2);
      $y = rand(4/3*$font_size, $height-(4/3*$font_size)/2);
      imagettftext($img, $font_size, $angle, $x, $y, $color, $font, $chr);
   }

   $_SESSION['captcha'] = md5($code);

   header("Content-type: image/png");
   header("Expires: Tue, 28 Mar 2000 12:00:00 GMT");
   header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
   header("Cache-Control: no-store, no-cache, must-revalidate");
   header("Cache-Control: post-check=0, pre-check=0", false);
   header("Pragma: no-cache");

   imagepng($img);
   imagedestroy($img);
?>