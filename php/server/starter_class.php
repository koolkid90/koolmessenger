<?
require_once('./starter_func.php');


class Starter extends serverStarter {
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
$this->serverstarter = new serverStarter();
}


public function startChatLog() {
	$this->serverstarter->startChatLog();
}
public function startUsersLog() {
	$this->serverstarter->startUsersLog();
}
public function startServer() { // проверяем существования базы чат и юзер_инфо, если они есть возвращаем false
	
		
	
	if($this->conn_fullsql == null) {
	echo 'Ошибка подключения к SQL';
	}
		
	$show_sql1 = 'SHOW DATABASES LIKE "chat"';
	$show_sql_result1 = mysqli_query($this->conn_fullsql, $show_sql1); 
	$show_sql_assoc1 = mysqli_fetch_assoc($show_sql_result1);
	
	$show_sql2 = 'SHOW DATABASES LIKE "users_info"';
	$show_sql_result2 = mysqli_query($this->conn_fullsql, $show_sql2); 
	$show_sql_assoc2 = mysqli_fetch_assoc($show_sql_result2);

	function fullCheck($show_sql_assoc1, $show_sql_assoc2) {
	if ($show_sql_assoc1 == null && $show_sql_assoc2 == null) {
				
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