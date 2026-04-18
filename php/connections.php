<?php 
require_once("settings.php");

class Connections extends Settings {
    protected $chat_connection;
    protected $users_connection;
    
    public function __construct($sql_password = null, $sql_login = null, $sql_host = null, 
                                $sql_chat_table = null, $sql_users_table = null) {
        // Вызываем конструктор родителя
        parent::__construct($sql_host, $sql_login, $sql_password);
        
        // Используем правильные имена свойств
        if ($sql_chat_table !== null) $this->sql_chat_table = $sql_chat_table;
        if ($sql_users_table !== null) $this->sql_users_table = $sql_users_table;
        
        // Создаем соединения
        $this->chat_connection = new mysqli($this->sql_host, $this->sql_login, 
                                           $this->sql_password, $this->sql_chat_table);
        $this->users_connection = new mysqli($this->sql_host, $this->sql_login, 
                                            $this->sql_password, $this->sql_users_table);
    }
}

?>