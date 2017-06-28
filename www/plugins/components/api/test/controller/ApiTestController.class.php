<?php

class ApiTestController extends Controller {

    public function defaultAction() {
        $this->display->addParameter("_json_", array('error' => 'default'));
    }
    
    public function trikAction() {
        $this->display->addParameter("_json_",
	        array (
			  'suggestions' => 
			  array (
			    0 => 
			    array (
			      'value' => 'TrikPOK',
			      'data' => 
			      array (
			        'sap' => 'TrikPOK',
			        'email' => 'karasinska.kamila@gmail.com',
			        'phone' => '791591443',
			      ),
			    ),
			  ),
			));
    }

}