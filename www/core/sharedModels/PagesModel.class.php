<?php
class PagesModel extends Model {
    public function __construct() {
        parent::__construct('pages', function() {
        	$inst = R::xdispense( 'pages' );
			$inst->name = 'home.htm';
			$inst->title = 'Home';
			$inst->source = str_repeat('&ensp;', 256);
			$inst->modified = date('Y-m-d G:i:s');
			$inst->canDelete = 0;

			R::store( $inst );
        });
    }
	
	public function loadPage($name = 'home.htm') {
     	$page = parent::loadSingle( 'name LIKE ?', [ $name ] );
     	if(count($page) == 0) {
     		return array(false, $page);
	    } else {
	    	return array(true, $page);
	    }
    }
    
}