<?php

class User
{
    protected $is_connected = false;
    protected $external_id; //the user's ID on the external auth system (Object SID on LDAP)
    protected $id; //the internal id to store locally user's datas
    protected $display_name;
    protected $auth_method;
    protected $groups =array();

    protected $db;

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
    
    public function __construct($db){
        $this->db = $db;
    }
   

 

}
