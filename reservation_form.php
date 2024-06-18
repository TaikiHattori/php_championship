<?php
// event_read.php から渡されたイベントIDを取得
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // イベントIDをもとにイベントの詳細情報を取得するクエリを実行することを想定
    // 例: $event_details = fetch_event_details($event_id); // これは自分で定義する関数
?>

    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>予約フォーム</title>


        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
                display: flex;
                justify-content: center;
                flex-direction: column;
                align-items: center;
                height: 100vh;
            }

            .form-container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 400px;
                max-width: 100%;
                border: 1px solid #ddd;
                /* 薄いグレーの枠線 */

                margin-top: 20px;
            }

            h2 {
                text-align: center;
                margin-bottom: 20px;
                color: #333;
            }

            label {
                font-weight: bold;
                color: #555;
            }

            input[type="text"],
            input[type="email"] {
                width: calc(100% - 16px);
                /* 16pxはパディングとボーダーの合計 */
                width: 100%;
                padding: 8px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-sizing: border-box;
            }

            input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                margin-top: 10px;
            }

            input[type="submit"]:hover {
                background-color: #45a049;
            }
        </style>


    </head>

    <body>
        <h2>予約フォーム</h2>
        <form action="confirm_reservation.php" method="POST">
            <input type="hidden" name="event_id" value="<?= $event_id ?>">
            <label for="email_title">メールタイトル:</label><br>
            <input type="text" id="email_title" name="email_title" required><br><br>
            <label for="dancer_name">ダンサーネーム:</label><br>
            <input type="text" id="dancer_name" name="dancer_name" required><br><br>
            <label for="dance_genre">ダンスジャンル:</label><br>
            <input type="text" id="dance_genre" name="dance_genre" required><br><br>
            <label for="email">メールアドレス:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <input type="submit" value="入力確認">
        </form>
    </body>

    </html>

<?php } ?>