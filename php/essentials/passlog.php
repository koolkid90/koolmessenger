<?php
require_once('./settings/connections.php');
class passLog extends Connections {

    
    public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
        
    
}
public function passLog() {
    try {
    $login;
    $userform = $_POST['passLog'];
    $login = htmlspecialchars(strstr($userform, '/', true));
    $password = htmlspecialchars(trim(strstr($userform, '/'), '/'));
    
    $sql = 'SELECT login, password, dialogs FROM users WHERE login = :login LIMIT 1';
    $log_result = $this->conn2->prepare($sql);
    $log_result->execute([':login' => $login]);
        
    
    foreach($log_result as $row1){
    if ($row1['login'] == $login && password_verify($password, $row1['password'])) {
            
    $all_dialogs = explode(',', $row1['dialogs']);
            
    if (empty($all_dialogs[0])) {
    echo '<div id="empty_block">У вас нет диалогов, воспользуйтесь поиском</div>';
    } else {
    for ($i = 0; $i < count($all_dialogs); $i++) {
    $actual_dialog = 'SELECT * FROM '.$all_dialogs[$i].' ORDER BY id DESC LIMIT 1 ';
    $actual_dialog_result = $this->conn->query($actual_dialog);
    $full_dia_with;
    $post_log_1;
    $post_log_2;
    [$post_log_1,$post_log_2] = explode('_',$all_dialogs[$i]);  
    if ($post_log_1 == $login) {
    $full_dia_with = $post_log_2;
    } else if ($post_log_2 == $login) {
    $full_dia_with = $post_log_1;
    }
    foreach($actual_dialog_result as $row2){  

    if (strpos($all_dialogs[$i],"Favourites" )) {
    echo '<div id="dialog_object">
    <div id="favourites_block" onclick="dialogsBlockClick(this)">
    <div id="dialogs_id">'.$all_dialogs[$i].'</div>
    <div id="favourites_login">'.$full_dia_with.'</div>
    <br><br>
    <div id="dialogs_message">'.$row2['message'].'</div></div>
    <div id="date_block">'.$row2['date'].'
    </div>
    </div><br><br>';
    }

     else if ($row2['id'] == '1') {
    echo '<div id="dialog_object">
    <div id="dialogs_block" onclick="dialogsBlockClick(this)">
    <div id="dialogs_id">'.$all_dialogs[$i].'</div>
    <div id="dialogs_login">'.$full_dia_with.'</div><br><br>
    <div id="dialogs_message">Нет сообщений</div></div>
    <div id="date_block">'.$row2['date'].'</div>
    <button id="deletebutton" onclick="deleteButton(this)">Удалить</button></div><br><br>';

    } else {
    echo '<div id="dialog_object">
    <div id="dialogs_block" onclick="dialogsBlockClick(this)">
    <div id="dialogs_id">'.$all_dialogs[$i].'</div>
    <div id="dialogs_login">'.$full_dia_with.'</div><br><br>
    <div id="dialogs_message">'.$row2['message'].'</div></div>
    <div id="date_block">'.$row2['date'].'</div>
    <button id="deletebutton" onclick="deleteButton(this)">Удалить</button></div>
    <br><br>';
        }
           
    }
    }
    }
    
} 
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