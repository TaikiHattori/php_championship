<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イベント・ジャッジリストログイン画面</title>

    <style>
        /* ページ全体のスタイル */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* フォームのスタイル */
        form {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        legend {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        fieldset {
            border: none;
            padding: 0;
        }

        /* 入力フィールドとボタンのスタイル */
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #45a049;
        }

        /* リンクのスタイル */
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #4CAF50;
        }

        a:hover {
            text-decoration: underline;
            color: #45a049;
        }
    </style>


</head>

<body>
    <form action="event_login_act.php" method="POST">
        <fieldset>
            <legend>イベント・ジャッジリスト</legend>
            <legend>ログイン画面</legend>
            <div>
                ダンサーネーム: <input type="text" name="username">
            </div>
            <div>
                パスワード: <input type="text" name="password">
            </div>
            <div>
                <button>ログイン</button>
            </div>
            <a href="event_register.php">新規登録</a>
        </fieldset>
    </form>

</body>

</html>

<!-- 更新済み6.14 -->