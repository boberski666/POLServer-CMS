<?php
class SubnewsModel extends Model {
    public function __construct() {
        parent::__construct('subnews', function() {
        	$inst = R::xdispense( 'subnews' );
			$inst->news = 0;
			$inst->type = '';
			$inst->scope = '';
			$inst->changeText = str_repeat('&ensp;', 256);;
			$inst->author = '';

			R::store( $inst );
            R::wipe( 'subnews' );
        });
    }
    
    public function loadSubnews($id = 0) {
     	$sub = parent::loadByQuery( 'news = ?', [ $id ] );
     	return $sub;
    }
    
}