// ============================================
// КРАСИВЫЕ КАСТОМНЫЕ УВЕДОМЛЕНИЯ
// ============================================

window.customAlert = function(options) {
    return new Promise((resolve) => {
        // Параметры по умолчанию
        const config = {
            title: options.title || 'Уведомление',
            message: options.message || '',
            type: options.type || 'info', // info, success, warning, error, question
            confirmText: options.confirmText || 'OK',
            cancelText: options.cancelText || 'Отмена',
            showCancel: options.showCancel || false,
            onConfirm: options.onConfirm || null,
            onCancel: options.onCancel || null
        };
        
        // Иконки для типов
        const icons = {
            info: 'ℹ️',
            success: '✅',
            warning: '⚠️',
            error: '❌',
            question: '❓'
        };
        
        // Создаём HTML
        const overlay = document.createElement('div');
        overlay.className = 'custom-alert-overlay';
        
        const alertBox = document.createElement('div');
        alertBox.className = 'custom-alert';
        
        alertBox.innerHTML = `
            <div class="custom-alert-header">
                <div class="custom-alert-icon ${config.type}">
                    ${icons[config.type]}
                </div>
            </div>
            <div class="custom-alert-content">
                <div class="custom-alert-title">${escapeHtml(config.title)}</div>
                <div class="custom-alert-message">${escapeHtml(config.message)}</div>
            </div>
            <div class="custom-alert-buttons">
                ${config.showCancel ? 
                    `<button class="custom-alert-btn cancel" data-action="cancel">${escapeHtml(config.cancelText)}</button>
                     <button class="custom-alert-btn confirm" data-action="confirm">${escapeHtml(config.confirmText)}</button>` :
                    `<button class="custom-alert-btn ok" data-action="ok">${escapeHtml(config.confirmText)}</button>`
                }
            </div>
        `;
        
        overlay.appendChild(alertBox);
        document.body.appendChild(overlay);
        
        // Обработчики кнопок
        const buttons = alertBox.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const action = btn.getAttribute('data-action');
                overlay.remove();
                
                if (action === 'confirm' && config.onConfirm) {
                    config.onConfirm();
                    resolve(true);
                } else if (action === 'cancel' && config.onCancel) {
                    config.onCancel();
                    resolve(false);
                } else {
                    resolve(true);
                }
            });
        });
        
        // Клик по оверлею
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.remove();
                resolve(false);
            }
        });
    });
};

// Функция экранирования HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Переопределяем стандартный alert
window.alert = function(message, title = 'Уведомление', type = 'info') {
    return customAlert({
        title: title,
        message: message,
        type: type,
        confirmText: 'OK',
        showCancel: false
    });
};

// ============================================
// КРАСИВЫЙ КАСТОМНЫЙ CONFIRM
// ============================================

window.customConfirm = function(options) {
    return new Promise((resolve) => {
        // Параметры по умолчанию
        const config = {
            title: options.title || 'Подтверждение',
            message: options.message || 'Вы уверены?',
            confirmText: options.confirmText || 'Да',
            cancelText: options.cancelText || 'Нет',
            type: options.type || 'question',
            confirmColor: options.confirmColor || '#22c55e',
            cancelColor: options.cancelColor || '#ef4444'
        };
        
        // Создаём HTML
        const overlay = document.createElement('div');
        overlay.className = 'custom-confirm-overlay';
        
        const confirmBox = document.createElement('div');
        confirmBox.className = 'custom-confirm';
        
        confirmBox.innerHTML = `
            <div class="custom-confirm-icon ${config.type}">
                ${getIcon(config.type)}
            </div>
            <div class="custom-confirm-title">${escapeHtml(config.title)}</div>
            <div class="custom-confirm-message">${escapeHtml(config.message)}</div>
            <div class="custom-confirm-buttons">
                <button class="custom-confirm-btn cancel" style="border-color: ${config.cancelColor}; color: ${config.cancelColor}">
                    ${escapeHtml(config.cancelText)}
                </button>
                <button class="custom-confirm-btn confirm" style="background: ${config.confirmColor}">
                    ${escapeHtml(config.confirmText)}
                </button>
            </div>
        `;
        
        overlay.appendChild(confirmBox);
        document.body.appendChild(overlay);
        
        // Анимация появления
        setTimeout(() => overlay.classList.add('show'), 10);
        
        // Обработчики кнопок
        const confirmBtn = confirmBox.querySelector('.confirm');
        const cancelBtn = confirmBox.querySelector('.cancel');
        
        confirmBtn.addEventListener('click', () => {
            overlay.classList.remove('show');
            setTimeout(() => {
                overlay.remove();
                resolve(true);
            }, 200);
        });
        
        cancelBtn.addEventListener('click', () => {
            overlay.classList.remove('show');
            setTimeout(() => {
                overlay.remove();
                resolve(false);
            }, 200);
        });
        
        // Клик по оверлею
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('show');
                setTimeout(() => {
                    overlay.remove();
                    resolve(false);
                }, 200);
            }
        });
        
        // Кнопка Escape
        const handleEsc = (e) => {
            if (e.key === 'Escape') {
                overlay.classList.remove('show');
                setTimeout(() => {
                    overlay.remove();
                    resolve(false);
                    document.removeEventListener('keydown', handleEsc);
                }, 200);
            }
        };
        document.addEventListener('keydown', handleEsc);
    });
};

// Иконки для разных типов
function getIcon(type) {
    const icons = {
        question: '❓',
        warning: '⚠️',
        danger: '🔴',
        info: 'ℹ️',
        success: '✅'
    };
    return icons[type] || icons.question;
}

// Функция экранирования HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var message_interval;
var refreshSpeed = 2000;

$(document).ready(function() {
    // Начальное состояние
    $("#userform").show();
    $("#common_window").hide();
    $("#keyboard").hide();
    $("#messages").hide();
    $("#dialogs_window").hide();
    $("#searchform").hide();
    $("#regform").hide();
    $("#base_loading").hide();
    $("#login, #password, #logbutton, #regbutton").hide();
    $('body, html').css({ 'overflow': 'hidden', 'height': '100%' });
    
    // Проверка сервера
    $.ajax({
        type: 'post',
        url: 'php/server.php',
        data: { startChatLog: 'check'},
        success: function(data){
            $("#base_loading").show().append(data.trim() + '<br>');
            $.ajax({
                type: 'post',
                url: 'php/server.php',
                data: { startUsersLog: 'check'},
                success: function(data){
                    $("#base_loading").append(data.trim() + '<br>');
                    $.ajax({
                        type: 'post',
                        url: 'php/server.php',
                        data: { checkServer: 'check'},
                        success: function(data){
                            if(data.trim() == 'ok') {
                                $.ajax({
                                    type: 'post',
                                    url: 'php/server.php',
                                    data: { startServer: 'check'},
                                    success: function(data){
                                        $("#base_loading").append(data.trim() + '<br>');
                                        $("#login, #password, #logbutton, #regbutton").show();
                                        $("#base_loading").hide();
                                    }
                                });
                            } else {
                                $("#base_loading").text('Ошибка подключения');
                            }
                        }
                    });
                }
            });
        }
    });
});

// Очистка полей
$("#login, #password").on('click', function() { $(this).val(''); });

// Логин
$('#logbutton').click(function() {
    let log = $('#login').val();
    let pass = $('#password').val();
    
    $.ajax({
        type: 'post',
        url: 'php/server.php',
        data: { passLog: log + '/' + pass},
        success: function(data){
            if (data.trim()) {
                $("#userform").hide();
                $("#common_window").show();
                $("#dialogs_window").show();
                $("#keyboard").hide();
                $("#dialogs_window").html(data.trim());
                $("#post_login").val(log);
                $('body, html').css({ 'overflow': 'auto', 'height': 'auto' });
            } else {
                alert('Неверный логин или пароль!');
                $("#login, #password").val('');
            }
        }
    });
});

// Выход
$('#exitbutton').click(function() {
    clearInterval(message_interval);
    $("#common_window").hide();
    $("#userform").show();
    $("#post_login").val('');
    $('body, html').css({ 'overflow': 'hidden', 'height': '100%' });
});

// Открытие диалога

let lastMessagesHtml = '';
window.dialogsBlockClick = function(element) {
    let dialog_id = $(element).find('#dialogs_id').text().trim() || 
                    $(element).find('#dialogs_id2').text().trim();
    let log = $('#post_login').val();
    
    if (!dialog_id) return;
    
    $.ajax({
        type: 'post',
        url: 'php/server.php',
        data: { dia_id: dialog_id + '/' + log },
        success: function(data){
            $('#diags_id').val(dialog_id);
            $("#dialogs_window").hide();
            $("#messages").show().html(data.trim());
            $("#textarea, #sendbutton, #backbutton").show();
            $("#searchbutton, #exitbutton").hide();
			$("#keyboard").show();
            scrollToBottom();
            
            let lastMessageId = 0;

clearInterval(message_interval);
message_interval = setInterval(function() {
    if ($('#messages').is(':visible') && $('#diags_id').val() == dialog_id) {
        $.ajax({
            type: 'post',
            url: 'php/server.php',
            data: { messcheck: log + '/' + dialog_id },
            success: function(data){
                let tempDiv = $('<div>').html(data.trim());
                let currentLastId = tempDiv.find('#message_id:last').text();
                
                if (currentLastId !== lastMessageId) {
                    lastMessageId = currentLastId;
                    $("#messages").html(data.trim());
                    if ($("#send_check").val() === '+') {
                        scrollToBottom();
                        $("#send_check").val('');
                    }
                }
            }
        });
    }
}, refreshSpeed);
        }
    });
};

// Назад к диалогам
$('#backbutton').click(function() {
    clearInterval(message_interval);
    $("#messages, #textarea, #sendbutton, #backbutton").hide();
    $("#dialogs_window, #searchbutton, #exitbutton").show();
    
    let log = $('#post_login').val();
    $.ajax({
        type: 'post',
        url: 'php/server.php',
        data: { passLog: log + '/' + $('#password').val() },
        success: function(data){
            if (data.trim()) $("#dialogs_window").html(data.trim());
        }
    });
});

// Отправка сообщения

$(document).on('click', '#sendbutton', function() {
    let textarea = $("#textarea");
    let message = textarea.val().trim();
    
    if (message === '') {
        alert('Нельзя отправить пустое сообщение');
        return;
    }
    
    let messageData = [
        message,
        $('#post_login').val(),
        new Date().toLocaleString('ru-RU'),
        $('#diags_id').val()
    ];
    
    $.ajax({
        type: "post",
        url: "php/server.php",
        data: { message_data: JSON.stringify(messageData) },
        success: function() {
            textarea.val('');
            $("#send_check").val('+');
        },
        error: function() {
            alert('Ошибка отправки');
        }
    });
});

// Enter для отправки
$('#textarea').off('keypress').on('keypress', function(e) {
    if (e.which === 13 && !e.shiftKey) {
        e.preventDefault();
        let message = $(this).val().trim();
        if (message !== '') {
            $('#sendbutton').click();
        }
        return false;
    }
});

// Удаление диалога
window.deleteButton = async function(button) {
    let confirmed = await customConfirm({
        title: 'Удаление диалога',
        message: 'Вы уверены, что хотите удалить этот диалог? Восстановить его будет невозможно.',
        confirmText: 'Удалить',
        cancelText: 'Отмена',
        type: 'danger'
    });
    
    if (!confirmed) return;
    
    // остальной код удаления
    let dialogBlock = $(button).closest('#dialog_object');
    let dia_id = dialogBlock.find('#dialogs_id').text().trim();
    
    $.ajax({
        type: 'post',
        url: 'php/server.php',
        data: { deletelog: dia_id },
        success: function(data){
            customAlert({
                title: 'Готово!',
                message: data.trim(),
                type: 'success'
            });
            $('#logbutton').click();
        }
    });
};
// Удаление сообщения
window.deleteButtonMessage = async function(button) {
    let confirmed = await customConfirm({
        title: 'Удаление сообщения',
        message: 'Вы уверены, что хотите удалить это сообщение?',
        confirmText: 'Удалить',
        cancelText: 'Отмена',
        type: 'warning'
    });
    
    if (!confirmed) return;
    
    // остальной код удаления
    let messageBlock = $(button).closest('#full_message_block');
    let message_id = messageBlock.find('#message_id').text().trim();
    let dialog_id = messageBlock.find('#message_dialog_id').text().trim();
    
    $.ajax({
        type: 'post',
        url: 'php/server.php',
        data: { delete_message_log: dialog_id + '/' + message_id },
        success: function(data){
            customAlert({
                title: 'Удалено',
                message: 'Сообщение удалено',
                type: 'success'
            });
            let log = $('#post_login').val();
            $.ajax({
                type: 'post',
                url: 'php/server.php',
                data: { messcheck: log + '/' + dialog_id },
                success: function(data){
                    $("#messages").empty();
                    $("#messages").append(data);
                    scrollMessagesToBottom();
                }
            });
        }
    });
};

// Функция прокрутки 
function scrollMessagesToBottom() {
    setTimeout(function() {
        let messagesDiv = document.getElementById('messages');
        if (messagesDiv) {
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }
    }, 100);
}

// Поиск
$('#searchbutton').click(function() {
    clearInterval(message_interval);
    $("#common_window").hide();
    $("#searchform").show();
});

$('#search_back_button').click(function() {
    $("#searchform").hide();
    $("#common_window").show();
    $("#searcharea, #searchmatches").val('').empty();
});

$('#findbutton').click(function() {
    let search = $("#searcharea").val().trim();
    if (!search) { alert('Введите логин для поиска'); return; }
    
    $.ajax({
        type: 'post',
        url: 'php/server.php',
        data: { searchlog: $('#post_login').val() + '_' + search },
        success: function(data){
            $("#searchmatches").html(data.trim() || '<div style="color:white">Совпадений не найдено</div>');
        }
    });
});

// Поиск — создание диалога
window.searchFinder = function() {
    let login = $("#searchresult").find('#dia_log').text() || 
                $("#searchresult").text().split('\n')[1];
    $.ajax({
        type: 'post',
        url: 'php/server.php',
        data: { searchanswer: $('#post_login').val() + '_' + login },
        success: function(data){
            if (data.trim() === 'Selfdia') {
                alert('Нельзя создать диалог с собой');
            } else {
                alert(data.trim());
                $("#searchform").hide();
                $("#common_window").show();
                $("#dialogs_window").show();
                $('#logbutton').click();
            }
        }
    });
};

// Регистрация
$('#regbutton').click(() => $("#userform").hide() && $("#regform").show());
$('#regbackbutton').click(() => $("#userform").show() && $("#regform").hide());

$('#goregbutton').click(function() {
    let login = $("#reg_login").val();
    let pass = $("#reg_password").val();
    let pass2 = $("#reg_password_repeat").val();
    
    if (!login || login === 'Логин') return alert('Введите логин');
    if (!pass || pass === 'Пароль') return alert('Введите пароль');
    if (pass !== pass2) return alert('Пароли не совпадают');
    
    $.ajax({
        type: "post",
        url: "php/server.php",
        data: { reg_data: login + '_' + pass },
        success: function(data){
            alert(data.trim());
            if (data.trim().includes('успешно')) {
                $("#userform").show();
                $("#regform").hide();
                $("#reg_login, #reg_password, #reg_password_repeat").val('');
                $.ajax({ type: 'post', url: 'php/server.php', data: { favourLog: login } });
            }
        }
    });
});

// Вспомогательные функции
function scrollToBottom() {
    setTimeout(() => {
        let msgDiv = document.getElementById('messages');
        if (msgDiv) msgDiv.scrollTop = msgDiv.scrollHeight;
    }, 100);
}

// Очистка полей регистрации
$('#reg_login, #reg_password, #reg_password_repeat').on('click', function() { $(this).val(''); });

