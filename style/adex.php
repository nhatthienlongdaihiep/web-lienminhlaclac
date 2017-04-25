<?php 
$imagesDir = 'img/splash/';
$images = glob($imagesDir . '*.{jpg}', GLOB_BRACE);
$randomImage = $images[array_rand($images)]; // See comments
echo $randomImage;
?>