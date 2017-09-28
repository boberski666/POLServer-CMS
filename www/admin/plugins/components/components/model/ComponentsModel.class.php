<?php

class ComponentsModel extends Model {
    public function __construct() {
        parent::__construct('components', function() {
        	$inst = R::dispense( 'components' );
			$inst->name = 'Components';
			$inst->url = 'components/';
			$inst->tables = 'components';
			$inst->version = 'Ver. 1.0';
			$inst->type = 1;
			$inst->subdomain = 'nosubdomain';
			$inst->canUninstall = false;
			
			R::store( $inst );
			
			$inst = R::dispense( 'components' );
			$inst->name = 'Pages';
			$inst->url = 'page/';
			$inst->tables = 'pages';
			$inst->version = 'Ver. 1.0';
			$inst->type = 1;
			$inst->subdomain = 'nosubdomain';
			$inst->canUninstall = false;
			
			R::store( $inst );
			
			$inst = R::dispense( 'components' );
			$inst->name = 'Pages';
			$inst->url = 'page/';
			$inst->tables = 'pages';
			$inst->version = 'Ver. 1.0';
			$inst->type = 2;
			$inst->subdomain = 'nosubdomain';
			$inst->canUninstall = false;
			
			R::store( $inst );
            
            $inst = R::dispense( 'components' );
			$inst->name = 'Menu';
			$inst->url = 'menu/';
			$inst->tables = 'menu';
			$inst->version = 'Ver. 1.0';
			$inst->type = 2;
			$inst->subdomain = 'nosubdomain';
			$inst->canUninstall = false;
			
			R::store( $inst );
        });
    }
	
	public function loadByType($type = 0) {
        return parent::loadByQuery( 'type = ?', [ $type ] );
    }
}