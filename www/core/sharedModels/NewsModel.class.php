<?php
class NewsModel extends Model {
    public function __construct() {
        parent::__construct('news', function() {
        	$inst = R::xdispense( 'news' );
			$inst->published = date('Y-m-d G:i:s');
			$inst->author = '';
			$inst->title = '';

			R::store( $inst );
            R::wipe( 'news' );
        });
    }
    
}