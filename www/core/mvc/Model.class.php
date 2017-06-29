<?php

class Model {
    private $model = null;
	private $modelName = null;
	private $install = null;
	
    public function __construct($modelName, $install) {
		$this->install = $install;
		$this->modelName = $modelName;
    }
	
	public function install() {
		if ( !count( R::find( $this->modelName ) ) )
			call_user_func($this->install);
	}

    public function toArray() {
        $r = array();
        $properties = get_object_vars($this->model);
        foreach ($properties as $key => $value) {
            if (!($properties[$key] instanceof PDO)):
                $r[$key] = $this->model->$key;
            endif;
        }
        return $r;
    }

    public function fromArray($array) {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $this->model->$key = $value;
            }
        }
    }

    public function fromObject(Model $obj) {
        $properties = get_object_vars($obj->model);
        foreach ($properties as $key => $value) {
            $this->model->$key = $value;
        }
    }
    
    public function getModel() {
        return $this->model;
    }
    
    public function getModelName() {
        return $this->modelName;
    }
    
    public function loadAll() {
        return R::findAll($this->modelName);
    }
    
    public function loadByID($id = 0) {
        $this->model = R::load($this->modelName, $id);
    }
    
    public function loadByQuery($query, $arg) {
        return R::find($this->modelName, $query, $arg);
    }
    
    public function loadSingle($query, $arg) {
        return R::getRow( 'SELECT * FROM '.$this->modelName.' WHERE '.$query.' LIMIT 1', $arg);
    }
	
	public function prepare() {
        $this->model = R::dispense( $this->modelName );
    }
    
	public function save() {
        return R::store($this->model);
    }
    
    public function delete() {
        return R::trash($this->model);
    }

}