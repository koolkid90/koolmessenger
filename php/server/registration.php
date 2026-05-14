<?
require_once('./connections.php');
require_once('regdata.php');
class Registration extends Connections {
public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
        
    
}

    public function Registration() {

	$regdata = new regData($this->conn, $this->conn2);
	$regdata->regData();
    
}
}


?>