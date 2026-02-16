<?php

class search {

    public function __construct($conn = null, $conn2 = null) {
    
        $this->conn = $conn;
        $this->conn2 = $conn2;
    
    
    }
 public function searchLog() {
        
    $searchlog = $_POST['searchlog'];
    [$login,$search_login] = explode('_',$searchlog);
    $searchlog_sql = 'SELECT login FROM users WHERE login ="'.$search_login.'"';
    $searchlog_result = mysqli_query($this->conn2, $searchlog_sql); 
    $searchlog_assoc = mysqli_fetch_assoc($searchlog_result);
    if (isset($searchlog_assoc)) {
        if ($searchlog_assoc['login'] == $search_login) {
            
            echo 'Найдено:<br><br><div id="searchresult" onclick="searchFinder()"><div id="dialogs_id2">'.$searchlog.'</div><div id="dia_log">'.$search_login.'</div></div>';
            
        }
    }
    }
    
    





public function searchAnswer() {
    
    $today = date("m.d.Y H:i"); 
    $searchanswer = $_POST['searchanswer'];
    $login = strstr($searchanswer, '_', true);
    $search_login = trim(strstr($searchanswer, '_'), '_');
    $reverse_dia = $search_login.'_'.$login;
    $searcher_sql1 = 'SHOW TABLES LIKE "%'.$searchanswer.'%"';
    $searcher_result1 = mysqli_query($this->conn, $searcher_sql1);
    $searcher_sql2 = 'SHOW TABLES LIKE "%'.$reverse_dia.'%"';
    $searcher_result2 = mysqli_query($this->conn, $searcher_sql2);
    $searcher_result_assoc1 = mysqli_fetch_assoc($searcher_result1);
    $searcher_result_assoc2 = mysqli_fetch_assoc($searcher_result2);
    
    
    
    if ( $login == $search_login) {
        echo 'Selfdia';
    
        
    } else {
        
    function searchResultCheck($searcher_result_assoc1_x, $searcher_result_assoc2_x ): bool  {
        
    if($searcher_result_assoc1_x == null && $searcher_result_assoc2_x == null) {
        return true;
        
        
    } else {
        return false;
        
    }
}


    if(searchResultCheck($searcher_result_assoc1, $searcher_result_assoc2)) {

        $users_sql = 'SELECT login FROM users ';
    $users_result = mysqli_query($this->conn2, $users_sql);

    foreach ($users_result as $row2) {
        
        if ($row2['login'] == $search_login) {
            
            $sql_t = "CREATE TABLE ".$searchanswer." ( login VARCHAR(30) , message TEXT, date VARCHAR(100), id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY )";
            $newtable_sql = mysqli_query($this->conn, $sql_t);
            $insert_t = 'INSERT INTO '.$searchanswer.' VALUES ("Новый диалог","Начните общение прямо сейчас","'.$today.'", "1" )';
            $insert_sql = mysqli_query($this->conn, $insert_t);
            
            $reorg_sql1 = 'SELECT dialogs FROM users WHERE login ="'.$login.'"';
            $reorg_sql2 = 'SELECT dialogs FROM users WHERE login ="'.$search_login.'"';
            $reorg_sql_result1 = mysqli_query($this->conn2, $reorg_sql1);
            $reorg_sql_result2 = mysqli_query($this->conn2, $reorg_sql2);
            if ($reorg_sql_result1) {
            foreach ($reorg_sql_result1 as $row3) {
                if ($row3['dialogs'] == '') {
            $insert_user_dia = 'UPDATE users SET dialogs = CONCAT(dialogs, "'.$searchanswer.'" )  WHERE login ="'.$login.'"';
            $insert_user_dia_sql = mysqli_query($this->conn2, $insert_user_dia);
                } else {
            $insert_user_dia = 'UPDATE users SET dialogs = CONCAT(dialogs, "'.",".$searchanswer.'" )  WHERE login ="'.$login.'"';
            $insert_user_dia_sql = mysqli_query($this->conn2, $insert_user_dia);
                }
            }
        }
        if($reorg_sql_result2) {
            foreach ($reorg_sql_result2 as $row4) {
                if ($row4['dialogs'] == '') {
            $insert_user_dia = 'UPDATE users SET dialogs = CONCAT(dialogs, "'.$searchanswer.'" )  WHERE login ="'.$search_login.'"';
            $insert_user_dia_sql = mysqli_query($this->conn2, $insert_user_dia);
                } else {
            $insert_user_dia = 'UPDATE users SET dialogs = CONCAT(dialogs, "'.",".$searchanswer.'" )  WHERE login ="'.$search_login.'"';
            $insert_user_dia_sql = mysqli_query($this->conn2, $insert_user_dia);
                }
            }
        }

            echo 'Новый диалог создан';
    }
  }
 } else {
    echo 'Диалог найден';
    echo $logmatch;
 }
}
}

}

?>