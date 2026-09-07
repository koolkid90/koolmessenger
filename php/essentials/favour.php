<?php
require_once('./settings/connections.php');
class classFavour extends Connections {

public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
        
    
}
    
    public function createFavour() {
    try {
    $today = date("m.d.Y H:i"); 
    $login = $_POST['favourLog'];
    $favour = $login.'_Favourites';
    $charger = "SHOW TABLES FROM `chat` like '".$favour."'";
    $charger_sql = $this->conn->query($charger);
    $charger_sql_assoc = $charger_sql->fetch(PDO::FETCH_ASSOC);
    
    if ($charger_sql_assoc == false) {
    
    $favour_sql = "CREATE TABLE ".$favour." ( login VARCHAR(30) , message TEXT, date VARCHAR(100), id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY )";
    $newtable_favour = $this->conn->query($favour_sql);
    $insert_favour = 'INSERT INTO '.$favour.' VALUES ("Favourites","Ваши заметки хранятся тут","'.$today.'", "1" )';
    $insert_sql_favour = $this->conn->query($insert_favour);
    $insert_user_dia = 'UPDATE users SET dialogs = CONCAT(dialogs, "'.$favour.'" )  WHERE login ="'.$login.'"';
    $insert_user_dia_sql = $this->conn2->query($insert_user_dia);
    
    } 
    } catch (PDOException $e) {
        error_log('Database error in messCheck: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        echo '<div class="error-message">Ошибка загрузки сообщений. Пожалуйста, обновите страницу.</div>';
    } catch (Exception $e) {
        error_log('General error in messCheck: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        echo '<div class="error-message">Произошла непредвиденная ошибка.</div>';
    }
}
    
    
}
?>