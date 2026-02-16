<?php
 // база данных с сообщениями
 // база данных с пользователями
date_default_timezone_set('UTC');

// STARTER

if (isset($_POST['startChatLog'])) {
	require_once('starter.php');
    $serverstarter = new serverStarter();
	$serverstarter->startChatLog();
}
if (isset($_POST['startUsersLog'])) {
	require_once('starter.php');
    $serverstarter = new serverStarter();
	$serverstarter->startUsersLog();
}

function startServer() { // проверяем существования базы чат и юзер_инфо, если они есть возвращаем false
	
		
		$conn_fullsql = new mysqli("localhost", "root", "");
		if($conn_fullsql == null) {
			echo 'Ошибка подключения к SQL';
		}
		
			$show_sql1 = 'SHOW DATABASES LIKE "chat"';
			$show_sql_result1 = mysqli_query($conn_fullsql, $show_sql1); 
			$show_sql_assoc1 = mysqli_fetch_assoc($show_sql_result1);
	
			$show_sql2 = 'SHOW DATABASES LIKE "users_info"';
			$show_sql_result2 = mysqli_query($conn_fullsql, $show_sql2); 
			$show_sql_assoc2 = mysqli_fetch_assoc($show_sql_result2);

			function fullCheck($show_sql_assoc1, $show_sql_assoc2) {
			if ($show_sql_assoc1 == null && $show_sql_assoc2 == null) {
				
				return false;
			} else {
				return true;
			}
		}
		
		$server_conn = fullCheck($show_sql_assoc1, $show_sql_assoc2);
			
			if($server_conn == true) {
				
	            return true;
			} else {
				return false;
			}
		
		
	}

if (isset($_POST['checkServer'])) {
$serverCheck = startServer(); 
if ($serverCheck == true) {
	echo 'ok';
} else {
	echo 'error';
}

}

if (isset($_POST['startServer'])) {
	echo 'Сервер запущен';
	}

// PASSLOG

if (isset($_POST['passLog'])) {
	$chat_connection = new mysqli("localhost", "root", "", "chat");
	$users_connection = new mysqli("localhost","root", "", "users_info");
	require_once('passlog.php');
    $passLog = new passLog ($chat_connection, $users_connection);
	$passLog->passLog();
}


// CHAT

if (isset($_POST['messcheck'])) {
	$chat_connection = new mysqli("localhost", "root", "", "chat");
	$users_connection = new mysqli("localhost","root", "", "users_info");
	require_once('chat.php');
	$chat = new chat($chat_connection, $users_connection);
	$chat->messCheck();
}
if (isset($_POST['message_data'])) {
	$chat_connection = new mysqli("localhost", "root", "", "chat");
	$users_connection = new mysqli("localhost","root", "", "users_info");
	require_once('chat.php');
	$chat = new chat($chat_connection, $users_connection);
	$chat->messageData();
}
if (isset($_POST['dia_id'])) {
	$chat_connection = new mysqli("localhost", "root", "", "chat");
	$users_connection = new mysqli("localhost","root", "", "users_info");
	require_once('chat.php');
	$chat = new chat($chat_connection, $users_connection);
	$chat->diaID();
}
if (isset($_POST['deletelog'])) {
	$chat_connection = new mysqli("localhost", "root", "", "chat");
	$users_connection = new mysqli("localhost","root", "", "users_info");
	require_once('chat.php');
	$chat = new chat($chat_connection, $users_connection);
	$chat->deleteLog();
}
if (isset($_POST['delete_message_log'])) {
	$chat_connection = new mysqli("localhost", "root", "", "chat");
	$users_connection = new mysqli("localhost","root", "", "users_info");
	require_once('chat.php');
	$chat = new chat($chat_connection, $users_connection);
	$chat->deleteMessageLog();
}


// SEARCH

if (isset($_POST['searchlog'])) {
	$chat_connection = new mysqli("localhost", "root", "", "chat");
	$users_connection = new mysqli("localhost","root", "", "users_info");
	require_once('search.php');
	$search = new search($chat_connection, $users_connection);
	$search->searchLog();
}

if (isset($_POST['searchanswer'])) {
	$chat_connection = new mysqli("localhost", "root", "", "chat");
	$users_connection = new mysqli("localhost","root", "", "users_info");
	require_once('search.php');
	$search = new search($chat_connection, $users_connection);
	$search->searchAnswer();
}


// REGDATA 

if (isset($_POST['reg_data'])) {
	$chat_connection = new mysqli("localhost", "root", "", "chat");
	$users_connection = new mysqli("localhost","root", "", "users_info");
	require_once('regdata.php');
	$regdata = new regData($chat_connection, $users_connection);
	$regdata->regData();
}

?>