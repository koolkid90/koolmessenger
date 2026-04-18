
<?php
require_once('connections.php');

class serverStarter extends Connections {
    protected $conn_fullsql;
    
    public function __construct($sql_host = null, $sql_login = null, $sql_password = null) {
        // Вызываем конструктор родителя
        parent::__construct($sql_password, $sql_login, $sql_host);
        
        // Создаем соединение без БД
        $this->conn_fullsql = new mysqli($this->sql_host, $this->sql_login, $this->sql_password);
        
        // Проверяем соединения
        if ($this->conn_fullsql->connect_error) {
            die("Connection failed: " . $this->conn_fullsql->connect_error);
        }
    }
}


class startUsersLog extends serverStarter {
    public function startUsersLog() {

    $show_sql = 'SHOW DATABASES LIKE "users_info"';
    $show_sql_result = mysqli_query($this->conn_fullsql, $show_sql); 
    $show_sql_assoc = mysqli_fetch_assoc($show_sql_result);
    if ($show_sql_assoc !== null) {
    echo 'База данных 2 загружена'.PHP_EOL.PHP_EOL;
    } else {
    echo 'База данных 2 отсутствует.'.PHP_EOL.PHP_EOL.'Выполняется попытка ее создать.'.PHP_EOL.PHP_EOL;
    $create_users = 'CREATE DATABASE users_info';
    if (mysqli_query($this->conn_fullsql, $create_users)) {
    echo "База данных 2 успешно создана".PHP_EOL.PHP_EOL;
    $this->conn2 = new mysqli("localhost", "root", "", "users_info");
    $createUsersTable = "CREATE TABLE users ( login VARCHAR(30) , 
    password VARCHAR(30), dialogs VARCHAR(15000), id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY )";
    if (mysqli_query($this->conn2, $createUsersTable)) {
    echo 'База данных настроена';
        }
    } else {  
    echo "Ошибка создания базы данных 2: " . mysqli_error($conn_fullsql).PHP_EOL;  
    }  
    }
    }
}
?>