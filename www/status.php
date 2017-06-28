<?php
require_once('libs/PolPackUnpack.php');
require_once('cache/config.map');

if (($fsocked = @fsockopen(POL_HOST, POL_AUX_PORT, $errno, $errstr, 2)) === FALSE) {
    echo '<p>Status: <b><span style = "color: #ff0000;">DOWN</span></b></p>';
} else {
    fputs($fsocked, packPolArray(array(
        POL_AUX_PASSWORD,
        "status"
    )) . "\n");
	
    $ret  = fgets($fsocked, 4096);
    $data = unPackPolArray($ret);
	
    fclose($fsocked);
	
    echo '<p style = "line-height: 1.5em;">Status: <b><span style = "color: #006400;">UP</span></b><br/>';
    echo 'Uptime: <b>' . secondsToWords($data[1]) . '</b><br/>';
    echo 'IP: <b>' . POL_PUBLIC_HOST  . '</b><br/>';
    echo 'Port: <b>' . POL_PORT  . '</b><br/>';
    echo 'Accounts: <b>' . $data[0] . '</b><br/>';
}

function secondsToWords($seconds)
{
    $ret = "";
    
    /*** get the days ***/
    $days = intval(intval($seconds) / (3600 * 24));
    if ($days > 0) {
        $ret .= "$days days ";
    }
    
    /*** get the hours ***/
    $hours = (intval($seconds) / 3600) % 24;
    if ($hours > 0) {
        $ret .= "$hours hours ";
    }
    
    /*** get the minutes ***/
    $minutes = (intval($seconds) / 60) % 60;
    if ($minutes > 0) {
        $ret .= "$minutes minutes ";
    }
    
    /*** get the seconds ***/
    $seconds = intval($seconds) % 60;
    if ($seconds > 0) {
        $ret .= "$seconds seconds";
    }
    
    return $ret;
}