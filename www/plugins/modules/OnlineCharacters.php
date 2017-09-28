<?php
$this->register_function('online_characters', 'print_online_characters');

function print_online_characters($params, &$smarty) {
	$return = "";
	
    $com = new CharactersOnlineModel();
    $online = $com->loadOnlineCharacters();
    
    if(count($online) == 0)
        $return = "<p>No characters online :(</p>";
    else {
        $return = "<p>";
        foreach ($online as $value)
           $return .= "<b><a href = '/char/id/$value->char_id'>$value->char_name</a></b> since ".timestampToText(time() - $value->login_time);
        $return .= "</p>";
	}
    
	return $return;
}

function timestampToText($seconds)
{
    $ret = "";
    
    /*** get the days ***/
    $days = intval(intval($seconds) / (3600 * 24));
    if ($days > 0) {
        $ret .= "$days ";
    }
    
    /*** get the hours ***/
    $hours = (intval($seconds) / 3600) % 24;
    if ($hours > 0) {
        $ret .= $hours."h ";
    }
    
    /*** get the minutes ***/
    $minutes = (intval($seconds) / 60) % 60;
    if ($minutes > 0) {
        $ret .= $minutes."m ";
    }
    
    /*** get the seconds ***/
    $seconds = intval($seconds) % 60;
    if ($seconds > 0) {
        $ret .= $seconds."s";
    }
    
    return $ret;
}