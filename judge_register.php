<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ジャッジリストユーザ登録画面</title>
</head>

<body>
    <form action="judge_register_act.php" method="POST">
        <fieldset>
            <legend>ジャッジリストユーザ登録画面</legend>
            <div>
                username: <input type="text" name="username">
            </div>
            <div>
                password: <input type="text" name="password">
            </div>
            <div>
                <button>登録</button>
            </div>
            <a href="judge_login.php">or login</a>
        </fieldset>
    </form>

</body>

</html>

<!-- ⇒更新済み6.13 -->