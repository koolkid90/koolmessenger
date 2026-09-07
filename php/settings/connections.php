<?php 
require_once("settings.php");

class Connections extends Settings {
    protected $chat_connection;
    protected $users_connection;
    
    public function __construct($sql_password = null, $sql_login = null, $sql_host = null, 
                                $sql_chat_table = null, $sql_users_table = null) {
        // Вызываем конструктор родителя
        try { 
            parent::__construct($sql_host, $sql_login, $sql_password);
        
        // Используем правильные имена свойств
        if ($sql_chat_table !== null) $this->sql_chat_table = $sql_chat_table;
        if ($sql_users_table !== null) $this->sql_users_table = $sql_users_table;
        
        // Создаем соединения
        $this->chat_connection = new PDO("mysql:host=".$this->sql_host."; dbname=".$this->sql_chat_table."", $this->sql_login, $this->sql_password,[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $this->users_connection = new PDO("mysql:host=".$this->sql_host."; dbname=".$this->sql_users_table."", $this->sql_login, $this->sql_password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);;
        
    } catch (PDOException $e) {
        // Логируем ошибку
        error_log('Database connection error: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        
        // Выводим понятное сообщение пользователю
        die('
            <div style="
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: #fee2e2;
                border-left: 4px solid #ef4444;
                padding: 20px 30px;
                border-radius: 12px;
                font-family: monospace;
                text-align: center;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            ">
                <div style="font-size: 48px; margin-bottom: 10px;">🔌</div>
                <div style="font-weight: bold; margin-bottom: 8px;">Ошибка подключения к базе данных</div>
                <div style="font-size: 13px; color: #666;">Проверьте настройки в settings.php и убедитесь, что MySQL запущен</div>
            </div>
        ');
    }
}

}


?>