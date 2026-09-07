<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['csrf_token'];
?>
<input type="hidden" id="csrf_token" value="<?php echo $token; ?>">

<!-- Форма входа -->
<div id="userform">
    <div id="base_loading"></div>
    <input type="text" id="login" placeholder="Логин">
    <input type="password" id="password" placeholder="Пароль">
    <button id="logbutton">Войти</button>
    <button id="regbutton">Регистрация</button>
</div>

<!-- Основное окно чата -->
<div id="common_window">
    <div class="chat-header">
        <button id="exitbutton">Выход</button>
        <button id="backbutton" style="display:none">Назад</button>
        <button id="searchbutton">Поиск</button>
    </div>
    <div id="dialogs_window"></div>
    <div id="messages" style="display:none"></div>
    <div id="keyboard" style="display:none">
        <textarea id="textarea" placeholder="Введите сообщение..."></textarea>
        <button id="sendbutton">➜</button>
    </div>
</div>

<!-- Окно поиска -->
<div id="searchform" style="display:none">
    <input type="text" id="searcharea" placeholder="Введите логин для поиска">
    <button id="findbutton">Искать</button>
    <div id="searchmatches"></div>
    <button id="search_back_button">Назад</button>
</div>

<!-- Окно регистрации -->
<div id="regform" style="display:none">
    <div id="text_reg_form">
        <h5>Придумайте логин:</h5>
        <input type="text" id="reg_login" value="Логин">
        <h5>Придумайте пароль:</h5>
        <input type="password" id="reg_password" value="Пароль">
        <h5>Повторите пароль:</h5>
        <input type="password" id="reg_password_repeat" value="Пароль">
        <button id="goregbutton">Регистрация</button>
        <button id="regbackbutton">Назад</button>
    </div>
</div>

<!-- Скрытые поля -->
<input type="hidden" id="post_login">
<input type="hidden" id="diags_id">
<input type="hidden" id="send_check">
<input type="hidden" id="dia_names">

<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>