<?php
require_once('connections.php');
class classFavour extends Connections {

public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
        
    
}
    
    public function createFavour() {
    $today = date("m.d.Y H:i"); 
    $login = $_POST['favourLog'];
    $favour = $login.'_Избранное';
    $charger = "SHOW TABLES FROM `chat` like '".$favour."'";
    $charger_sql = mysqli_query($this->conn, $charger);
    $charger_sql_assoc = mysqli_fetch_assoc($charger_sql);
    
    if ($charger_sql_assoc == null) {
    
    $favour_sql = "CREATE TABLE ".$favour." ( login VARCHAR(30) , message TEXT, date VARCHAR(100), id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY )";
    $newtable_favour = mysqli_query($this->conn, $favour_sql);
    $insert_favour = 'INSERT INTO '.$favour.' VALUES ("Все ваши заметки хранятся тут:","_____________","'.$today.'", "1" )';
    $insert_sql_favour = mysqli_query($this->conn, $insert_favour);
    $insert_user_dia = 'UPDATE users SET dialogs = CONCAT(dialogs, "'.$favour.'" )  WHERE login ="'.$login.'"';
    $insert_user_dia_sql = mysqli_query($this->conn2, $insert_user_dia);
    
    } 
    }
    
    
}

?>