<?php

class regData {
    
    public function __construct($conn = null, $conn2 = null) {
    
        $this->conn = $conn;
        $this->conn2 = $conn2;
    
    
    }

    public function regData() {
        
        try {
        $reglog = $_POST['reg_data'];
        [$login,$password] = explode('_',$reglog);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $check_sql = 'SELECT login, password FROM users WHERE login="'.$login.'"';
        $check_sql_query = $this->conn2->query($check_sql);
        $check_assoc = $check_sql_query->fetch(PDO::FETCH_ASSOC);
        if($check_assoc) {
            if($check_assoc['login'] == $login) {
                echo 'Пользователь с данным логином уже существует';
            }
         } else {
        $reglog_sql = 'INSERT INTO users (login, password, dialogs ) VALUES ("'.$login.'","'.$hashed_password.'", "")';
        $reglog_result = $this->conn2->query($reglog_sql); 
        echo 'Вы успешно зарегестрированы';
        }
    } catch (PDOException $e) {
        error_log('Database error in messCheck: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        echo '<div class="error-message">Ошибка загрузки сообщений. Пожалуйста, обновите страницу.</div>';
    } catch (Exception $e) {
        error_log('General error in messCheck: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        echo '<div class="error-message">Произошла непредвиденная ошибка.</div>';
    }
}
}

?>