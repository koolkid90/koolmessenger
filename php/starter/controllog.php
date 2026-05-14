<?
require_once('starter/startchatlog.php');
require_once('starter/startuserslog.php');
class ChatLogControl extends startChatLog {
function startChatLogging() {
    startChatLog();
}
}
class UsersLogControl extends startUsersLog {
function startChatLogging() {
    startUsersLog();
}
}

?>