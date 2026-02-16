<<<<<<< HEAD
<?php


// переменнные шифрования

// iv 
$iv = chr(0x1) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
// пароль, который перемешивается алгоритмом SHA-256
$password = substr(hash('sha256', '3sc3RLrpd17', true), 0, 32);
// алгоритм шифрования
$method = 'aes-256-cbc';

?>