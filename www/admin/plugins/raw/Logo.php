<?php
header('Content-Type: image/png');
$img = Logo(POL_NAME);

imagepng($img);
imagedestroy($img);


function Logo()
{
	$args = func_get_args();
    /* Get base image, shard address, and port */
	$name = $args[0];
	/* Attempt to open */
    $im  = imagecreatetruecolor(500, 60);
	imagesavealpha( $im, true );  // Keep transparent background
    imagefill($im, 0, 0, imagecolorallocatealpha($png, 0, 0, 0, 127));
	
    /* Set text color */
    $tc  = imagecolorallocate($im, 231, 207, 74);	

    /* Set shadow color */
    $sc  = imagecolorallocate($im, 0, 0, 0);	
	
	/* Everything looks good, write in the shard_addr and shard_port */
	$font_name = '../fonts/Avatar.ttf';
	$font_server = '../fonts/Calibri.ttf'; // Choose a more readble font for the server name and port
	imagettftext($im, 45, 0, 82, 53, $sc, $font_name, $name); // Write Server Name Shadow First
	imagettftext($im, 45, 0, 80, 55, $tc, $font_name, $name); // Write Server Name

	return $im;
}