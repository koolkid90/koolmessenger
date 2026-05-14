<?
require_once('search.php');
require_once('./connections.php');
class Searching extends Connections {
 public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
        
    
}
public function searchLogBefore() {
	
	$search = new search($this->conn, $this->conn2);
	$search->searchLog();
}

public function searchAnswerBefore() {

	$search = new search($this->conn, $this->conn2);
	$search->searchAnswer();
}

}

?>