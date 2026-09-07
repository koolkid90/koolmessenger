<?php
require_once('./settings/connections.php');

class serverStarter extends Connections {
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
    }
    
    public function startChatLog() {
        $show_sql = 'SHOW DATABASES LIKE "chat"';
        $show_sql_result = $this->conn_fullsql->query($show_sql);
        $show_sql_assoc = $show_sql_result->fetch(PDO::FETCH_ASSOC);
            
        if ($show_sql_assoc !== false) {
            echo 'База данных 1 загружена' . PHP_EOL . PHP_EOL;
        } else {
            echo 'База данных 1 отсутствует.' . PHP_EOL . PHP_EOL . 'Выполняется попытка ее создать.' . PHP_EOL . PHP_EOL;
    
            $create_chat = 'CREATE DATABASE chat';
            if ($this->conn_fullsql->exec($create_chat)) {
                echo "База данных 1 успешно создана";
            } else {
                echo "Ошибка создания базы данных 1: " . $this->conn_fullsql->errorInfo()[2] . PHP_EOL;
            }
        }
    }
    
    public function startUsersLog() {
        $show_sql = 'SHOW DATABASES LIKE "users_info"';
        $show_sql_result = $this->conn_fullsql->query($show_sql);
        $show_sql_assoc = $show_sql_result->fetch(PDO::FETCH_ASSOC);
            
        if ($show_sql_assoc !== false) {
            echo 'База данных 2 загружена' . PHP_EOL . PHP_EOL;
        } else {
            echo 'База данных 2 отсутствует.' . PHP_EOL . PHP_EOL . 'Выполняется попытка ее создать.' . PHP_EOL . PHP_EOL;
    
            $create_users = 'CREATE DATABASE users_info';
            if ($this->conn_fullsql->exec($create_users)) {
                echo "База данных 2 успешно создана" . PHP_EOL . PHP_EOL;
    
                try {
                    $this->conn2 = new PDO(
                        "mysql:host={$this->sql_host};dbname=users_info;charset=utf8mb4",
                        $this->sql_login,
                        $this->sql_password,
                        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                    );
                    
                    $createUsersTable = "CREATE TABLE users (
                        login VARCHAR(30), 
                        password VARCHAR(30), 
                        dialogs VARCHAR(15000), 
                        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY
                    )";
                    
                    if ($this->conn2->exec($createUsersTable)) {
                        echo 'База данных настроена';
                    }
                } catch (PDOException $e) {
                    echo "Ошибка создания таблицы: " . $e->getMessage() . PHP_EOL;
                }
            } else {
                echo "Ошибка создания базы данных 2: " . $this->conn_fullsql->errorInfo()[2] . PHP_EOL;
            }
        }
    }
}
?>