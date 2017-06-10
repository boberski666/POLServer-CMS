<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

if (!isset($_GET['name'])) {
    echo "Name not set!";
    die();
}
$n = $_GET['name'];
unset($_GET['name']);
$mulpath = "uofiles/";

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$result = mysqli_query($db, "SELECT char_id,char_name,char_title,char_race,char_body,char_female,char_bodyhue FROM " . TBL_CHARS . " WHERE char_name LIKE '$n'");
if (!(list($charID, $name, $title, $charRace, $charBodyType, $charfemale, $charbodyhue) = mysqli_fetch_row($result)))
    die();
mysqli_free_result($result);

// Insert body into variables
$indexA  = $charBodyType;
$femaleA = $charfemale;

if ($indexA == 400)
    $indexA = 12; // Human Male
if ($indexA == 401)
    $indexA = 13; // Human Female
if ($indexA == 605)
    $indexA = 14; // Elf Male
if ($indexA == 606)
    $indexA = 15; // Elf Female
if ($indexA == 667)
    $indexA = 665; // Garg Female
// Garg Male is ok (666)

$hueA    = $charbodyhue;
$isgumpA = "1";

$result = mysqli_query($db, "SELECT item_id,item_hue,layer_id FROM " . TBL_CHARS_LAYERS . " WHERE char_id=$charID");
$items  = array(
    array()
);
$num    = 0;
$dosort = 0;
while ($row = mysqli_fetch_row($result)) {
    $items[0][$num] = $row[0];
    $items[1][$num] = $row[1];
    if ($row[2] == 13) {
        $items[2][$num++] = 3.5; // Fix for tunic
        $dosort           = 1;
    } else if ($row[2] == 99) {
        $items[2][$num++] = 0.5; // Fix for hair and beard
        $dosort           = 1;
    } else
        $items[2][$num++] = $row[2];
}

mysqli_free_result($result);
mysqli_close($db);

if ($dosort)
    array_multisort($items[2], SORT_ASC, SORT_NUMERIC, $items[0], SORT_ASC, SORT_NUMERIC, $items[1], SORT_ASC, SORT_NUMERIC);

for ($i = 0; $i < $num; $i++) {
    $indexA .= "," . $items[0][$i];
    $hueA .= "," . $items[1][$i];
    if ($charfemale)
        $femaleA .= ",1";
    else
        $femaleA .= ",0";
    $isgumpA .= ",0";
}

// Paperdoll Graphic Area
$width  = 320;
$height = 505;

if (strpos($indexA, ",")) {
    $indexA  = explode(",", $indexA);
    $femaleA = explode(",", $femaleA);
    $hueA    = explode(",", $hueA);
    $isgumpA = explode(",", $isgumpA);
} else {
    $indexA  = array(
        $indexA
    );
    $femaleA = array(
        $femaleA
    );
    $hueA    = array(
        $hueA
    );
    $isgumpA = array(
        $isgumpA
    );
}

$hues      = false;
$tiledata  = false;
$gumpfile  = false;
$gumpindex = false;

$hues = fopen("{$mulpath}hues.mul", "rb");
if ($hues == false) {
    die("Unable to open hues.mul - ERROR\nDATAEND!");
}

$tiledata = fopen("{$mulpath}tiledata.mul", "rb");
if ($tiledata == false) {
    fclose($hues);
    die("Unable to open tiledata.mul - ERROR\nDATAEND!");
}

$gumpfile = fopen("{$mulpath}gumpart.mul", "rb");
if ($gumpfile == false) {
    fclose($hues);
    fclose($tiledata);
    die("Unable to open gumpart.mul - ERROR\nDATAEND!");
}

$gumpindex = fopen("{$mulpath}gumpidx.mul", "rb");
if ($gumpindex == false) {
    fclose($hues);
    fclose($tiledata);
    fclose($gumpfile);
    die("Unable to open gumpidx.mul - ERROR\nDATAEND!");
}

InitializeGump($gumprawdata, $width, $height);
for ($i = 0; $i < sizeof($indexA); $i++) {
    $index  = intval($indexA[$i]);
    $female = intval($femaleA[$i]);
    $hue    = intval($hueA[$i]);
    $isgump = intval($isgumpA[$i]);
    
    if ($female >= 1)
        $female = 1;
    else
        $female = 0;
    
    if ($hue < 1 || $hue > 65535)
        $hue = 0;
    
    if ($isgump > 0 || $index == 12 || $index == 13)
        $isgump = 1;
    else
        $isgump = 0;
    
    if ($index > 0x7FFF || $index <= 0 || $hue > 65535 || $hue < 0) // 0x3FFF
        continue;
    
    if ($isgump == 1) // Male/Female Gumps or IsGump Param
        $gumpid = $index;
    else {
        $group    = intval($index / 32);
        $groupidx = $index % 32;
        fseek($tiledata, 512 * 836 + 1188 * $group + 4 + $groupidx * 37, SEEK_SET);
        if (feof($tiledata))
            continue;
        
        // Read the flags
        $flags = read_big_to_little_endian($tiledata, 4);
        if ($flags == -1)
            continue;
        
        if ($flags & 0x404002) { //0x00400000
            fseek($tiledata, 6, SEEK_CUR);
            $gumpid = read_big_to_little_endian($tiledata, 2);
            $gumpid = ($gumpid & 0xFFFF);
            if ($gumpid > 65535 || $gumpid <= 0)
                continue; // Invalid gump ID
            
            if ($gumpid < 10000) {
                if ($female == 1)
                    $gumpid += 60000;
                else
                    $gumpid += 50000;
            }
        }
    }
    LoadRawGump($gumpindex, $gumpfile, intval($gumpid), $hue, $hues, $gumprawdata);
}

AddText($gumprawdata, $name, $title, $charRace);
CreateGump($gumprawdata);
fclose($hues);
fclose($tiledata);
fclose($gumpfile);
fclose($gumpindex);
exit;

function LoadRawGump($gumpindex, $gumpfile, $index, $hue, $hues, &$gumprawdata)
{
    $send_data = '';
    $color32   = array();
    
    fseek($gumpindex, $index * 12, SEEK_SET);
    if (feof($gumpindex))
        return; // Invalid gumpid, reached end of gumpindex.
    
    $lookup = read_big_to_little_endian($gumpindex, 4);
    if ($lookup == -1) {
        if ($index >= 60000)
            $index -= 10000;
        fseek($gumpindex, $index * 12, SEEK_SET);
        if (feof($gumpindex)) // Invalid gumpid, reached end of gumpindex.
            return;
        $lookup = read_big_to_little_endian($gumpindex, 4);
        if ($lookup == -1)
            return; // Gumpindex returned invalid lookup.
    }
    $gsize  = read_big_to_little_endian($gumpindex, 4);
    $gextra = read_big_to_little_endian($gumpindex, 4);
    fseek($gumpindex, $index * 12, SEEK_SET);
    $gwidth  = (($gextra >> 16) & 0xFFFF);
    $gheight = ($gextra & 0xFFFF);
    $send_data .= sprintf("Lookup: %d\n", $lookup);
    $send_data .= sprintf("Size: %d\n", $gsize);
    $send_data .= sprintf("Height: %d\n", $gheight);
    $send_data .= sprintf("Width: %d\n", $gwidth);
    
    if ($gheight <= 0 || $gwidth <= 0)
        return; // Gump width or height was less than 0.
    
    fseek($gumpfile, $lookup, SEEK_SET);
    $heightTable = read_big_to_little_endian($gumpfile, ($gheight * 4));
    if (feof($gumpfile))
        return; // Invalid gumpid, reached end of gumpfile.
    
    $send_data .= sprintf("DATASTART:\n");
    if ($hue <= 0) {
        for ($y = 1; $y < $gheight; $y++) {
            fseek($gumpfile, $heightTable[$y] * 4 + $lookup, SEEK_SET);
            
            // Start of row
            $x = 0;
            while ($x < $gwidth) {
                $rle    = read_big_to_little_endian($gumpfile, 4); // Read the RLE data
                $length = ($rle >> 16) & 0xFFFF; // First two bytes - how many pixels does this color cover
                $color  = $rle & 0xFFFF; // Second two bytes - what color do we apply
                
                // Begin RGB value decoding
                $r = (($color >> 10) * 8);
                $g = (($color >> 5) & 0x1F) * 8;
                $b = ($color & 0x1F) * 8;
                if ($r > 0 || $g > 0 || $b > 0)
                    $send_data .= sprintf("%d:%d:%d:%d:%d:%d***", $x, $y, $r, $g, $b, $length);
                $x = $x + $length;
            }
        }
    } else { // We are using the hues.mul
        $hue     = $hue - 1;
        $orighue = $hue;
        if ($hue > 0x8000)
            $hue = $hue - 0x8000;
        if ($hue > 3001) // Bad hue will cause a crash
            $hue = 1;
        $colors = intval($hue / 8) * 4;
        $colors = 4 + $hue * 88 + $colors;
        fseek($hues, $colors, SEEK_SET);
        for ($i = 0; $i < 32; $i++) {
            $color32[$i] = read_big_to_little_endian($hues, 2);
            $color32[$i] |= 0x8000;
        }
        for ($y = 1; $y < $gheight; $y++) {
            fseek($gumpfile, $heightTable[$y] * 4 + $lookup, SEEK_SET);
            
            // Start of row
            $x = 0;
            while ($x < $gwidth) {
                $rle    = read_big_to_little_endian($gumpfile, 4); // Read the RLE data
                $length = ($rle >> 16) & 0xFFFF; // First two bytes - how many pixels does this color cover
                $color  = $rle & 0xFFFF; // Second two bytes - what color do we apply
                
                // Begin RGB value decoding
                $r = (($color >> 10));
                $g = (($color >> 5) & 0x1F);
                $b = ($color & 0x1F);
                
                // Check if we're applying a special hue (skin hues), if so, apply only to grays
                if (($orighue > 0x8000) && ($r == $g && $r == $b)) {
                    $newr = (($color32[$r] >> 10)) * 8;
                    $newg = (($color32[$r] >> 5) & 0x1F) * 8;
                    $newb = ($color32[$r] & 0x1F) * 8;
                } else if ($orighue > 0x8000) {
                    $newr = $r * 8;
                    $newg = $g * 8;
                    $newb = $b * 8;
                } else {
                    $newr = (($color32[$r] >> 10)) * 8;
                    $newg = (($color32[$r] >> 5) & 0x1F) * 8;
                    $newb = ($color32[$r] & 0x1F) * 8;
                }
                if ((($r * 8) > 0) || (($g * 8) > 0) || (($b * 8) > 0))
                    $send_data .= sprintf("%d:%d:%d:%d:%d:%d***", $x, $y, $newr, $newg, $newb, $length);
                $x += $length;
            }
        }
    }
    $send_data .= sprintf("DATAEND!");
    add_gump($send_data, $gumprawdata);
}

function read_big_to_little_endian($file, $length)
{
    if (($val = fread($file, $length)) == false)
        return -1;
    
    switch ($length) {
        case 4:
            $val = unpack('l', $val);
            break;
        case 2:
            $val = unpack('s', $val);
            break;
        case 1:
            $val = unpack('c', $val);
            break;
        default:
            $val = unpack('l*', $val);
            return $val;
    }
    return ($val[1]);
}

function add_gump($read, &$img)
{
    if (strpos($read, "ERROR"))
        return;
    
    $data    = explode("DATASTART:\n", $read);
    $data    = $data[1];
    $newdata = explode("***", $data);
    while (list($key, $val) = @each($newdata)) {
        if ($val == "DATAEND!")
            break;
        $val    = explode(":", $val);
        $x      = intval($val[0]) + 70;
        $y      = intval($val[1]) + 65;
        $r      = intval($val[2]);
        $g      = intval($val[3]);
        $b      = intval($val[4]);
        $length = intval($val[5]); // pixel color repeat length
        if ($r || $g || $b) {
            $col = imagecolorallocate($img, $r, $g, $b);
            for ($i = 0; $i < $length; $i++)
                imagesetpixel($img, $x + $i, $y, $col);
        }
    }
}

function InitializeGump(&$img, $width, $height)
{
    $img = ImageCreateFrompng("images/paperdoll.png") or die("couldnt create image");
    imagealphablending($img, TRUE);
    imagecolortransparent($img, imagecolorallocate($img, 0, 0, 0));
}

function AddText(&$img, $name, $title, $race)
{
    $textcolor = imagecolorallocate($img, 255, 255, 255);
    $pos       = (int) (131 - (strlen($name) * 3.5));
    if ($pos < 0)
        $pos = 0;
    imagestring($img, 3, $pos, 400, $name . " (" . $race . ")", $textcolor); // 35, 266
    $pos = (int) (131 - (strlen($title) * 3.5));
    if ($pos < 0)
        $pos = 0;
    imagestring($img, 3, $pos, 420, $title, $textcolor); // 35, 283
}

function CreateGump(&$img)
{
    Header("Content-type: image/png");
    imagepng($img);
    imagedestroy($img);
}

function striphtmlchars($str)
{
    $nstr = str_replace("&amp;", "&", $str);
    $nstr = str_replace("&#39;", "'", $nstr);
    return $nstr;
}