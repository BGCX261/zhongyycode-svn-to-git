<?php
class adminuser extends  Zend_Db_Table {
    protected $_name = 'regulus_admin_user';
    protected $_primary = 'id';
    protected $_db          = null;

    public function init() {
        $this->db = $this->getAdapter();
    }
    public function addNewss(){
	     echo 'dd';
      var_dump($this->db);
    }

}