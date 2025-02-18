<?php
session_start();

include("judge_functions.php");
check_session_id();

$id = $_GET["id"];

$pdo = connect_to_db();

$sql = 'SELECT * FROM php_judge_table WHERE id=:id';






$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);

//取得した画像バイナリデータをbase64で変換。
$img = "data:image/jpeg;base64," . base64_encode($record["picture"]);



?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ジャッジリスト（編集画面）</title>

    <style>
        img {
            width: 400px;
            height: 260px;
        }



        /* styles.css */

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        form {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        legend {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="file"] {
            width: calc(100% - 10px);
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        img.preview-image {
            width: 100%;
            max-width: 400px;
            height: auto;
            display: block;
            margin-bottom: 10px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <form action="judge_update.php" method="POST" enctype="multipart/form-data">
        <!-- ↑↑↑画像をupdate.phpに送るとき、「enctype="multipart/form-data"」が無いと送れない -->

        <fieldset>
            <legend>ジャッジリスト（編集画面）</legend>
            <a href="judge_read.php">一覧画面</a>
            <div>
                ジャッジ名: <input type="text" name="jajjimei" value="<?= $record['judge_name'] ?>">
            </div>
            <div>
                画像: <img src="<?= $img ?>" alt="画像">
                画像を選択:<input type="file" name="gazou">
                <!-- inputのtypeがfileの場合、valueにファイルパス指定できないというルールがある -->

            </div>

            <!-- <div>
                picture_type: <input type="text" name="gazou_taipu" value="?= $record['picture_type'] ?>">
            </div> -->

            <div>
                傾向: <input type="text" name="keikou" value="<?= $record['judge_type'] ?>">重視
            </div>
            <div>
                バトル組み合わせ(A vs B): <input type="text" name="A" value="<?= $record['battle'] ?>">vs<input type="text" name="B" value="<?= $record['battle'] ?>">
            </div>
            <div>
                どちらを選んだ？: <input type="text" name="dotti" value="<?= $record['judge_choice'] ?>">
            </div>
            <div>
                Aのタイプ: <input type="text" name="Atype" value="<?= $record['A_type'] ?>">
            </div>
            <div>
                Bのタイプ: <input type="text" name="Btype" value="<?= $record['B_type'] ?>">
            </div>



            <div>
                <input type="hidden" name="id" value="<?= $record['id'] ?>">
            </div>
            <div>
                <button>編集する</button>
            </div>

        </fieldset>
    </form>

</body>

</html>