<?php
session_start();
include("judge_functions.php");
check_session_id();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ジャッジリスト（入力画面）</title>
</head>

<body>
    <form action="judge_create.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>ジャッジリスト（入力画面）</legend>
            <a href="judge_read.php">一覧画面</a>
            <a href="judge_logout.php">logout</a>
            <div>
                ジャッジ名 : <input type="text" name="jajjimei">
            </div>

            <div>
                画像: <input type="file" name="gazou" accept="gazou/*">
                <!-- accept追加↑ -->
            </div>

            <div>
                ジャッジ傾向: <input type="text" name="keikou">重視
            </div>

            <div>
                バトル組み合わせ（A vs B） : <input type="text" name="A"> vs <input type="text" name="B">
            </div>

            <div>
                どちらを選んだ？: <input type="text" name="dotti">
            </div>

            <div>
                A: <input type="text" name="Atype">タイプ
            </div>

            <div>
                B: <input type="text" name="Btype">タイプ
            </div>
            <!-- ↑８つ入力欄 -->



            <div>
                <button>保存</button>
            </div>
        </fieldset>
    </form>

</body>

</html>