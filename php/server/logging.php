<?
require_once('./settings/connections.php');
require_once('./essentials/passlog.php');
require_once('./essentials/favour.php');
class Logging {
public function __construct($chat_connection = null, $users_connection = null) {
        
        $this->conn = $chat_connection;
        $this->conn2 = $users_connection;
        
    
}
public function UserLogging() {
	
	
    $passLog = new passLog ($this->conn, $this->conn2);
	$passLog->passLog();
}

public function FavourLogging() {

	
    $classFavour = new classFavour ($this->conn, $this->conn2);
	$classFavour->createFavour();
	
}
}



?>