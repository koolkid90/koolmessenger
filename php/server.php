
<?php

date_default_timezone_set('UTC');

require_once('server/csrf.php');
require_once('chat.php');
require_once('server/logging.php');
require_once('server/registration.php');
require_once('server/starter_class.php');
require_once('server/searching.php');

$CSRF = new CSRFTokens();
$starter = new Starter();
$logging = new Logging();
$chatting = new chat();
$search = new Searching();
$registration = new Registration();


// CSRF
if (isset($_POST['csrf_token'])) {
	$CSRF->checkCSRF();
}
// START SERVER
if (isset($_POST['startChatLog'])) {
$starter->startChatLog();
}

if (isset($_POST['startUsersLog'])) {
$starter->startUsersLog();
}

if (isset($_POST['checkServer'])) {
$starter->checkServer();
}
if (isset($_POST['startServer'])) {
	echo 'Сервер запущен';
}

// LOGGING
if (isset($_POST['passLog'])) {
$logging->UserLogging();
}

if (isset($_POST['favourLog'])) {
$logging->FavourLogging();
}

// CHAT

if (isset($_POST['messcheck'])) {
$chatting->messCheckCHAT();
}
if (isset($_POST['message_data'])) {
$chatting->messageDataCHAT();
}
if (isset($_POST['dia_id'])) {
$chatting->diaIDCHAT();
}
if (isset($_POST['deletelog'])) {
$chatting->deleteLogCHAT();
}
if (isset($_POST['delete_message_log'])) {
$chatting->deleteMessageLogCHAT();
}

// SEARCHING 

if (isset($_POST['searchlog'])) {
$search->searchLogBefore();
}
if (isset($_POST['searchanswer'])) {
$search->searchAnswerBefore();
}
// REFISTRATION
if (isset($_POST['reg_data'])) {
$registration->Registration();
}

?>