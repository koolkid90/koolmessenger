<?php
require_once('./essentials/starter_func.php');


class Starter extends serverStarter {
protected $conn_fullsql;
    
    public function __construct($sql_host = null, $sql_login = null, $sql_password = null) {
        // Вызываем конструктор родителя
        parent::__construct($sql_password, $sql_login, $sql_host);
        
        // Создаем PDO соединение без БД
        try {
            $this->conn_fullsql = new PDO(
                "mysql:host={$this->sql_host};charset=utf8mb4",
                $this->sql_login,
                $this->sql_password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        
        $this->serverstarter = new serverStarter();
    }


    public function startChatLog() {
        $this->serverstarter->startChatLog();
    }
    
    public function startUsersLog() {
        $this->serverstarter->startUsersLog();
    }
    
    public function startServer() { // проверяем существования базы чата и юзер_инфо, если они есть возвращаем false
        try {
        if($this->conn_fullsql == null) {
            echo 'Ошибка подключения к SQL';
            return false;
        }
        
        $show_sql1 = 'SHOW DATABASES LIKE "chat"';
        $show_sql_result1 = $this->conn_fullsql->query($show_sql1);
        $show_sql_assoc1 = $show_sql_result1->fetch(PDO::FETCH_ASSOC);
        
        $show_sql2 = 'SHOW DATABASES LIKE "users_info"';
        $show_sql_result2 = $this->conn_fullsql->query($show_sql2);
        $show_sql_assoc2 = $show_sql_result2->fetch(PDO::FETCH_ASSOC);

        function fullCheck($show_sql_assoc1, $show_sql_assoc2) {
            if ($show_sql_assoc1 == false && $show_sql_assoc2 == false) {
                return false;
            } else {
                return true;
            }
        }
        
        $server_conn = fullCheck($show_sql_assoc1, $show_sql_assoc2);
        
        if($server_conn == true) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        error_log('Database error in messCheck: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        echo '<div class="error-message">Ошибка загрузки сообщений. Пожалуйста, обновите страницу.</div>';
    } catch (Exception $e) {
        error_log('General error in messCheck: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        echo '<div class="error-message">Произошла непредвиденная ошибка.</div>';
    }
}
    
    public function checkServer() {
        $starter = new Starter();
        $serverCheck = $starter->startServer(); 
        if ($serverCheck == true) {
            echo 'ok';
        } else {
            echo 'error';
        }
    }
}
?>