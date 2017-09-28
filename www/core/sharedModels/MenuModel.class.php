<?php
class MenuModel extends Model {
    public function __construct() {
        parent::__construct('menu', function() {
        	$inst = R::xdispense( 'menu' );
			$inst->menu = 0;
			$inst->position = 0;
			$inst->active = 1;
			$inst->name = 'Home';
            $inst->url = '/';
            $inst->target = '_self';
			$inst->canDelete = 0;

			R::store( $inst );
        });
    }
	
	public function loadMenu($id = 0) {
     	$menu = parent::loadByQuery( 'menu = ? AND active = 1 ORDER BY position', [ $id ] );
     	if(count($menu) == 0) {
     		return array(false, $menu);
	    } else {
	    	return array(true, $menu);
	    }
    }
    
}