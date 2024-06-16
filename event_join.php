<?php


// var_dump($_GET);
// exit();



//以下土台はcreateとかからコピペ

// ※一人1いいねにする⇒like_create.phpファイルだけで作れる


session_start();
include('event_functions.php');
check_session_id();




// $event_id = $_GET['event_id'];
$user_id = $_GET['user_id'];
$event_id = $_GET['event_id'];
// $judge_id = $_GET['judge_id'];


$pdo = connect_to_db();




// 該当するデータがあるか否か確認 ※一人1いいねにする際
$sql = 'SELECT COUNT(*) FROM php_join_table WHERE user_id=:user_id AND event_id=:event_id';
// $sql = 'SELECT COUNT(*) FROM php_join_table WHERE event_id=:event_id AND judge_id=:judge_id';
//※SQL1文だけでも一人1いいねにもできる※SQL文内で条件分岐させたらできる


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_STR);
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':event_id', $event_id, PDO::PARAM_STR);
// $stmt->bindValue(':judge_id', $judge_id, PDO::PARAM_STR);




try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// var_dump($status);
// exit();

// ↑read.phpファイルでlike押してチェック



// 件数取得※一人1いいねにする際
$join_count = $stmt->fetchColumn();

// var_dump($join_count);
// exit();
//⇒int(2)





if ($join_count !== 0) {
//     //いいね既にされている場合⇒削除※一人1いいねにする際
    $sql = 'DELETE FROM php_join_table WHERE user_id=:user_id AND event_id=:event_id';
    // $sql = 'DELETE FROM php_join_table WHERE event_id=:event_id AND judge_id=:judge_id';
} else {
//     // いいねまだされていない状態※一人1いいねにする際
$sql = 'INSERT INTO php_join_table (id, user_id,event_id,  created_at) VALUES (NULL,:user_id, :event_id,  now())';
}





$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_STR);


try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:event_read.php");
exit();
