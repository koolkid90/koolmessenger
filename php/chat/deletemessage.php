<?php
require_once('./connections.php');
class deleteMessage extends Connections {
public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
 }
    public function deleteMessageLog() {
        $delete_log = $_POST['delete_message_log'];
        [$dia_id,$message_id] = explode('/',$delete_log);
        $delete_sql = 'DELETE FROM '.$dia_id.' WHERE id = "'.$message_id.'"';
        $delete_query = mysqli_query($this->conn, $delete_sql);
        echo 'Сообщение удалено';
    }
    }
?>