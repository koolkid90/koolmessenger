
<?
class passLog{

    public function __construct($conn = null, $conn2 = null) {
        require_once("cipher.php");
        $this->conn = $conn;
        $this->conn2 = $conn2;
        $this->iv = $iv;
        $this->password = $password;
        $this->method = $method; 
        
        
        }
public function passLog() {
    global $login;
    $userform = $_POST['passLog'];
    
    $login = strstr($userform, '/', true);
    $password = trim(strstr($userform, '/'), '/');
    
        
    $log_result = mysqli_query($this->conn2, 'SELECT login, password, dialogs FROM users');    
        
    foreach($log_result as $row1){
    if ($row1['login'] == $login && $row1['password'] == $password) {
            
    $all_dialogs = explode(',', $row1['dialogs']);
            
            
           
    if (empty($all_dialogs[0])) {
    echo '<div id="empty_block">У вас нет диалогов, воспользуйтесь поиском</div>';
    } else {
    for ($i = 0; $i < count($all_dialogs); $i++) {
        
    $actual_dialog = 'SELECT * FROM '.$all_dialogs[$i].' ORDER BY id DESC LIMIT 1 ';

    $actual_dialog_result = mysqli_query($this->conn, $actual_dialog);

    global $full_dia_with;

    global $post_log_1;

    global $post_log_2;

    [$post_log_1,$post_log_2] = explode('_',$all_dialogs[$i]);  

    if ($post_log_1 == $login) {

    $full_dia_with = $post_log_2;

    } else if ($post_log_2 == $login) {

    $full_dia_with = $post_log_1;

    }

    foreach($actual_dialog_result as $row2){  

    $decrypted = openssl_decrypt(base64_decode($row2['message']), $this->method, $this->password, OPENSSL_RAW_DATA, $this->iv);	
    
    if ($row2['id'] == '1') {

    echo '<div id="dialog_object"><div id="dialogs_block" onclick="dialogsBlockClick(this)"><div id="dialogs_id">'.$all_dialogs[$i].'</div><div id="dialogs_login">'.$full_dia_with.'</div><br><br>

    <div id="dialogs_message">Нет сообщений</div></div><div id="date_block">'.$row2['date'].'</div><button id="deletebutton" onclick="deleteButton(this)">Удалить</button></div><br><br>';

    } else {

    echo '<div id="dialog_object"><div id="dialogs_block" onclick="dialogsBlockClick(this)"><div id="dialogs_id">'.$all_dialogs[$i].'</div><div id="dialogs_login">'.$full_dia_with.'</div><br><br><div id="dialogs_message">
    
    '.$decrypted.'</div></div><div id="date_block">'.$row2['date'].'</div><button id="deletebutton" onclick="deleteButton(this)">Удалить</button></div><br><br>';
        }
           
    }
    }
    }
    
        } 
        }
        }
    }

?>