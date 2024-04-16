<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
// Import Reader
require 'vendor/autoload.php';
use GeoIp2\Database\Reader;
// Init Reader
$cityDbReader = new Reader('./GeoLite2-City.mmdb');

// Read IP
$record = $cityDbReader->city($_SERVER['REMOTE_ADDR']);

// File and new size
$location = "In the " . $record->city->name . " area";
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
$bottom_px = (imagesx($thumb) - 9 * strlen($location)) / 2;
imagestring($thumb, 5, $bottom_px, 254, $location, $black);

// Output
imagejpeg($thumb);
imagedestroy($thumb);

?>
