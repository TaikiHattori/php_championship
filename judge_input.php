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


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            width: 100%;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        fieldset {
            border: none;
            padding: 0;
            margin: 0;
        }

        legend {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        div {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="file"] {
            width: calc(100% - 10px);
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"] {
            margin-right: 10px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            margin-right: 10px;
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>





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