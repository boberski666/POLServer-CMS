<?php
class CharactersLayersModel extends Model {
    public function __construct() {
        parent::__construct('characters_layers', function() {
        	$inst = R::xdispense( 'characters_layers' );
			$inst->charId = 1707739;
			$inst->layerId = 1;
			$inst->itemId = 3834;
			$inst->itemHue = 0;

			R::store( $inst );
			R::wipe( 'characters_layers' );
        });
    }
    
}