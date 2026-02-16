    document.getElementById("login").onclick = function(e) {

	document.getElementById("login").value = "";
	
	document.getElementById("password").onclick = function(e) {
	
	document.getElementById("password").value = "";
	}
	}
	
	
	var reg_log_check = 0;
	var message_interval; // переменная интервала
	var refreshSpeed = 2000; // частота обновления диалога
	

	$( document ).ready(function() {
		$("#base_loading").hide();
		$("#login").hide();
		$("#password").hide();
		$("#logbutton").hide();
		$("#regbutton").hide();
		$("#messages").hide();
		$("#keyboard").hide();
		$("#dialogs_window").hide();
		$("#searchbutton").hide();
		$("#backbutton").hide();
		$("#send_check").hide();
		$('#searchform').hide();
		$('#search_back_button').hide();
		$('#regform').hide();
		$.ajax({
			type: 'post',
			url: 'php/server.php',
			data: { startChatLog: 'check'},
            
			success: function(data){
				$("#base_loading").show();
				$("#base_loading").append(data + '<br>');
		$.ajax({
			type: 'post',
			url: 'php/server.php',
			data: { startUsersLog: 'check'},

			success: function(data){
				
				$("#base_loading").append(data + '<br>');
				$.ajax({
					type: 'post',
					url: 'php/server.php',
					data: { checkServer: 'check'},
					success: function(data){
						if(data == 'ok') {
							$.ajax({
								type: 'post',
								url: 'php/server.php',
								data: { startServer: 'check'},
					
								success: function(data){
									$("#base_loading").append(data + '<br>');
									$("#login").show();
									$("#password").show();
									$("#logbutton").show();
									$("#regbutton").show();
									$("#base_loading").hide();
						}
						
						}) 
				} else {
					$("#base_loading").val() = 'Ошибка';
				}
	}
	})
}

	})
}
		})
	});
	

        
		$('#logbutton').click(() => {
		let log = $('#login').val();
        let pass = $('#password').val();
		$.ajax({
		type: 'post',
		url: 'php/server.php',
		data: { passLog: log + '/' + pass},
		success: function(data){
			if (data) {
			$("#userform").hide();
			$("#backbutton").hide();
			$("#search_back_button").hide();
			$("#exitbutton").show();
			$("#dialogs_window").show();
			$("#dialogs_window").empty();
			$("#keyboard").show();
			$("#searchbutton").show();
			$("#textarea").hide();
			$("#sendbutton").hide();
			$("#searchform").hide();
			
			$("#messages").hide();
			$("#common_window").show();
			$("#keyboard").css({'text-align' : 'center',
            
			});
			$("#dialogs_window").append(data);
			$("#post_login").val(log);
			
			
			} else {
				alert('Неверный логин или пароль!');
                $("#login").val('');
                $("#password").val('');
			}
		}
	})
	
})
        function deleteButton(dia) {
			let delete_choice = confirm('Вы действительно хотите удалить диалог?');
		    let dia_id = dia.parentElement.firstChild.firstChild.textContent;
			if(delete_choice) {
				$.ajax({
		        type: 'post',
		        url: 'php/server.php',
		        data: { deletelog: dia_id},
		        success: function(data){
					alert(data);
					$('#logbutton').click();
			        } 
		})
	}
}

function deleteButtonMessage(dia) {
	let dia_id = dia.parentElement.firstChild.firstChild.nextElementSibling.textContent;
	let message_id = dia.parentElement.firstChild.firstChild.textContent;
	let delete_choice = confirm('Вы действительно хотите удалить сообщение?');
	if(delete_choice) {
				$.ajax({
		        type: 'post',
		        url: 'php/server.php',
		        data: { delete_message_log: dia_id + '/' + message_id},
		        success: function(data){
					alert(data);
					
			        } 
		})
	}
}
		
		

		$('#exitbutton').click(() => {
			$("#messages").hide();
		$("#keyboard").hide();
		$("#dialogs_window").empty();
		$("#dialogs_window").hide();
		$("#searchbutton").hide();
		$("#userform").show();
		$("#post_login").val('');
		
			});
		
		
		function dialogsBlockClick(dia) {
			
		 let dialog_id = dia.childNodes[0].textContent;
		 let log = $('#post_login').val();
		
			if (dialog_id) {
				$.ajax({
					type: 'post',
					url: 'php/server.php',
					data: {dia_id:  dialog_id + '/' + log },
					success: function(data){
						
						$('#diags_id').val(dialog_id);
						$('#searchform').hide();
						$("#common_window").show();
						$("#keyboard").show();
						$("#dialogs_block").hide();
						$("#dialogs_window").hide();
						$("#messages").show();
						$("#messages").empty();
						$("#textarea").show();
			            $("#sendbutton").show();
						$("#searchbutton").hide();
						$("#search_back_button").hide();
						$("#exitbutton").hide();
						$("#backbutton").show();
						$("#messages").append(data);
						let letters = $("#letters").height();
		                $("#messages").scrollTop(letters + letters);
						
						
							
							message_interval = setInterval(function() {
								if ($('#messages').length) {
									$.ajax({
									type: 'post',
									url: 'php/server.php',
									data: {messcheck: log + '/' + dialog_id },
									success: function(data){
										
										if (data.length > $("#messages").html().length || data.length < $("#messages").html().length) {
										$("#messages").empty();
										$("#messages").append(data);
										if ($("#send_check").val() == '+') {
											let letters = $("#letters").height();
		                                    $("#messages").scrollTop(letters + letters);
											$("#send_check").val('');
										}
										
										
										}
									
									}
								})
							} 
							  }, refreshSpeed);
							}
					})
				}
			}
		function sendButton() {
			let date_now = new Date();
			let date_string = date_now.toLocaleDateString() + ' ' + date_now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: false});;
			let textarea = $("#textarea").val();
			let log = $('#post_login').val();
            let dialog_id = $('#diags_id').val();
			let new_message_data = [];
			new_message_data.push(textarea, log, date_string, dialog_id);
			

			if (textarea == '') {
				alert ('Нельзя вводить пустые сообщения');
			} else if (!textarea.trim(' ').length) {
				alert ('Нельзя вводить пустые сообщения');
				$("#textarea").val('');
				
} else {
			
		
		$.ajax({
		type: "post",
		url: "php/server.php",
		data: { message_data: JSON.stringify(new_message_data)},
		success: function(data){
		$("#textarea").val('');
		$("#send_check").val('+');
		
			}
		
		});
	}
				
}
$('#textarea').on('keydown', function( el ) {
        if( el.keyCode === 13 ) {
			$('#sendbutton').click();
            el.preventDefault();
            whenEnterPressed();
			
        }
    });
		

		$('#regbutton').click(() => {
			$("#userform").hide();
			$("#regform").show();
		 });

		 $('#searchbutton').click(() => {
			$("#common_window").hide();
			$("#keyboard").hide();
			$("#searchform").show();
			$('#search_back_button').show();
			clearInterval(message_interval);
			
		 });
		 $('#search_back_button').click(() => {
			$("#searchmatches").empty();
	        $("#searcharea").val('');
	        $('#logbutton').click();
			
		 });

		 $('#searcharea').on('keydown', function( el ) {
        if( el.keyCode === 13 ) {
            $('#findbutton').click();
			el.preventDefault();
            whenEnterPressed();
        }
    });
		 
         $('#findbutton').click(() => {
			
			let searchlogin = $("#searcharea").val();
			let login = $('#post_login').val();
			
			if (searchlogin == '') {
				alert ('Нельзя вводить пустой поисковой запрос');
			} else if (!searchlogin.trim(' ').length) {
				alert ('Нельзя вводить пустой поисковой запрос');
				$("#searcharea").val('');
			} else {
			
			$.ajax({
				type: 'post',
				url: 'php/server.php',
				data: { searchlog: login + '_' + searchlogin},
				success: function(data){
					if (data) {
					
					$("#searchmatches").empty();
					$("#searchmatches").append(data);
					} else {
						$("#searchmatches").empty();
						$("#searchmatches").append('Совпадений не найдено');
					}
				}
				})
			}
		 });

		 function searchFinder() {
			let search_login = document.getElementById('searchresult').childNodes[1].textContent;
			let login = $("#post_login").val();
				$.ajax({
				type: 'post',
				url: 'php/server.php',
				data: { searchanswer: login + '_' + search_login},
				success: function(data){
				if(data !== 'Selfdia') {
				alert(data);
				let element = document.getElementById('searchresult');
				dialogsBlockClick(element);
				
				} else {
					alert('Нельзя создавать диалог с собой');
				}
				}
			})
		 }

		

$('#backbutton').click(() => {
	$('#logbutton').click();
	$("#searchmatches").empty();
	$("#searcharea").val('');
	
	clearInterval(message_interval);
	
		});
				
			

$('#reg_login').one("click", function() { {
    $("#reg_login").val('');
	}
});

$('#reg_password').one("click", function() {
	$("#reg_password").val('');
});

$('#reg_password_repeat').one("click", function() {
	$("#reg_password_repeat").val('');
});

 $('#goregbutton').click(() => {
			let login = $("#reg_login").val();
			let password = $("#reg_password").val();
			let password_repeat = $("#reg_password_repeat").val();
			if (login == 'Логин' && password == 'Пароль') {
				alert('Нельзя создавать пользователя с таким именем и паролем');
				$("#reg_login").val('');
				$("#reg_password").val('');
			}
			if (login == 'Логин') {
				alert('Нельзя создавать пользователя с таким именем');
				$("#reg_login").val('');
			}
		    if (login == '') {
				alert ('Нельзя вводить пустой логин');
			} else if (!login.trim(' ').length) {
				alert ('Нельзя вводить пустой логин');
				$("#reg_login").val('');
			};
			if (password == '') {
				alert ('Нельзя вводить пустой пароль');
			} else if (!password.trim(' ').length) {
				alert ('Нельзя вводить пустой пароль');
				$("#reg_password").val('');
			};
			if (password_repeat == '') {
				alert ('Поле повтора пароля нельзя оставлят пустым');
			} else if (!password_repeat.trim(' ').length) {
				alert ('Поле повтора пароля нельзя оставлят пустым');
				$("#reg_password_repeat").val('');
			};
			if (password !== password_repeat) {
				alert ('Введенные пароли не совпадают');
				$("#reg_password").val('');
				$("#reg_password_repeat").val('');
		} else if (login && login != 'Логин' && password == password_repeat) {
		$.ajax({
		type: "post",
		url: "php/server.php",
		data: { reg_data: login + '_' + password},
		success: function(data){
		alert(data);
		if( data === 'Пользователь с данным логином уже существует') {
        $("#reg_login").val('');
        $("#reg_password").val('');
        $("#reg_password_repeat").val('');
		} else {
		$("#userform").show();
		$("#regform").hide();
		$("#reg_login").val('');
        $("#reg_password").val('');
        $("#reg_password_repeat").val('');
			}
		}
		});
		} else {
			alert('Ошибка сервера');
		}
 })
 $('#regbackbutton').click(() => {
	let login = $("#reg_login").val();
	let password = $("#reg_password").val();
	let password_repeat = $("#reg_password_repeat").val();
$("#userform").show();
$("#regform").hide();
if (login !== 'Логин' || password !== 'Пароль' || password_repeat !== 'Пароль') {

$("#reg_login").val('Логин');
$("#reg_password").val('Пароль');
$("#reg_password_repeat").val('Пароль');
}
 })