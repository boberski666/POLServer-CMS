<?php

$this->register_function('news', 'print_news');

function print_news($params, &$smarty) {
	$return = "";
    
	$model = new NewsModel();
    $news = $model->loadAllNewsDESC();
        
    foreach ($news as $value) {
        $return .= '<div class="row">';
        $return .= '<h2>'.$value->title.'</h2>';
        $return .= '<h4 style = "text-align: center;">Napisany przez '.$value->author.' dnia '.$value->published.'</h4>';
        foreach ($value['elements'] as $subvalue) {
            $return .= '<p class="section-description">';
            $return .= '<u>'.$subvalue->scope.'</u></br>';
            $return .= make_links_clickable($subvalue->change_text);
            $return .= '</p>';
        }
        $return .= '</div>';
        $return .= '<div class="row items-container bottom-wrapper">';
        $return .= '<p>&nbsp;<br>&nbsp;</p>';
        $return .= '</div>';
    }
        
    return $return;
}

function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" target="_blank">$1</a>', $text);
}