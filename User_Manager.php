<?php

class User_Manager
{
    
    public function authentificate($db,$login, $password){
        $user = new User_Sql($db);
        if($user->authentificate($login,$password)){
            return $user;
        }

        return false;
    }
}