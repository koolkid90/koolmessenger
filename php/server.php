
<?php

date_default_timezone_set('Europe/Moscow');
setlocale(LC_ALL, 'ru_RU.UTF-8');

require_once('server/csrf.php'); // класс защиты от CSRF
require_once('server/chatting.php'); // класс логики чата
require_once('server/logging.php'); // класс входа в мессенджер
require_once('server/registration.php'); // класс регистрации
require_once('server/starter_class.php'); // класс инициализации бд
require_once('server/searching.php'); // класс поиска

$CSRF = new CSRFTokens();
$starter = new Starter();
$logging = new Logging();
$chatting = new Chatting();
$search = new Searching();
$registration = new Registration();



// START SERVER
if (isset($_POST['startChatLog'])) {
$starter->startChatLog();              //  проверка базы данных 1, если ее нет, то создается
}

if (isset($_POST['startUsersLog'])) {
$starter->startUsersLog();            // проверка базы данны 2, если ее нет, то создается
}

if (isset($_POST['checkServer'])) {
$starter->checkServer();            // проверка соединения, если ок
}
if (isset($_POST['startServer'])) {
	echo 'Сервер запущен';           // то выводим 
}

// LOGGING
if (isset($_POST['passLog'])) {
$logging->UserLogging();         // проверка имени и пароля
}

if (isset($_POST['favourLog'])) {
$logging->FavourLogging();
}

// CSRF
if (isset($_POST['csrf_token'])) {
	$CSRF->checkCSRF();                 // проверка CSRF при входе
}
// CHAT

if (isset($_POST['messcheck'])) {
$chatting->messCheckBefore();
}
if (isset($_POST['message_data'])) {
$chatting->messDataBefore();
}
if (isset($_POST['dia_id'])) {
$chatting->diaIDBefore();
}
if (isset($_POST['deletelog'])) {
$chatting->deleteLogBefore();
}
if (isset($_POST['delete_message_log'])) {
$chatting->deleteMessageLogBefore();
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