<?php
/* *
 * megamul.php
 * a MUL file reader and renderer
 *
 * By AnDenix, Summer 2013
 *   Based on MUL viewing code by Timour (hotride)
 *
 * This content is released under the http://opensource.org/licenses/MIT 
 * MIT License.
 */    
   
include("libs/inc.mulutils.php");   

// path to your UO mul files with trailing slash
//define ( "ULTIMA_DIR", "c:\games\uo\" ); // windows example
//define ( "ULTIMA_DIR", "/mnt/hgfs/muls/" ); // linux vmware vm example
define ( "ULTIMA_DIR", "uofiles/" ); // linux vm example
#define ( "ULTIMA_DIR", "../uo_zuluhotel/" ); // linux vm example
    

if(isset($_REQUEST["static"])) {
    $tile_idx =  intval($_REQUEST["static"]) + 0x4000;
}
elseif(isset($_REQUEST["tile"])) {
    $tile_idx =  intval($_REQUEST["tile"]);
}
elseif(isset($_REQUEST["mobile"])) {
    $mobile_idx = trim($_REQUEST["mobile"]);
    if(ctype_digit($mobile_idx)) {
        $mobile_idx = intval($mobile_idx);
    }
    else if(ctype_xdigit(ltrim($mobile_idx, "0x"))){
        $mobile_idx = hexdec(ltrim($mobile_idx, "0x"));
    }
} else {
    die("No art or mobile index supplied.");
}

$scale = 0;

if(isset($_REQUEST["scale"])) {
    $scale = doubleval($_REQUEST["scale"]);
    if( $scale < 0.5 ) {
        $scale = 0.5;
    } elseif ($scale > 4.0) {
        $scale = 4.0;    
    }    
}
    
$hue = 0;

if(isset($_REQUEST["hue"])) {
    $hue = intval($_REQUEST["hue"]);
    $hue = $hue & ~0xF000;
}

$transparent = 0;

if(isset($_REQUEST["transparent"])) {
    $transparent = intval($_REQUEST["transparent"]);
}

if($hue)
    $hues = GetHues();
else
    $hues = 0;

if(isset($mobile_idx))
    $my_img = RenderAnimMulImage($mobile_idx, $hue);
else
    $my_img = RenderArtMulImage( $tile_idx, $hue);

header( "Content-type: image/png" );

if( $scale ) {                
	
	if(isset($_REQUEST["center"])) {
    	$center = intval($_REQUEST["center"]);
	} else 
		$center = 0;
	
    if(isset($_REQUEST["setheight"])) {
    	$setheight = intval($_REQUEST["setheight"]);
    	$my_img = ResizeImage($my_img, $scale, $center, $setheight);    	
    } else {
    	$my_img = ResizeImage($my_img, $scale, $center);
    }    
}

if($transparent) {
	$colors_transparent = array( imagecolorat( $my_img, 0, 0 ), 
		imagecolorat( $my_img, imagesx($my_img)-1, 0 ),
		imagecolorat( $my_img, 0, imagesy($my_img)-1 ), imagecolorat( $my_img, imagesx($my_img)-1, imagesy($my_img)-1 ) );
	$color_transparent = array_unique(array_diff_key( $colors_transparent , array_unique($colors_transparent ) ) );
    $color_transparent = array_pop($color_transparent);
    imagecolortransparent( $my_img, $color_transparent[0]);
}

imagepng( $my_img );
imagedestroy( $my_img );