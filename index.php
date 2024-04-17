<?php

// Import Reader
require 'vendor/autoload.php';
use GeoIp2\Database\Reader;
// Init Reader
$cityDbReader = new Reader('./GeoLite2-City.mmdb');

// Ensure IP
$ip = (!empty($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']));

// Read IP
$record = $cityDbReader->city($ip);

// File and new size
$area = "In the " . (!empty($record->city->name) ? $record->city->name : "Unknown") . " area";
$string = "Local girls looking for love";
$filename = 'image.jpg';
$percent = 0.4;

// Content type
header('Content-Type: image/jpeg');

// Get new sizes
list($width, $height) = getimagesize($filename);
$newwidth = $width * $percent;
$newheight = $height * $percent;

// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);
$source = imagecreatefromjpeg($filename);

// Resize
imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// Text Color
$black = imagecolorallocate($thumb, 0, 0, 0);

// Add Top Text
$top_px = (imagesx($thumb) - 9 * strlen($string)) / 2;
imagestring($thumb, 5, $top_px, 9, $string, $black);

// Add Bottom Text
$bottom_px = (imagesx($thumb) - 9 * strlen($area)) / 2;
imagestring($thumb, 5, $bottom_px, 254, $area, $black);

// Output
imagejpeg($thumb);
imagedestroy($thumb);

?>
