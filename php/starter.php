<?php
class serverStarter  {


    public function __construct() {
    
    $this->conn_fullsql = new mysqli("localhost", "root", "");
    
    
    }
    public function startChatLog() {
        $show_sql = 'SHOW DATABASES LIKE "chat"';
        $show_sql_result = mysqli_query($this->conn_fullsql, $show_sql); 
        $show_sql_assoc = mysqli_fetch_assoc($show_sql_result);
        
        if ($show_sql_assoc !== null) {
            echo 'База данных 1 загружена'.PHP_EOL.PHP_EOL;
        } else {
            echo 'База данных 1 отсутствует.'.PHP_EOL.PHP_EOL.'Выполняется попытка ее создать.'.PHP_EOL.PHP_EOL;
            $create_chat = 'CREATE DATABASE chat';
            if (mysqli_query($this->conn_fullsql, $create_chat)) {  
                echo "База данных 1 успешно создана";  
            } else {  
                echo "Ошибка создания базы данных 1: " . mysqli_error($conn_fullsql).PHP_EOL;  
            }  
        }
        }
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