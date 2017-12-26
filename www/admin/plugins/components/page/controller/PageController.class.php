<?php

class PageController extends Controller {

	public function defaultAction() {
		$this->display->setComponentTpl("admin/plugins/components/page/tpl/default.tpl");
        
        $com = new PagesModel();
        $this->display->addParameter("_pages_",  $com->loadAllPages());
	}

    public function editAction() {
		$this->display->setComponentTpl("admin/plugins/components/page/tpl/edit.tpl");
        
        $com = new PagesModel();
        list($exists, $pageData) = $com->loadPageForEdit($this->params['id']);
        $this->display->addParameter("_page_", $pageData);
	}
    
    public function newAction() {
		$this->display->setComponentTpl("admin/plugins/components/page/tpl/new.tpl");
	}
    
    public function saveAction() {
		$this->display->setComponentTpl("admin/plugins/components/page/tpl/save.tpl");
        
        if($_POST['type'] == 'edit') {
            $page = new PagesModel();
            $page->loadPageByID($_POST['id']);
            $page->getModel()->title = $_POST['title'];
            $page->getModel()->source = $_POST['editor_content'];
            $page->getModel()->modified = date('Y-m-d G:i:s');
            $page->savePage();
            
            $this->display->addParameter("_msg_",  "Page edited successfully!");
        }
        
        if($_POST['type'] == 'new') {
            $page = new PagesModel();
            
            $page->newPage();
            $page->getModel()->name = str_replace(" ", "-", strtolower(strtr($_POST['title'], 'ĘÓĄŚŁŻŹĆŃęóąśłżźćń', 'EOASLZZCNeoaslzzcn'))).'.htm';
            $page->getModel()->title = $_POST['title'];
            $page->getModel()->source = $_POST['editor_content'];
            $page->getModel()->modified = date('Y-m-d G:i:s');
            $page->getModel()->canDelete = 1;
            $page->savePage();
            
            $this->display->addParameter("_msg_",  "Page added successfully!");
        }
        
        if(isset($this->params['id'])) {
            $page = new PagesModel();
            $page->removePage($this->params['id']);
            
            $this->display->addParameter("_msg_",  "Page removed successfully!");
        }
	}
}