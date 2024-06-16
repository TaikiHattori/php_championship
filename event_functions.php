<?php

function connect_to_db()
{
    $dbn = 'mysql:dbname=gs_l10_01_work;charset=utf8mb4;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';

    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}

function check_session_id()
{
    if (!isset($_SESSION["session_id"]) ||
        $_SESSION["session_id"] != session_id()) {
        header("Location:event_login.php");
    } else {
        session_regenerate_id(true);
        $_SESSION["session_id"] = session_id();
    }
}

//更新済み6.13