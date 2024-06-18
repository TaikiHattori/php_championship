<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ジャッジリストログイン画面</title>


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
            max-width: 400px;
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
        input[type="password"] {
            width: calc(100% - 10px);
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
            display: block;
            text-align: center;
            color: #4CAF50;
            text-decoration: none;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>


</head>

<body>
    <form action="judge_login_act.php" method="POST">
        <fieldset>
            <legend>ジャッジリストログイン画面</legend>
            <div>
                ダンサーネーム: <input type="text" name="username">
            </div>
            <div>
                パスワード: <input type="text" name="password">
            </div>
            <div>
                <button>ログイン</button>
            </div>
            <a href="judge_register.php">新規登録</a>
        </fieldset>
    </form>

</body>

</html>

<!-- 更新済み6.12 -->