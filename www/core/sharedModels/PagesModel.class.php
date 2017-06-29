<?php
class PagesModel extends Model {
    public function __construct() {
        parent::__construct('pages', function() {
        	$inst = R::xdispense( 'pages' );
			$inst->name = 'home.htm';
			$inst->title = 'Home';
			$inst->source = '<p style = "text-align:center;"><img src = "/images/dragon.png" style = "width: 300px; height: 248px;" /></p>';
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