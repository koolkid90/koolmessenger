<?php

class regData {
    
    public function __construct($conn = null, $conn2 = null) {
    
        $this->conn = $conn;
        $this->conn2 = $conn2;
    
    
    }

    public function regData() {
        
        $reglog = $_POST['reg_data'];
        [$login,$password] = explode('_',$reglog);
        $check_sql = 'SELECT login, password FROM users WHERE login="'.$login.'"';
        $check_sql_query = mysqli_query($this->conn2, $check_sql);
        $check_assoc = mysqli_fetch_assoc($check_sql_query);
        if(isset($check_assoc)) {
            if($check_assoc['login'] == $login) {
                echo 'Пользователь с данным логином уже существует';
            }
         } else {
        $reglog_sql = 'INSERT INTO users (login, password, dialogs ) VALUES ("'.$login.'","'.$password.'", "")';
        $reglog_result = mysqli_query($this->conn2, $reglog_sql); 
        echo 'Вы успешно зарегестрированы';
        }
    }
}

?>