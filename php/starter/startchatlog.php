<?
require_once('./starter.php');
class startChatLog extends startLogs {
    public function startChatLog() {

    $show_sql = 'SHOW DATABASES LIKE "chat"';

    $show_sql_result = mysqli_query($this->conn_fullsql, $show_sql);

    $show_sql_assoc = mysqli_fetch_assoc($show_sql_result);
        
    if ($show_sql_assoc !== null) {
    echo 'База данных 1 загружена'.PHP_EOL.PHP_EOL;
    
    } 
    else {

    echo 'База данных 1 отсутствует.'.PHP_EOL.PHP_EOL.'Выполняется попытка ее создать.'.PHP_EOL.PHP_EOL;

    $create_chat = 'CREATE DATABASE chat';

    if (mysqli_query($this->conn_fullsql, $create_chat)) {  

    echo "База данных 1 успешно создана";  

    } else {  
    echo "Ошибка создания базы данных 1: " . mysqli_error($conn_fullsql).PHP_EOL;  
    }  

    }
    }
}

?>