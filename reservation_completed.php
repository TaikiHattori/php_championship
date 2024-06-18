<?php
session_start();
include("event_functions.php");
check_session_id();

// POSTされた予約情報を取得
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_id = $_POST['event_id'];
    $mail_title = $_POST['mail_title'];
    $dancer_name = $_POST['dancer_name'];
    $dance_genre = $_POST['dance_genre'];
    $email = $_POST['email'];

    // 入力確認画面から戻ってきた場合にもう一度表示するための情報をセッションに保存
    $_SESSION['reservation_data'] = [
        'event_id' => $event_id,
        'mail_title' => $mail_title,
        'dancer_name' => $dancer_name,
        'dance_genre' => $dance_genre,
        'email' => $email,
    ];

    // データベースに予約情報を保存する処理
    try {
        $pdo = connect_to_db();
        $sql = "INSERT INTO php_reservations_table (event_id, mail_title, dancer_name, dance_genre, email, created_at,updated_at,deleted_at) VALUES (:event_id, :mail_title, :dancer_name, :dance_genre, :email, now(),now(),now())";
        // $sql = "INSERT INTO php_reservations_table (event_id, mail_title, dancer_name, dance_genre, email, created_at,updated_at,deleted_at) VALUES (?, ?, ?, ?, ?, sysdate())";
        $stmt = $pdo->prepare($sql);



        $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->bindValue(':mail_title', $mail_title, PDO::PARAM_STR);
        $stmt->bindValue(':dancer_name', $dancer_name, PDO::PARAM_STR);
        $stmt->bindValue(':dance_genre', $dance_genre, PDO::PARAM_STR);
        $stmt->bindValue(': email', $email, PDO::PARAM_STR);

        // $stmt->execute([$event_id, $mail_title, $dancer_name, $dance_genre, $email]);






        $reservation_id = $pdo->lastInsertId(); // 最後に挿入されたレコードのIDを取得

        // 予約が完了したことをセッションに保存
        $_SESSION['reservation_id'] = $reservation_id;

        // セッションに保存したデータを削除（次の予約のため）
        unset($_SESSION['reservation_data']);

        // 予約完了ページにリダイレクト
        header("Location: reservation_completed.php");
        exit();
    } catch (PDOException $e) {
        echo "予約処理中にエラーが発生しました：" . $e->getMessage();
        exit();
    }
} else {
    // POSTメソッドでない場合はエラーを表示して終了
    echo "このページに直接アクセスすることはできません。";
    exit();
}



?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約完了</title>
    <style>
        /* スタイルを適切に設定してください */
    </style>
</head>

<body>
    <h1>予約が完了しました</h1>
    <p>以下の内容で予約が完了しました。</p>
    <ul>
        <li>イベントID: <?= htmlspecialchars($event_id) ?></li>
        <li>メールタイトル: <?= htmlspecialchars($mail_title) ?></li>
        <li>ダンサー名: <?= htmlspecialchars($dancer_name) ?></li>
        <li>ダンスジャンル: <?= htmlspecialchars($dance_genre) ?></li>
        <li>メールアドレス: <?= htmlspecialchars($email) ?></li>
    </ul>
    <p>予約ID: <?= htmlspecialchars($reservation_id) ?></p>

    <p><a href="admin_only_page.php">管理者ページへ</a></p>
    <p><a href="event_read.php">イベント一覧へ戻る</a></p>
</body>

</html>