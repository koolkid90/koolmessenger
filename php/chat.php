<?php

class chat {
    
    public function __construct($conn = null, $conn2 = null) {
        require_once("cipher.php");
        $this->conn = $conn;
        $this->conn2 = $conn2;

        //переменные шифрования
        $this->iv = $iv;
        $this->password = $password;
        $this->method = $method; 
        
    
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
            if ($row['Tables_in_chat'] = $actual_realtime_dialog) {
                $actual_sql = 'SELECT * FROM '.$actual_realtime_dialog.'';
                 $actual_realtime_dialog_result = mysqli_query($this->conn, $actual_sql); 
                  
             
            } else if ($row['Tables_in_chat'] = $reverse_dia) {
                $actual_sql = 'SELECT * FROM '.$reverse_dia.'';
                $actual_realtime_dialog_result = mysqli_query($this->conn, $actual_sql); 
                
                
            }
        }
        
    
    if (!empty($actual_realtime_dialog_result)){
    echo '<div id="letters">';
     
            
            
            
            foreach($actual_realtime_dialog_result as $actual_row) {
                // переменная расшифровки
            $decrypted = openssl_decrypt(base64_decode($actual_row['message']), $this->method, $this->password, OPENSSL_RAW_DATA, $this->iv);	
                if ($actual_row['login'] == $login) {
            
            

            echo '<div id="full_message_block"><div id="mess_block_user"><div id="message_id">'.$actual_row['id'].'</div>
            <div id="message_dialog_id">'.$actual_realtime_dialog.'</div>
            <div id="login_block">'.$actual_row['login'].':</div><br><div id="user_block">'
            .$decrypted.'</div></div>
            <button id="deleteButtonMessage" onclick="deleteButtonMessage(this)">Удалить</button><div id="message_date_block">'.$actual_row['date'].'</div></div><br><br>';
                } else if ($actual_row['login'] !== $login && $actual_row['login'] !== 'Новый диалог') {
        
                    echo '<div id="full_message_block"><div id="mess_block_friend"><div id="message_id">'.$actual_row['id'].'</div>
                    <div id="message_dialog_id">'.$actual_realtime_dialog.'</div>
                    <div id="login_block">'
                    .$actual_row['login'].':</div><br><div id="friend_block">'.$decrypted.'</div></div>
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
    
    
    
    
    public function messageData() {
        
        $message_data = json_decode($_POST['message_data']);
        $plaintext = $message_data[0];
        $login = $message_data[1];
        $date = $message_data[2];
        $dia_id = $message_data[3];

        


$encrypted = base64_encode(openssl_encrypt($plaintext, $this->method, $this->password, OPENSSL_RAW_DATA, $this->iv));
        
        $messdata_sql = 'INSERT INTO '.$dia_id.' (login, message, date) VALUES ("'.$login.'" ,"'.$encrypted.'" , "'.$date.'")';
        $messdata_sql_result = mysqli_query($this->conn, $messdata_sql); 
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
            if ($row['Tables_in_chat'] = $dia_id) {
                $refresh_letter = 'SELECT * FROM '.$dia_id.'';
                $refresh_letter_result = mysqli_query($this->conn, $refresh_letter);
                $succeful_connect=true;
             
            } else if ($row['Tables_in_chat'] = $reverse_dia) {
                $refresh_letter = 'SELECT * FROM '.$reverse_dia.'';
                $refresh_letter_result = mysqli_query($conn, $refresh_letter);
                $succeful_connect=true;
            }
        }
        
    
    
        
        
        if ($succeful_connect=true & !empty($refresh_letter_result)) {
        
        echo '<div id="letters">';
        
                  
            foreach($refresh_letter_result as $refresh_row) {	

            $decrypted = openssl_decrypt(base64_decode($refresh_row['message']), $this->method, $this->password, OPENSSL_RAW_DATA, $this->iv); 
            
                if ($refresh_row['login'] == $login) {
                  
            echo '<div id="full_message_block"><div id="mess_block_user"><div id="message_id">'.$refresh_row['id'].'</div>
            <div id="message_dialog_id">'.$dia_id.'</div><div id="login_block">'.$refresh_row['login'].':</div><br><div id="user_block">'.$decrypted.'</div></div>
            <button id="deleteButtonMessage" onclick="deleteButtonMessage(this)">Удалить</button><div id="message_date_block">'.$refresh_row['date'].'</div></div>
            <br><br>';
                } else {
                    

                    echo '<div id="full_message_block"><div id="mess_block_friend"><div id="message_id">'.$refresh_row['id'].'</div>
                    <div id="message_dialog_id">'.$dia_id.'</div>
                    <div id="login_block">'
                    .$refresh_row['login'].':</div><br><div id="friend_block">'.$decrypted.'</div></div>
                    <button id="deleteButtonMessage" onclick="deleteButtonMessage(this)">Удалить</button><div id="message_date_block">'.$refresh_row['date'].'</div></div><br><br>';
        
            }
        
        }
        echo '</div>';
        
    } 
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
    
    public function deleteMessageLog() {
        $delete_log = $_POST['delete_message_log'];
        [$dia_id,$message_id] = explode('/',$delete_log);
        $delete_sql = 'DELETE FROM '.$dia_id.' WHERE id = "'.$message_id.'"';
        $delete_query = mysqli_query($this->conn, $delete_sql);
        echo 'Сообщение удалено';
    }
    }
    ?>