<?php
class User_Sql extends User {

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