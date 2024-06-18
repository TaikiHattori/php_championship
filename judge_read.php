<?php
session_start();
include("judge_functions.php");
check_session_id();



$pdo = connect_to_db();


$sql = 'SELECT * FROM php_judge_table ORDER BY created_at ASC';
//ASC⇒昇順（古い順）


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




// $user_id = $_SESSION['user_id'];
//↑いいね数表示の際


$result = $stmt->fetchAll(PDO::FETCH_ASSOC);




// ----------------------------------------------------------
//↓ここor HTMLのbody どちらかにforeachがあれば画像複数表示できる
// -----------------------------------------------------------

$output = "";
foreach ($result as $record) {
    $output .= "
    <tr>
      <td>{$record["id"]}</td>

      <td>{$record["judge_name"]}</td>
      <td><img src='data:image/jpeg;base64," . base64_encode($record["picture"]) . "' alt='画像'></td>
      <td>{$record["judge_type"]}</td>
      <td>{$record["battle"]}</td>
      <td>{$record["judge_choice"]}</td>
      <td>{$record["A_type"]}</td>
      <td>{$record["B_type"]}</td>
     

      <td><a href='judge_edit.php?id={$record["id"]}'>編集</a></td>
      <td><a href='judge_delete.php?id={$record["id"]}'>削除</a></td>
    </tr>
  ";
}

//↑[""]内にはDBテーブルのカラム名入れる
//↑いいね数表示の際⇒like{$record["like_count"]}追加






?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>①ジャッジリスト（一覧画面）</title>

    <style>
        img {
            width: 400px;
            height: 360px;
            border-radius: 50%;
            /* 画像を丸くする */
            object-fit: cover;
            /* 画像を適切に収めるためのスタイル */
            border: 5px solid #4CAF50;
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


        /* ジャッジid（イベント入力時使用）を赤色にする */
        table th:first-child {
            color: red;

        }



/* -------------------------------------------- */
        /* 固定ヘッダーとスクロール可能な本文 */
        /* ----------------------------------------- */
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        /* th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        } */

     

        thead {
            position: sticky;
            /* 固定ヘッダー */
            top: 0;
            background-color: #f2f2f2;
        }

        /* tbody {
            display: block;
            height: 300px; */
            /* 本文部分の高さを固定する（適宜調整） */
            /* overflow-y: auto; */
            /* スクロール可能にする */
        /* } */
/* ------------------ */
/* ↑これがスクロールバー邪魔する */
/* ----------------------------- */


        /* img {
            width: 100px;
           
            height: 100px;
          
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #4CAF50;
        } */



        
    </style>
</head>

<body>

    <!-- モーダル -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <p>本当に削除してもよろしいですか？</p>
            <form id="deleteForm" action="judge_delete.php" method="GET">
                <!-- ↑judge_delete.phpファイルは$_GETで受け取ろうとしてるから -->
                <!-- ↑送る側もGETにしないとダメ -->

                <input type="hidden" name="id" id="deleteId">
                <button type="submit" name="confirm_delete">はい</button>
                <button type="button" id="cancelDelete">いいえ</button>
            </form>
        </div>
    </div>


    <h2>①ジャッジリスト（一覧画面）</h2>

    <fieldset>
        <legend><?= $_SESSION["username"] ?>さんがログイン中</legend>
        <a href="judge_input.php">ジャッジ入力画面</a>
        <a href="judge_logout.php">logout</a>
        <a href="event_read.php">イベント画面へ</a>
        <!-- <a href="judge_admin.php">管理者ページ</a> -->
        <table>
            <thead>
                <tr>
                    <th>ジャッジid（イベント入力時使用）</th>
                    <th>ジャッジ名</th>
                    <th>画像</th>
                    <th>好み</th>
                    <th>バトル組み合わせ(A vs B)</th>
                    <th>どちらを選んだ？</th>
                    <th>Aのタイプ</th>
                    <th>Bのタイプ</th>

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