<?php
session_start();
include("event_functions.php");
check_session_id();


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イベントリスト（入力画面）</title>
</head>

<body>
    <form action="event_create.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>イベントリスト（入力画面）</legend>
            <a href="event_read.php">一覧画面</a>
            <a href="event_logout.php">logout</a>
            <div>
                イベント日 : <input type="date" name="ibentobi">
            </div>

            <div>
                イベント名: <input type="text" name="ibentomei">
            </div>

            <div>
                ジャッジid: <input type="text" name="jajji_aidi">
            </div>

            <div>
                場所: <input type="text" name="basho">
            </div>


            <!-- ↑4つ入力欄 -->



            <div>
                <button>保存</button>
            </div>
        </fieldset>
    </form>

</body>

</html>