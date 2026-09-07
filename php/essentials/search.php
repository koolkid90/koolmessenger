<?php

class search {

    public function __construct($conn = null, $conn2 = null) {
        $this->conn = $conn;
        $this->conn2 = $conn2;
    }
    
    public function searchLog() {
        try {
        $searchlog = htmlspecialchars($_POST['searchlog']);
        [$login, $search_login] = explode('_', $searchlog);
        
        // ИСПРАВЛЕНО: используем подготовленный запрос
        $searchlog_sql = 'SELECT login FROM users WHERE login = :login';
        $stmt = $this->conn2->prepare($searchlog_sql);
        $stmt->execute([':login' => $search_login]);
        $searchlog_assoc = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($searchlog_assoc && $searchlog_assoc['login'] == $search_login) {
            echo 'Найдено:<br><br>
            <div id="searchresult" onclick="searchFinder()">
                <div id="dialogs_id2">' . htmlspecialchars($searchlog) . '</div>
                <div id="dia_log">' . htmlspecialchars($search_login) . '</div>
            </div>';
        }
    } catch (PDOException $e) {
        error_log('Database error in messCheck: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        echo '<div class="error-message">Ошибка загрузки сообщений. Пожалуйста, обновите страницу.</div>';
    } catch (Exception $e) {
        error_log('General error in messCheck: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        echo '<div class="error-message">Произошла непредвиденная ошибка.</div>';
    }
}
    
    public function searchAnswer() {
        try {
        $today = date("m.d.Y H:i"); 
        $searchanswer = $_POST['searchanswer'];
        $login = strstr($searchanswer, '_', true);
        $search_login = trim(strstr($searchanswer, '_'), '_');
        $reverse_dia = $search_login . '_' . $login;
        
        // Проверяем существование таблицы
        $searcher_sql1 = 'SHOW TABLES LIKE :table1';
        $stmt1 = $this->conn->prepare($searcher_sql1);
        $stmt1->execute([':table1' => $searchanswer]);
        $searcher_result_assoc1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        
        $searcher_sql2 = 'SHOW TABLES LIKE :table2';
        $stmt2 = $this->conn->prepare($searcher_sql2);
        $stmt2->execute([':table2' => $reverse_dia]);
        $searcher_result_assoc2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        
        if ($login == $search_login) {
            echo 'Selfdia';
            return;
        }
        
        // Если таблица НЕ существует (диалога нет) - создаём
        if (!$searcher_result_assoc1 && !$searcher_result_assoc2) {
            
            // Проверяем, существует ли пользователь
            $users_sql = 'SELECT login FROM users WHERE login = :login';
            $stmt = $this->conn2->prepare($users_sql);
            $stmt->execute([':login' => $search_login]);
            $userExists = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($userExists) {
                // Создаём таблицу диалога
                $sql_t = "CREATE TABLE `{$searchanswer}` (
                    login VARCHAR(30), 
                    message TEXT, 
                    date VARCHAR(100), 
                    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY
                )";
                $this->conn->exec($sql_t);
                
                // Вставляем приветственное сообщение
                $insert_t = "INSERT INTO `{$searchanswer}` (login, message, date, id) 
                             VALUES ('Новый диалог', 'Начните общение прямо сейчас', '{$today}', 1)";
                $this->conn->exec($insert_t);
                
                // Обновляем диалоги у первого пользователя
                $reorg_sql1 = 'SELECT dialogs FROM users WHERE login = :login';
                $stmt1 = $this->conn2->prepare($reorg_sql1);
                $stmt1->execute([':login' => $login]);
                $row3 = $stmt1->fetch(PDO::FETCH_ASSOC);
                
                if ($row3['dialogs'] == '') {
                    $update = "UPDATE users SET dialogs = :dialog WHERE login = :login";
                    $stmtUpdate = $this->conn2->prepare($update);
                    $stmtUpdate->execute([':dialog' => $searchanswer, ':login' => $login]);
                } else {
                    $update = "UPDATE users SET dialogs = CONCAT(dialogs, ',', :dialog) WHERE login = :login";
                    $stmtUpdate = $this->conn2->prepare($update);
                    $stmtUpdate->execute([':dialog' => $searchanswer, ':login' => $login]);
                }
                
                // Обновляем диалоги у второго пользователя
                $stmt2 = $this->conn2->prepare($reorg_sql1);
                $stmt2->execute([':login' => $search_login]);
                $row4 = $stmt2->fetch(PDO::FETCH_ASSOC);
                
                if ($row4['dialogs'] == '') {
                    $update2 = "UPDATE users SET dialogs = :dialog WHERE login = :login";
                    $stmtUpdate2 = $this->conn2->prepare($update2);
                    $stmtUpdate2->execute([':dialog' => $searchanswer, ':login' => $search_login]);
                } else {
                    $update2 = "UPDATE users SET dialogs = CONCAT(dialogs, ',', :dialog) WHERE login = :login";
                    $stmtUpdate2 = $this->conn2->prepare($update2);
                    $stmtUpdate2->execute([':dialog' => $searchanswer, ':login' => $search_login]);
                }
                
                echo 'Новый диалог создан';
            } else {
                echo 'Пользователь не найден';
            }
        } else {
            echo 'Диалог найден';
        }
    } catch (PDOException $e) {
        error_log('Database error in messCheck: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        echo '<div class="error-message">Ошибка загрузки сообщений. Пожалуйста, обновите страницу.</div>';
    } catch (Exception $e) {
        error_log('General error in messCheck: ' . $e->getMessage() . ' - ' . date('Y-m-d H:i:s'));
        echo '<div class="error-message">Произошла непредвиденная ошибка.</div>';
    }
}
}
?>