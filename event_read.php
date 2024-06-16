<?php
session_start();
include("event_functions.php");
check_session_id();



$pdo = connect_to_db();


$sql = 'SELECT * FROM php_event_table ORDER BY created_at ASC';
//ASC⇒昇順（古い順）



$sql = 'SELECT * FROM php_judge_table ORDER BY created_at ASC';










// $sql = "SELECT*FROM php_event_table LEFT OUTER JOIN php_judge_table ON  php_event_table.judge_id =php_judge_table.id";
//⇒MyAdminでうまくいった

$sql = "SELECT * FROM php_event_table LEFT OUTER JOIN( SELECT event_id, COUNT(id) AS join_count FROM php_join_table GROUP BY event_id ) AS result_table ON php_event_table.id = result_table.event_id";
// $sql = "SELECT * FROM todo_table LEFT OUTER JOIN (SELECT todo_id,COUNT(*)AS like_count FROM like_table1 GROUP BY todo_id)AS result_table ON todo_table.id=result_table.todo_id ORDER BY deadline ASC";
//↑いいね数表示
//テーブルを結合してる


$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}




// $judge_id = $_SESSION['judge_id'];
$user_id = $_SESSION['user_id'];
//↑いいね数表示の際


$result = $stmt->fetchAll(PDO::FETCH_ASSOC);




// ----------------------------------------------------------
//↓ここor HTMLのbody どちらかにforeachがあれば画像複数表示できる
// -----------------------------------------------------------

$output = "";
foreach ($result as $record) {
    $output .= "
    <tr>
      <td>{$record["event_day"]}</td>
      <td>{$record["event_name"]}</td>
      <td>{$record["judge_id"]}</td>
      <td>{$record["event_place"]}</td>
     

      <td><a href='event_join.php?user_id={$user_id}&event_id={$record["id"]}'>join{$record["join_count"]}</a></td>
      
      <td><a href='event_edit.php?id={$record["id"]}'>編集</a></td>
      <td><a href='event_delete.php?id={$record["id"]}'>削除</a></td>
    </tr>
  ";
}

//↑[""]内にはDBテーブルのカラム名入れる
//↑いいね数表示の際⇒like{$record["like_count"]}追加

//避難⇒<td><a href='event_join.php?user_id={$user_id}&event_id={$record["id"]}'>join{$record["join_count"]}</a></td>
//<td><a href='event_join.php?judge_id={$judge_id}&event_id={$record["id"]}'>join{$record["join_count"]}</a></td>




?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ジャッジリスト（一覧画面）</title>

    <style>
        img {
            width: 400px;
            height: 360px;
        }





        /* --------------------------- */
        /* 削除ボタンのモーダルウィンドウが動かない⇒とばす*/
        /* --------------------------- */


        /* モーダルのスタイル */
        .modal {
            display: none;
            /* モーダルを初めは非表示にする */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* ボタンのスタイル */
        .deleteBtn {
            cursor: pointer;
            color: red;
        }
    </style>
</head>

<body>

    <!-- モーダル -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <p>本当に削除してもよろしいですか？</p>
            <form id="deleteForm" action="event_delete.php" method="GET">
                <!-- ↑judge_delete.phpファイルは$_GETで受け取ろうとしてるから -->
                <!-- ↑送る側もGETにしないとダメ -->

                <input type="hidden" name="id" id="deleteId">
                <button type="submit" name="confirm_delete">はい</button>
                <button type="button" id="cancelDelete">いいえ</button>
            </form>
        </div>
    </div>


    <fieldset>
        <legend>イベントリスト（一覧画面）<?= $_SESSION["username"] ?>さんがログイン中</legend>
        <a href="event_input.php">入力画面</a>
        <a href="event_logout.php">logout</a>
        <!-- <a href="judge_admin.php">管理者ページ</a> -->

        <table>
            <thead>
                <tr>
                    <th>イベント日</th>
                    <th>イベント名</th>
                    <th>ジャッジid</th>
                    <th>場所</th>


                </tr>
            </thead>
            <tbody>
                <?= $output ?>

            </tbody>
        </table>
    </fieldset>


    <script>
        // 削除ボタンをクリックした時の処理
        document.querySelectorAll('.deleteBtn').forEach(item => {
            item.addEventListener('click', event => {
                const id = item.getAttribute('data-id'); // 削除対象のIDを取得
                document.getElementById('deleteId').value = id; // 削除フォームにIDを設定
                document.getElementById('myModal').style.display = "block"; // モーダルを表示
            });
        });

        // モーダル外のクリックやキャンセルボタンをクリックした時の処理
        document.getElementById('cancelDelete').addEventListener('click', event => {
            document.getElementById('myModal').style.display = "none"; // モーダルを非表示
        });

        // モーダルの外をクリックした時の処理
        window.addEventListener('click', event => {
            const modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = "none"; // モーダルを非表示
            }
        });
    </script>



</body>

</html>