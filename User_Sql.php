<?php
class User_Sql extends User {


        public static function create_user(PDO $db,$table_users,$login, $display_name,
                                            $password,$admin = false,$active = true)
        {
            $stmt = $db->prepare(
                "INSERT INTO " . $table_users . " 
                    (login, display_name, auth_method,password,admin,active) 
                VALUES 
                    (:login, :display_name, 'local', :password, :admin, :active)"
            );

            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':display_name', $display_name);
            $stmt->bindParam(':password',$hashed_password);
            $stmt->bindParam(':admin', $adminInt);
            $stmt->bindParam(':active', $activeInt);

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $adminInt = $admin? 1 : 0;
            $activeInt = $activeInt? 1 : 0;
            $stmt->execute();

            return $db->lastInsertId(); 
        }

        public function authentificate($login,$password)
        {
        
            $sql =  
            "SELECT id,display_name,
            FROM users 
            WHERE login='". mysqli_real_escape_string($this->db,$login) . "'
            AND password=SHA2('". mysqli_real_escape_string($this->db,$password) . "',512)
            AND auth_method='local';";
    
            $rs = $this->db->query($sql);
            
            if($r = $rs->fetch_array(MYSQLI_ASSOC)){
                $this->is_connected = true;
                $this->display_name = $r["display_name"];
                $this->id = $r['id'];
                $this->auth_method = 'sql';
                
                return $this;
    
            }else{
                $this->is_connected = false;
                return false;
    
            }

            return false;
        }

}