<?php

class ComponentsController extends Controller {

    public function defaultAction() {
		$this->display->setComponentTpl("admin/plugins/components/components/tpl/default.tpl");
			
		$m = new ComponentsModel();
		$this->display->addParameter("_menu_",  $m->loadByType(1));
		$this->display->addParameter("_admin_",  $m->loadByType(1));
		$this->display->addParameter("_site_",  $m->loadByType(2));
    }

	public function uploadAction() {
		$this->display->setComponentTpl("admin/plugins/components/components/tpl/upload.tpl");
		
		$m = new ComponentModel();
		$this->display->addParameter("_menu_", $m->loadByType(1));
		
		if (!empty($_FILES['com'])) {
			try {
				$upload = Upload::factory('upload', ROOT_ADMIN_DIR);
				$upload->file($_FILES['com']);
				
				$validation = new validation;
				$upload->callbacks($validation, array('check_name_length'));
				$upload->set_allowed_mime_types(array('application/zip'));
				
				$results = $upload->upload();
				} catch (Exception $ex) {
				}
		}
			
		$this->display->addParameter("_message_", "<pre>".print_r($results, true)."</pre>");
	}
	
}

class validation {
	
	public function check_name_length($object) {
		
		if (mb_strlen($object->file['original_filename']) > 100) {
			
			$object->set_error('File name is too long.');
			
		}
	}
	
}