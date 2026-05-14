<?
// переменные настроек

class Settings {
    // Используем protected вместо private для наследования
    protected $sql_password = ''; // пароль к БД
    protected $sql_login = 'root'; // логин к БД
    protected $sql_host = 'localhost'; // хост БД
    protected $sql_chat_table = 'chat'; // название таблицы чата из БД
    protected $sql_users_table = 'users_info'; // название таблицы с юзерами из БД
    
    // Добавляем конструктор для установки значений
    public function __construct($sql_host = null, $sql_login = null, $sql_password = null) {
        if ($sql_host !== null) $this->sql_host = $sql_host;
        if ($sql_login !== null) $this->sql_login = $sql_login;
        if ($sql_password !== null) $this->sql_password = $sql_password;
    }
}


?>