<?php
require_once('./connections.php');
class IDDia extends Connections {
    
public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
 }
    public function diaID() {
    
        $dialog_id = $_POST['dia_id'];
        $dia_id = strstr($dialog_id, '/', true);
        $login = trim(strstr($dialog_id, '/'), '/');
        
        $reverse_1part = strstr($dia_id, '_', true);
        $reverse_2part = trim(strstr($dia_id, '_'), '_');
        $reverse_dia = $reverse_2part.'_'.$reverse_1part;
        
        $searcher_sql = 'SHOW TABLES';
        $searcher_result = mysqli_query($this->conn, $searcher_sql);
        global $refresh_letter;
        global $refresh_letter_result;
        foreach ($searcher_result as $row) {
        if ($row['Tables_in_chat'] == $dia_id) {
            $refresh_letter = 'SELECT * FROM '.$dia_id.'';
            $refresh_letter_result = mysqli_query($this->conn, $refresh_letter);
            $succeful_connect=true;
             
        } else if ($row['Tables_in_chat'] == $reverse_dia) {
            $refresh_letter = 'SELECT * FROM '.$reverse_dia.'';
            $refresh_letter_result = mysqli_query($this->conn, $refresh_letter);
            $succeful_connect=true;
            }
        }
        

if ($succeful_connect==true & !empty($refresh_letter_result)) {
        
        echo '<div id="letters">';
        
                  
        foreach($refresh_letter_result as $refresh_row) {	
            
        if ($refresh_row['login'] == $login) {
                  
        echo '<div id="full_message_block"><div id="mess_block_user"><div id="message_id">'.$refresh_row['id'].'</div>
        <div id="message_dialog_id">'.$dia_id.'</div><div id="login_block">'.$refresh_row['login'].':</div><br><div id="user_block">'.$refresh_row['message'].'</div></div>
        <button id="deleteButtonMessage" onclick="deleteButtonMessage(this)">Удалить</button><div id="message_date_block">'.$refresh_row['date'].'</div></div>
        <br><br>';
        } else {
                    
        echo '<div id="full_message_block"><div id="mess_block_friend"><div id="message_id">'.$refresh_row['id'].'</div>
        <div id="message_dialog_id">'.$dia_id.'</div>
        <div id="login_block">'
        .$refresh_row['login'].':</div><br><div id="friend_block">'.$refresh_row['message'].'</div></div>
        <button id="deleteButtonMessage" onclick="deleteButtonMessage(this)">Удалить</button><div id="message_date_block">'.$refresh_row['date'].'</div></div><br><br>';
        
            }
        
        }
        echo '</div>';
        
    } 
}
}
?>