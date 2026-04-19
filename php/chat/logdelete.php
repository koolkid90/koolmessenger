<?php
require_once('./connections.php');
class LogDelete extends Connections {
    public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
 }
    public function deleteLog() {
    
        $delete_id = $_POST['deletelog'];
        [$login,$search_login] = explode('_',$delete_id);
    
        $delete_id_sql = 'SELECT table_name FROM information_schema.tables
    WHERE table_schema = "chat" AND table_name = "'.$delete_id.'"';
        $delete_id_query = mysqli_query($this->conn, $delete_id_sql);
        $delete_assoc = mysqli_fetch_assoc($delete_id_query);
    
        if($delete_assoc && $delete_assoc['table_name'] == $delete_id) {
    
        $dia_sql1 = 'SELECT dialogs FROM users WHERE login = "'.$login.'"';
        $dia_query1 = mysqli_query($this->conn2, $dia_sql1);
        $dia_assoc1 = mysqli_fetch_assoc($dia_query1);
        $dia_string1 = $dia_assoc1['dialogs'];
        $dia_sql2 = 'SELECT dialogs FROM users WHERE login = "'.$search_login.'"';
        $dia_query2 = mysqli_query($this->conn2, $dia_sql2);
        $dia_assoc2 = mysqli_fetch_assoc($dia_query2);
        $dia_string2 = $dia_assoc2['dialogs'];
        
        $pattern = "/,/";
        $dia_array1 = preg_split($pattern, $dia_string1);
        $dia_array2 = preg_split($pattern, $dia_string2);
        if (($key1 = array_search($delete_id, $dia_array1)) !== false && ($key2 = array_search($delete_id, $dia_array2)) !== false) {
        unset($dia_array1[$key1]);
        unset($dia_array2[$key2]);
        $dia_new_string1 = implode(',', $dia_array1); 
        $dia_new_string2 = implode(',', $dia_array2);
        $dia_new_sql1 = 'UPDATE users SET dialogs = "'.$dia_new_string1.'" WHERE login = "'.$login.'"';
        $dia_new_query1 = mysqli_query($this->conn2, $dia_new_sql1);
        $dia_new_sql2 = 'UPDATE users SET dialogs = "'.$dia_new_string2.'" WHERE login = "'.$search_login.'"';
        $dia_new_query2 = mysqli_query($this->conn2, $dia_new_sql2);
        $dia_drop_sql = 'DROP TABLE '.$delete_id.'';
        $dia_drop_query = mysqli_query($this->conn, $dia_drop_sql);
        echo 'Диалог удален';
    }
    } 
    }
}

?>