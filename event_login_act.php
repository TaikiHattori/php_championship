<?php

// データ受け取り
// var_dump($_POST);
// exit();
//⇒array(2) { ["username"]=> string(8) "shinsaku" ["password"]=> string(8) "kiheitai" }


session_start();
include('event_functions.php');

$username = $_POST['username'];
$password = $_POST['password'];

$pdo = connect_to_db();

$sql = 'SELECT * FROM php_users_table WHERE username=:username AND password=:password AND deleted_at IS NULL';
//php_judge_tableにも↑こう書いてるが、それでいけるのか。。。
//⇒ログインできた

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=event_login.php>ログイン</a>";
    exit();
} else {
    $_SESSION = array();

    //いいね機能時追加↓↓
    $_SESSION['user_id'] = $user['id'];

    $_SESSION['session_id'] = session_id();
    $_SESSION['is_admin'] = $user['is_admin'];
    $_SESSION['username'] = $user['username'];

    


    header("Location:event_read.php");
    exit();
}

//⇒更新済み6.14