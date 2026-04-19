<?php
require_once('./connections.php');
class CheckMessage extends Connections {
 public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
 }
public function messCheck() {
    $messcheck = $_POST['messcheck'];
    global $searcher_result;
    global $actual_realtime_dialog;
    global $actual_sql;
    global $reverse_dia;
    global $actual_realtime_dialog_result;
    
    $login = strstr($messcheck, '/', true);
    
    $actual_realtime_dialog = trim(strstr($messcheck, '/'), '/');
    $reverse_1part = strstr($actual_realtime_dialog, '_', true);
    $reverse_2part = trim(strstr($actual_realtime_dialog, '_'), '_');
    $reverse_dia = $reverse_2part.'_'.$reverse_1part;
    
    
    $searcher_sql = 'SHOW TABLES';
    $searcher_result = mysqli_query($this->conn, $searcher_sql);
        
    // подключаемся к базе данных 2
    foreach ($searcher_result as $row) {
        if ($row['Tables_in_chat'] == $actual_realtime_dialog) {
        $actual_sql = 'SELECT * FROM '.$actual_realtime_dialog.'';
         $actual_realtime_dialog_result = mysqli_query($this->conn, $actual_sql); 
                  
             
    } else if ($row['Tables_in_chat'] == $reverse_dia) {
        $actual_sql = 'SELECT * FROM '.$reverse_dia.'';
        $actual_realtime_dialog_result = mysqli_query($this->conn, $actual_sql); 
                
                
        }
    }
        
    
    if (!empty($actual_realtime_dialog_result)){
    echo '<div id="letters">';
     
    foreach($actual_realtime_dialog_result as $actual_row) {
   
        if ($actual_row['login'] == $login) {   

        echo '<div id="full_message_block"><div id="mess_block_user"><div id="message_id">'.$actual_row['id'].'</div>
        <div id="message_dialog_id">'.$actual_realtime_dialog.'</div>
        <div id="login_block">'.$actual_row['login'].':</div><br><div id="user_block">'.
        $actual_row['message'].'</div></div>
        <button id="deleteButtonMessage" onclick="deleteButtonMessage(this)">Удалить</button><div id="message_date_block">'.$actual_row['date'].'</div></div><br><br>';
            } else if ($actual_row['login'] !== $login && $actual_row['login'] !== 'Новый диалог') {
        
        echo '<div id="full_message_block"><div id="mess_block_friend"><div id="message_id">'.$actual_row['id'].'</div>
        <div id="message_dialog_id">'.$actual_realtime_dialog.'</div>
        <div id="login_block">'
        .$actual_row['login'].':</div><br><div id="friend_block">'.$actual_row['message'].'</div></div>
        <button id="deleteButtonMessage" onclick="deleteButtonMessage(this)">Удалить</button><div id="message_date_block">'.$actual_row['date'].'</div></div><br><br>';
        
        } else {
        echo '<div id="full_message_block"><div id="mess_block_friend"><div id="message_id">'.$actual_row['id'].'</div>
            <div id="message_dialog_id">'.$actual_realtime_dialog.'</div>
            <div id="login_block">'
            .$actual_row['login'].':</div><br><div id="friend_block">'."Новый диалог".'</div></div>
            <button id="deleteButtonMessage" onclick="deleteButtonMessage(this)">Удалить</button><div id="message_date_block">'.$actual_row['date'].'</div></div><br><br>';
            }
        echo '</div>';
        }
    
        
    
    }
    }
}
?>