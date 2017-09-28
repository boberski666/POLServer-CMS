<?php
class CharactersModel extends Model {
    public function __construct() {
        parent::__construct('characters', function() {
        	$inst = R::xdispense( 'characters' );
			$inst->charId = 1707739;
			$inst->charName = 'Boberski';
			$inst->charTitle = '';
			$inst->charRace = 'Human';
			$inst->charBody = 400;
			$inst->charFemale = 0;
			$inst->charBodyhue = 33770;
			$inst->charPublic = 1;
			$inst->charCmdlevel = 0;
			

			R::store( $inst );
			R::wipe( 'characters' );
        });
    }
    
    public function loadAllCharacters() {
        return parent::loadAll();
    }
    
}