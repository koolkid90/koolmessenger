<?
require_once('.\chat.php');

class Chatting extends chat {


public function messCheckBefore() {

	parent::messCheck();
}
public function messDataBefore() {

	parent::messageData();
}
public function diaIDBefore() {

	parent::diaID();
}
public function deleteLOgBefore() {

	parent::deleteLog();
}
public function deleteMessageLogBefore() {

	parent::deleteMessageLog();
}
}

?>