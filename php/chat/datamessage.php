<?php
require_once('./connections.php');
class DataMessage extends Connections{
public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
 }
public function messageData() {
        
        $message_data = json_decode($_POST['message_data']);
        
        $login = $message_data[1];
        $date = $message_data[2];
        $dia_id = $message_data[3];
        $message = $message_data[0];
    
        $messdata_sql = 'INSERT INTO '.$dia_id.' (login, message, date) VALUES ("'.$login.'" ,"'.$message.'" , "'.$date.'")';
        $messdata_sql_result = mysqli_query($this->conn, $messdata_sql); 
        }
        }

?>