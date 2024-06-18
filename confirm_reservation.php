<?php


// echo "<pre>";
// var_dump($_POST['event_id']);
// var_dump($_POST['email_title']);
// var_dump($_POST['dancer_name']);
// var_dump($_POST['dance_genre']);
// var_dump($_POST['email']);
// exit();

// string(1) "2"
// string(31) "あに拳Zエントリー希望"
// string(12) "しんさく"
// string(18) "ロックダンス"
// string(19) "kiheitai@icloud.com"


// string(1) "5"
// string(13) "FREEDOM vol.3"
// string(12) "しんさく"
// string(18) "ロックダンス"
// string(19) "kiheitai@icloud.com"

//⇒event_idという名前だがjudge_idを取ってきてしまっている






if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // POSTされたデータを取得
    $event_id = $_POST['event_id'];
    $email_title = $_POST['email_title'];
    $dancer_name = $_POST['dancer_name'];
    $dance_genre = $_POST['dance_genre'];
    $email = $_POST['email'];

    // ここでデータベースに保存する処理を行う
    // 例: save_reservation_to_db($event_id, $email_title, $dancer_name, $dance_genre, $email);

    // 保存が完了したら、完了画面にリダイレクトするなどの処理を行う
    header("Location: reservation_completed.php");
    exit;
}
