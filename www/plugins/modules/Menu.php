<?php

$this->register_function('menu', 'print_menu');

function print_menu($params, &$smarty) {
	$return = "";
	
    $m = new MenuModel();
    list($exists, $menuData) = $m->loadMenu($params['id']);
    
    if ($exists) {
        $return = "<ul id = 'menu".$params['id']."'>";
        foreach ($menuData as $value)
           $return .= "<li><a href = '$value->url' target = '$value->target'>$value->name</a></li>";
        $return .= "</ul>";
    }

	return $return;
}