<?php

class User_Manager
{

    private static $table_users = 'users';
    private static $table_groups = 'groups';


    const QUERY_CREATE_TABLE_USERS = "
        CREATE TABLE %table_users% (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `login` varchar(16) NOT NULL,
            `display_name` text NOT NULL,
            `auth_method` enum('local','ldap','cas','none') NOT NULL,
            `password` char(128) NOT NULL,
            `external_uid` char(45) NOT NULL,
            `admin` tinyint(1) NOT NULL,
            `active` tinyint(1) NOT NULL DEFAULT '1',
            `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `created_by` int(11) NOT NULL,
            `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
            `updated_by` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        );
        INSERT INTO TABLE %table_users% (id,login,display_name,auth_method,active,created_time,created_by)
        VALUES (0,'','SYSTEM','none',0, NOW(),0);
        ";

    const QUERY_CREATE_TABLE_GROUPS = "
        CREATE TABLE %table_groups% ( 
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` text NOT NULL,
            `active` tinyint(1) NOT NULL DEFAULT '1',
            `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `created_by` int(11) NOT NULL,
            `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
            `updated_by` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        );
    ";

    const QUERY_CREATE_REL_USERS_GROUPS = "  
        CREATE TABLE `%table_users%_%table_groups%_rel` (
            `user_id` int(11) NOT NULL,
            `group_id` int(11) NOT NULL,
            PRIMARY KEY (`user_id`,`group_id`),
            KEY `users_id` (`user_id`),
            KEY `group_id` (`group_id`),
            CONSTRAINT `%table_users%_%table_groups%_rel_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `%table_users%` (`id`),
            CONSTRAINT `%table_users%_%table_groups%_rel_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `%table_groups%` (`id`)
        );
    ";

    

    public function authentificate($db,$login, $password){
        $user = new User_Sql($db);
        if($user->authentificate($login,$password)){
            return $user;
        }

        return false;
    }
}