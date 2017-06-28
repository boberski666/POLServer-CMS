<?php

class ApiTestController extends Controller {

    public function defaultAction() {
        $this->display->addParameter("_json_", array('error' => 'default'));
    }
    
}