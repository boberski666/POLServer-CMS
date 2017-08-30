<?php
    
define("MAX_TILE", 0x7FFF);

function ApplyHue15bit( $color16, $hue )
{
    global $hues;
    $g = floor(($hue-1)/8);
    $e = ($hue-1)-$g*8;
    $colorTable = $hues[$g]["entries"][$e]["colorTable"];
    $color16 = Greyscale15bit( $color16 );
    $color16 = $colorTable[$color16];  
    return $color16;
}

function bodyconv( $model_no )
{
	$bodyconv_def = file_get_contents(ULTIMA_DIR.'Bodyconv.def');
	$lines = explode("\n", $bodyconv_def);

	foreach ($lines as $line) {
		if(!$line)
			continue;
		elseif($line[0]=='#')
			continue;
		
		$data = preg_split('/\s+/', $line);
		
		if ($model_no==intval($data[0])) {
			
			$lbr_model_no = intval($data[1]);
			if($lbr_model_no!=-1)
				return array('index' => 2, 'model_no' => $lbr_model_no);
			
			$aos_model_no = intval($data[2]);												
			if($aos_model_no!=-1)
				return array('index' => 3, 'model_no' => $aos_model_no);
		}
	}
	
	return array('index' => 1, 'model_no' => $model_no);
}
        
function Greyscale15bit( $color16 )
{
    return (($color16 & 0x1F)*299+(($color16 >> 5)&0x1F)*587+(($color16 >> 10)&0x1F)*114)/1000;
}

function Convert15bitToTrueColor( $color16 )
{
    return ( ((($color16 >> 10) & 0x1F) * 0xFF / 0x1F) |
    (((($color16 >> 5) & 0x1F) * 0xFF / 0x1F) << 8) |
    ((( $color16 & 0x1F) * 0xFF / 0x1F) << 16));
}
    
function SetColors( $fp, $my_img, $x, $y, $hue=0)    
{
    global $hues;
        
    $Color16 = ReadMulColor($fp);
    
    if($hue > 0) {
        $Color16 = ApplyHue15bit( $Color16, $hue );
    }
    
    $Color32 = Convert15bitToTrueColor( $Color16 );    
    $rgb = TrueColorToRGB( $Color32 );    
    imagesetpixel( $my_img, $x , $y , imagecolorallocate($my_img, $rgb[0], $rgb[1], $rgb[2]) );                    
}

// read raw 15 bit mul color
// return DWORD color
function ReadMulColor($fp)
{
    $Color16 = fread($fp, 2);                
    $Color16 = unpack("vcolor", $Color16);  
    return $Color16["color"];
}

// convert 32 int to Red Green and Blue value
// return array of color values 0-255
function TrueColorToRGB( $color )
{
    $rgb[] = $color & 255;
    $rgb[] = ($color >> 8) & 255;
    $rgb[] = ($color >> 16) & 255;
    return $rgb;
}

// decode Run Legnth Encoded tile
function DecodeRLEPic( $img, $w, $h, $fp, $hue )
{          
    $LineOffsetsSize=5120;
    if (!$w||$w>=1024) return;     
    if (!$h||$h*2>$LineOffsetsSize) return;
  
    $LineOffsets = fread($fp, $h*2); //[5120];
    $LineOffsets = unpack("S*", $LineOffsets);
    
    $elm = array_shift($LineOffsets);                              
    array_unshift($LineOffsets, $elm);     
  
    $DataStart=ftell( $fp );
  
    $X=0;
    $Y=0;
    $Dif=0;
    $Cnt=0;
    $DCnt=0;
    $V=0;
  
    $XOffs = 0; $Run = 0;

    $LineDone = false;
  
    fseek($fp, $DataStart + $LineOffsets[$Y]);           
  
    while ($Y < $h)
    {
        $XOffs = unpack("v", fread($fp, 2));
        $XOffs = $XOffs[1];                     
        $Run = unpack("v", fread($fp, 2));
        $Run = $Run[1];                  
     
        if (($XOffs+$Run) >= 2048) {
            return;
        }         
        elseif (($XOffs+$Run)!=0) {         
            $X += $XOffs;
            for ($j=0; $j<$Run; $j++)
            {                
                SetColors( $fp, $img, $X+$j, $Y, $hue );
            }
            $X += $Run;
        } 
        else {
            $X=0;
            $Y++;
            if(array_key_exists($Y, $LineOffsets)){
                fseek($fp, $DataStart + $LineOffsets[$Y]*2);
            }
        }
    } 
}

// decode RAW tile
function DecodeRAWPic( $img, $fp, $hue )
{
    for ($i=0; $i<22; $i++)
    {
        for ($j=22-($i+1); $j<(22-($i+1))+($i+1)*2; $j++)
         {
            SetColors( $fp, $img, $j, $i, $hue );    
         }
    }
    for ($i=0; $i<22; $i++)
    {
        for ($j=$i; $j<$i+(22-$i)*2; $j++)
        {
            SetColors( $fp, $img, $j , $i+22, $hue );    
        }
    }    
}

function ResizeImage($img, $ratio, $center, $setheight=0)
{    
    $width = imagesx($img);
    $height = imagesy($img);         
    
    //echo $center;        
    
    if( $center ) {
        $color_none = imagecolorat ( $img, 0, 0);
        
        $xmin = imagesx($img);
        $xmax = 0;
        $ymin = imagesy($img);
        $ymax = 0;
        
        for ($y=0; $y < imagesy($img); $y++) { 
        	for ($x=0; $x < imagesx($img); $x++) {             
                if(imagecolorat ( $img, $x, $y) != $color_none) {
                    if( $xmax < $x ) 
                        $xmax = $x;                                        
                    if( $xmin > $x )
                        $xmin = $x;
                    
                    if( $ymax < $y ) 
                        $ymax = $y;                                        
                    if( $ymin > $y )
                        $ymin = $y;  
                }                
            }
        }        

        $height = abs($ymin - $ymax);
        $width = abs($xmax - $xmin) ;
    }    
    
    if( $setheight == 0 ) {
    	$newwidth = $width * $ratio;
    	$newheight = $height * $ratio;  
    } else {
    	$newwidth = $setheight / ($height/$width);
    	$newheight = $setheight;    	
    }    
    
    $thumb = imagecreatetruecolor($newwidth, $newheight); 
    
    if( $center ) {    
        imagecopyresampled($thumb, $img, 0, 0, $xmin, $ymin, $newwidth, $newheight, $width, $height);
    }
    else {
        imagecopyresampled($thumb, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);        
    }
    
    return $thumb;
}

function ShowImageDoesntExists($block_no)
{
    if( $block_no > MAX_TILE )
        $block_no = MAX_TILE;
    
    header("Content-type: image/png");
    $im = @imagecreate(44, 44)
    or die("Cannot Initialize new GD image stream");
    $background_color = imagecolorallocate($im, 0, 0, 0);
    $text_color = imagecolorallocate($im, 233, 14, 91);    
    imagestring($im, 2, 13, 2, "bad", $text_color);
    imagestring($im, 2, 7, 14, "image", $text_color);    
    imagestring($im, 1, 4, 30, "#".$block_no, $text_color);
    imagepng($im);
    imagedestroy($im);
}
 
function RenderAnimMulImage($body, $hue)
{	

	if($hue) {
		$hue = $hue & ~0x4000;
		$hue = $hue & ~0x8000;
	}
	
	$res = bodyconv( $body );
	
	$body = $res['model_no'];
		
	$action = 4;
	$direction = 1;
	
	$index_no;
	
	if( $res['index'] == 1 ) {
		if( $body < 200 )
			$index_no = $body * 110;
		else if( $body < 400 )
			$index_no = 22000 + ( ( $body - 200 ) * 65 );
		else
			$index_no = 35000 + ( ( $body - 400 ) * 175 );	
	} elseif ($res['index'] == 2 ) {
		if( $body < 200 )
			$index_no = $body * 110;
		else
			$index_no = 22000 + ( ( $body - 200 ) * 65 );
	} elseif ($res['index'] == 3 ) {
		if( $body < 300 )
			$index_no = $body * 65;
		else if( $body < 400 )
			$index_no = 33000 + ( ( $body - 300 ) * 110 );
		else
			$index_no = 35000 + ( ( $body - 400 ) * 175 );
	}
	
	$index_no += $action * 5;
	
	if ( $direction <= 4 )
		$index_no += $direction;
	else
		$index_no += $direction - ($direction - 4) * 2;
	
	$idx_filename;
	$mul_filename;
	
	if( $res['index'] == 1 ) {
		$idx_filename = "anim.idx";
		$mul_filename = "anim.mul";
	}
	elseif( $res['index'] == 2 ) {
		$idx_filename = "anim2.idx";
		$mul_filename = "anim2.mul";
	}
	elseif( $res['index'] == 3 ) {
		$idx_filename = "anim3.idx";	
		$mul_filename = "anim3.mul";
	}
	
    $anim_idx = ReadMulIdx( $index_no, $idx_filename );   
    
    if($anim_idx["lookup"]==-1)
    {    	
        ShowImageDoesntExists($body);
        exit;
    }
    //AnimationGroup
    //WORD[256] Palette
    
    $fp = fopen(ULTIMA_DIR.$mul_filename, "rb");  
    fseek($fp, $anim_idx["lookup"]);    
    $palette = array_merge(unpack("v*", fread($fp, 256*2)));
    $palette_pos = ftell($fp);

    //DWORD FrameCount
    $frameCount = unpack("V", fread($fp, 4));   
    $frameCount = $frameCount[1];   
    //DWORD[FrameCount] FrameOffset 
    $frameOffset = array_merge(unpack("V*", fread($fp, 4*$frameCount))); 
    
    //var_dump( $frameCount );
    //var_dump( $anim_idx );
   
    fseek($fp, $palette_pos + $frameOffset[0]);       
    
    //WORD ImageCenterX
    $imageCenterX = unpack("v", fread($fp, 2)); 
    $imageCenterX = $imageCenterX[1];
    //WORD ImageCenterY
    $imageCenterY = unpack("v", fread($fp, 2)); 
    $imageCenterY = $imageCenterY[1];
    //WORD Width
    $width = unpack("v", fread($fp, 2)); 
    $width = $width[1];
    //WORD Height
    $height = unpack("v", fread($fp, 2)); 
    $height = $height[1];   
    
    $my_img = imagecreatetruecolor( $width, $height ); 
    
    $CenterX = $imageCenterX;
    $CenterY = $imageCenterY;
    
    $X=0;
    $Y=0;
    $PrevLineNum=0xFF;
    
    while (true) {
        
        $RowHeader = unpack("v", fread($fp, 2)); 
        $RowHeader = $RowHeader[1]; 
        $RowOfs = unpack("v", fread($fp, 2)); 
        $RowOfs = $RowOfs[1];
         
        if (($RowHeader==0x7FFF)||($RowOfs==0x7FFF)) { 
            break; 
        }
        $RunLength=$RowHeader & 0xFFF;         
        $X = ($RowOfs >> 6) & 0x3FF;
        $LineNum = $RowHeader >> 12;
        if ($RowOfs & 0x8000) 
            $X = $CenterX + $X - 0x400;
        else 
            $X = $CenterX + $X;
        if (($PrevLineNum!=0xFF) && ($LineNum!=$PrevLineNum)) 
            $Y++;
        
        $PrevLineNum = $LineNum;
        if ($Y>=0) {
            if ($Y >= $height) 
                break;
            
            for ($j=0; $j < $RunLength; $j++) {
                $b = unpack("C", fread($fp, 1)); 
                $b = $palette[$b[1]];            
                
                if($hue > 0) {
                    $b = ApplyHue15bit( $b, $hue );
                }       
                $Color32 = Convert15bitToTrueColor( $b );    
                $rgb = TrueColorToRGB( $Color32 );    
                imagesetpixel( $my_img, $X + $j, $Y, imagecolorallocate($my_img, $rgb[0], $rgb[1], $rgb[2]) );                  
            }
        }
    }    		

    return $my_img;
}

function RenderArtMulImage($tile_idx, $hue)
{
    $art_idx = ReadMulIdx( $tile_idx, "artidx.mul" );
    $art_header = ReadArtHeader( $art_idx );
    
    $found_in_verdata = false;

    if($art_header==NULL)
    {
    	if(!file_exists(ULTIMA_DIR."verdata.mul")) {
			ShowImageDoesntExists($tile_idx);			
        	exit;
    	}
	   	$verdata = fopen(ULTIMA_DIR."verdata.mul", "rb");
	    $num_patches = unpack("V", fread($verdata, 4));
	    $num_patches = $num_patches[1];
	    $found_in_verdata = false;	   
	    	
	    $counten = 0;
		for ($i=0; $i < $num_patches; $i++) { 
			$fileId = unpack("V", fread($verdata, 4));
			$fileId = $fileId[1];			
			if ($fileId == 4) {
				$blockId = unpack("V", fread($verdata, 4));
				$blockId = $blockId[1];
				//echo("besex ".$blockId."<br>");
				if($blockId==$tile_idx) {
					//echo("besex ".$tile_idx);
					$lookup = unpack("V", fread($verdata, 4));
					$lookup = $lookup[1];
					fseek($verdata, $lookup);
					$flag = unpack("V", fread($verdata, 4));
					$flag = $flag[1];					
					$found_in_verdata = true;										
					$art_header = unpack("vwidth/vheight", fread($verdata, 4));					
					fseek($verdata, -4, SEEK_CUR);
					break;
				} else {
					fseek($verdata, 12, SEEK_CUR);
				}
			} else {
				fseek($verdata, 16, SEEK_CUR);
			}			
		}
    	if(!$found_in_verdata) {
        	ShowImageDoesntExists($tile_idx);        	
        	exit;
        }
    }              

	if( $found_in_verdata == false ) {
		$fp = fopen(ULTIMA_DIR."art.mul", "rb");
    	fseek($fp, $art_idx["lookup"]);        
    	$flag = fread($fp, 4);
    	$flag = unpack("V", $flag);
    	$flag = $flag[1];
    	if(isset($verdata)) {    		
    		fclose($verdata);
    	}
    } else {
    	$fp = $verdata;
    }

    $flag  = (float) sprintf("%s%u", $flag < 0 ? "-":"", abs($flag));

    if (!$flag||$flag>0xFFFF) { //raw tile
        fseek($fp, -4, SEEK_CUR);
        $my_img = imagecreatetruecolor( 44, 44 );
        DecodeRAWPic( $my_img, $fp, $hue );
    } else {
        fseek($fp, 4, SEEK_CUR);
        $my_img = imagecreatetruecolor( $art_header["width"], $art_header["height"] );        
        DecodeRLEPic( $my_img, $art_header["width"], $art_header["height"], $fp, $hue );
    }                    
    fclose($fp);       
    return $my_img;
}

function GetAnimDataStaticOffset($static_id)
{
	return $static_id * (64+4) + 4 * (($static_id / 8) + 1);
}

function WriteAnimData($static_id, $animdata)
{
	$offset = GetAnimDataStaticOffset($static_id);
    
    $fp = fopen(ULTIMA_DIR."animdata.mul", "rb+");   
    fseek($fp, $offset);
    
    foreach ($animdata["frames"] as $key => $value) {
        fwrite($fp, pack("C", $value));
    }
    
    //byte     Unknown
    fseek($fp, 1, SEEK_CUR);    

    //byte     Number of Frames Used
    fwrite($fp, pack("C", $animdata["frames_no"]));    
    
    //byte     Frame Interval
    fwrite($fp, pack("C", $animdata["frame_interval"]));  
    
    //byte     Start Interval
    fwrite($fp, pack("C", $animdata["start_interval"]));            
    
    fflush($fp);
    fclose($fp);
}

function ReadAnimData($static_id)
{               
    $fp = fopen(ULTIMA_DIR."animdata.mul", "rb");          
   
    $animdata = array();
    
    $offset = GetAnimDataStaticOffset($static_id);      
       
    //byte[64] Frames    
    fseek($fp, $offset);        
    
    $animdata["frames"] = unpack("C*", fread($fp, 64));            
    $elm = array_shift($animdata["frames"]);                              
    array_unshift($animdata["frames"], $elm);
    
    //byte     Unknown
    fseek($fp, 1, SEEK_CUR);        
    
    //byte     Number of Frames Used
    $frames_no = unpack("C", fread($fp, 1));
    $animdata["frames_no"] = $frames_no[1];          

    //byte     Frame Interval
    $frame_interval = unpack("C", fread($fp, 1));
    $animdata["frame_interval"] = $frame_interval[1];   
    
    //byte     Start Interval
    $start_interval = unpack("C", fread($fp, 1));
    $animdata["start_interval"] = $start_interval[1];       
        
    
    fclose($fp);
    
    return $animdata;
}

function GetHues()
{
    $fp = fopen(ULTIMA_DIR."hues.mul", "rb");
    
    $hues;
    
    while( true ) {        
        
        //HueGroup
        $hueGroup = array();
        //DWORD Header;
        $hueHeader = fread($fp, 4);
        if($hueHeader==NULL) {
            break;
        }
        $hueHeader = unpack("N", $hueHeader);
        $hueGroup["header"] = $hueHeader[1];
        //HueEntry Entries[8]; 
        $hueGroup["entries"] = array();
        
        //HueEntry
        $hueEntry = array();    
        
        for ($i=0; $i < 8; $i++) { 
            //WORD ColorTable[32];
            $colorTable = unpack("v*", fread($fp, 32 * 2));
            
            $elm = array_shift($colorTable);                              
            array_unshift($colorTable, $elm);
            
            $hueEntry["colorTable"] = $colorTable;
            
            //WORD TableStart;
            $tableStart = unpack("v", fread($fp, 2));
            $hueEntry["tableStart"] = $tableStart[1];
            //WORD TableEnd;
            $tableEnd = unpack("v", fread($fp, 2));    
            
            $hueEntry["tableEnd"] = $tableEnd[1];
            //CHAR Name[20]; 
            $hueEntry["name"] = fread($fp, 20);
            //echo "Header: ".$hueGroup["header"].", Group name: ".$name."<br>";
            array_push( $hueGroup["entries"], $hueEntry );
        }
        $hues[] = $hueGroup;            
    }
    
    fclose($fp);
    return $hues;
}

function ReadArtHeader( $art_index, $mulfile = "art.mul" )
{        
    if( $art_index["lookup"]==0xFFFFFFFF or $art_index["lookup"]<0 ) {
        return NULL;
    }
    
    $fp = fopen(ULTIMA_DIR.$mulfile, "rb");  
    fseek($fp, $art_index["lookup"]);
    $data = fread($fp, $art_index["size"]);    
    fclose($fp);    
    $art_header = unpack("Nflag/vwidth/vheight", $data);
    return $art_header;
}

function ReadMulIdx( $block_no, $mulfile )
{
    $fp = @fopen(ULTIMA_DIR.$mulfile, "rb");  
    if(!$fp)
    {
        die("Can't open ".ULTIMA_DIR.$mulfile."!");
    }
    fseek($fp, $block_no * 12);
    $data = fread($fp, 12);
    if($data==false) {
        ShowImageDoesntExists($block_no);
        exit;
    }
    $res = unpack("Vlookup/Vsize/Vunknown", $data);  
    $res["index"] = $block_no; 
    fclose($fp);
    return ($res);
}