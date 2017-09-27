<?php
class CharactersOnlineModel extends Model {
    public function __construct() {
        parent::__construct('characters_online', function() {
        	$inst = R::xdispense( 'characters_online' );
			$inst->charId = 1707739;
			$inst->charName = 'Boberski';
			$inst->loginTime = 1506543279;
            $inst->charCmdlevel = 0;

			R::store( $inst );
			R::wipe( 'characters_online' );
        });
    }
        
    public function loadOnlineCharacters() {
        return parent::loadAll();
    }
    
}