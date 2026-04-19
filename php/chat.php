
<?php
require_once('connections.php');
require_once('chat/checkmessage.php');
require_once('chat/datamessage.php');
require_once('chat/iddia.php');
require_once('chat/logdelete.php');
require_once('chat/deletemessage.php');

class chat extends Connections  {
 
 public function __construct($chat_connection = null, $users_connection = null) {
        parent::__construct($this->chat_connection, $this->users_connection);
        $this->conn = $this->chat_connection;
        $this->conn2 = $this->users_connection;
        $this->checkmessage = new CheckMessage;
        $this->dataMessage = new DataMessage;
        $this->iddia = new IDDia;
        $this->logdelete = new LogDelete;
        $this->deletemessage = new DeleteMessage;
        
    
}

    
function messCheckCHAT() {
  $this->checkmessage->messCheck();
}  
function messageDataCHAT() {
  $this->dataMessage->messageData();
}  
function diaIDCHAT() {
  $this->iddia->diaid();
}

function deleteLogCHAT() {
  $this->logdelete->deleteLog();
}
function deleteMessageLogCHAT() {
  $this->deletemessage->deleteMessageLog();
}
}
    

?>