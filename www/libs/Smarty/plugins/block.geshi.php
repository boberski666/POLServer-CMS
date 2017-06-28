<?php 

/** 
 * Smarty plugin 
 * ------------------------------------------------------------- 
 * File:          block.geshi.php 
 * Type:          block 
 * Name:          geshi 
 * Version:       1.0, Oct 25th 2008 
 * Author:        Ben Keen (ben.keen@gmail.com), see: http://www.benjaminkeen.com 
 *  changed by:   Alexander Rust (www.bitrust.de) on 19.05.2009 
 * Purpose:       Render a block of text using GeSHi (Generic Syntax Highlighter). See: 
 *                http://qbnz.com/highlighter/ 
 * Requirements:  you must have installed geshi on your server, and update the require_once() line 
 *                below in order to get it configured. 
 * 
 *                Example usage: 
 * 
 *                  {geshi lang="php" show_line_numbers=true start_line_numbers_at=5} 
 *                    function my_funct() 
 *                    { 
 *                      echo "chicken!"; 
 *                      return true; 
 *                    } 
 *                  {/geshi} 
 * 
 * Parameters:    This function takes the following parameters: 
 *                   "lang": This determines the programming language with which to highlight the 
 *                           text. You can specify any languages available for Geshi. 
 *                   any other parameter is exact like in GeSHI 
 * ------------------------------------------------------------- 
 */ 
function smarty_block_geshi($params, $content, &$smarty) {
   $folder = dirname(__FILE__); 
   require_once('geshi'.DIRECTORY_SEPARATOR.'geshi.php'); 

	if (is_null($content)) 
		return; 

	if (empty($params["lang"])) { 
		$smarty->trigger_error("assign: missing 'lang' parameter. Geshi needs this value to know which language to render the code with."); 
		return; 
	}

	// trim the content to prevent any extra newlines appearing at the start and end 
	$geshi = new GeSHi(trim($content), $params['lang']); 

	// Alexander deletes some lines an added this 
	unset($params['lang']); 
	foreach ($params as $key => $value)
		$geshi->$key($value);
	$geshi->set_header_type(GESHI_HEADER_DIV);
	if(isset($params['tab_width']))
		$geshi->set_tab_width($params['tab_width']);
	else
		$geshi->set_tab_width(2);
//	$geshi->set_overall_style('color: blue;', true);
//	$geshi->set_keyword_group_style(3, 'color: white;', true);
	echo $geshi->parse_code(); 
} 