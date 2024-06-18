<?php
session_start();

include("event_functions.php");
check_session_id();

$id = $_GET["id"];

$pdo = connect_to_db();

$sql = 'SELECT * FROM php_event_table WHERE id=:id';






$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);





?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イベントリスト（編集画面）</title>


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        .edit-form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        legend {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"] {
            width: calc(100% - 12px);
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 3px;
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
    <form action="event_update.php" method="POST" enctype="multipart/form-data">

        <fieldset>
            <legend>イベントリスト（編集画面）</legend>
            <a href="event_read.php">一覧画面</a>
            <div>
                イベント日: <input type="date" name="ibentobi" value="<?= $record['event_day'] ?>">
            </div>

            <div>
                イベント名: <input type="text" name="ibentomei" value="<?= $record['event_name'] ?>">
            </div>

            <div>
                ジャッジid: <input type="text" name="jajji_aidi" value="<?= $record['judge_id'] ?>">
            </div>

            <div>
                場所: <input type="text" name="basho" value="<?= $record['event_place'] ?>">
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