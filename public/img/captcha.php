<?php
// require 'lib/utilities.php';

// must start or continue session and save CAPTCHA string in $_SESSION for it
// to be available to other requests

if (!isset($_SESSION)) {
    session_start();
    header('Cache-control: private');
}

// create a 65x20 pixel image
$width = 65;
$height = 20;
$image = imagecreatetruecolor(65, 20);

// fill the image background color
$bg_color = imagecolorallocate($image, 0x33, 0x66, 0xFF);
imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

// fetch random text
// for some reason if I require 'lib/utilities' and
// call the random_text() function, browser gets confused
// and captcha image isn't displayed - browser thinks it's html
// instead of png file.
// $text = random_text(5);
$chars = array_flip(array_merge(range(0, 9), range('A', 'Z')));

unset($chars[0], $chars[1], $chars[2], $chars[5], $chars[8],
$chars['B'], $chars['I'], $chars['O'], $chars['Q'],
$chars['S'], $chars['U'], $chars['V'], $chars['Z']);

// generate the string of random text
for ($i = 0, $text = ''; $i < 5; $i++) {
  $text .= array_rand($chars);
}

// determine x and y coordinates for centering text
$font = 5;
$x = imagesx($image) / 2 - strlen($text) * imagefontwidth($font) / 2;
$y = imagesy($image) / 2 - imagefontheight($font) / 2;

// write text on image
$fg_color = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
imagestring($image, $font, $x, $y, $text, $fg_color);


// save the CAPTCHA string for later comparison
$_SESSION['captcha'] = $text;


// don't do this.. apparently confuses browser and browser doesn't
// display image properly
// trigger_error("Sending CAPTCHA image\n", E_USER_NOTICE);

// output the image
header('Content-type: image/png');

if ( ! imagepng($image)) {
  // trigger_error("Couldn't send CAPTCHA image\n", E_USER_WARNING);
}

imagedestroy($image);

