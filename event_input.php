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


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        form {
           
            max-width: 600px;
            margin: 20px auto;
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

        input[type="date"],
        input[type="text"] {
            width: calc(100% - 10px);
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            /*  #007bff */
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
            /* color: #007bff; */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>






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
                ジャッジid: <input type="text" name="jajji_aidi">※ジャッジ一覧のジャッジidを入力
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