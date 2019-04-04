<?php

class User
{
    protected $is_connected = false;
    protected $id, $display_name, $auth_method;
    protected $groups =array();

    protected $db;

    public function __sleep(){
        return array('is_connected','id','display_name','auth_method','groups');
    }

    public function get_id()
    {
        if($this->is_connected){
            return $this->id;
        }
        return false;
    }
    public function is_connected()
    {
        return $this->is_connected;
    }
    public function get_auth_method()
    {
        if($this->is_connected){
            return $this->auth_method;
        }
        return false;
    }
    public function get_groups()
    {
        return $this->groups;
    }
    public function set_db_obj($db){
        $this->db = $db;
        return $this;
    }
    public function __construct($db){
        $this->db = $db;
    }
   

 

}
