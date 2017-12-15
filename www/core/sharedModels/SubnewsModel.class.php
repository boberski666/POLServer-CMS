<?php
class SubnewsModel extends Model {
    public function __construct() {
        parent::__construct('subnews', function() {
        	$inst = R::xdispense( 'subnews' );
			$inst->news = 0;
			$inst->scope = '';
			$inst->changeText = '';
			$inst->author = '';

			R::store( $inst );
            R::wipe( 'subnews' );
        });
    }
    
}