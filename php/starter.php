
<?php
require_once('connections.php');
require_once('starter/startchatlog.php');
require_once('starter/startuserslog.php');
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

class ChatLogControl extends startChatLog {
function startChatLogging() {
    startChatLog();
}
}
class UsersLogControl extends startUsersLog {
function startChatLogging() {
    startUsersLog();
}
}



?>