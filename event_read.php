<?php
session_start();
include("event_functions.php");
check_session_id();



$pdo = connect_to_db();


$sql = 'SELECT * FROM php_event_table ORDER BY created_at ASC';
//ASC⇒昇順（古い順）




// --------------------------------------
// RDBのテーブル結合※じっちゃんP2P ★
// ---------------------------------------
//※下記のLEFT OUTER JOINの前に。
//ALTER TABLE php_event_table ADD CONSTRAINT fk_user FOREIGN KEY (judge_id) REFERENCES php_judge_table(id);
//をMyAdminのSQLで実行して、event_tableのjudge_idとjudge_tableのidを紐づける必要あり




// --------------------------------------
// RDBのテーブル結合※じっちゃんP2P 
// ---------------------------------------
// $sql = "SELECT*FROM php_event_table LEFT OUTER JOIN php_judge_table ON  php_event_table.judge_id =php_judge_table.id";
//⇒MyAdminでうまくいった
$sql = "SELECT * FROM php_event_table LEFT OUTER JOIN  php_judge_table ON php_event_table.judge_id = php_judge_table.id";


// $sql = "SELECT * FROM php_event_table LEFT OUTER JOIN( SELECT event_id, COUNT(id) AS join_count FROM php_join_table GROUP BY event_id ) AS result_table ON php_event_table.id = result_table.event_id";
// $sql = "SELECT * FROM todo_table LEFT OUTER JOIN (SELECT todo_id,COUNT(*)AS like_count FROM like_table1 GROUP BY todo_id)AS result_table ON todo_table.id=result_table.todo_id ORDER BY deadline ASC";
//↑いいね数表示
//テーブルを結合してる








$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}




// $judge_id = $_SESSION['judge_id'];
$user_id = $_SESSION['user_id'];
//↑いいね数表示の際



// --------------------------------------
// RDBのテーブル結合※じっちゃんP2P
// ---------------------------------------
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($result);
// exit();
// ⇒event_tableとjudge_table両方のデータとれてるOK






// -------------------------------------------------------------
// カラム名でいうと「judge_name」、
// ブラウザに表示されている項目名でいうと「ジャッジ名」1つにつき、
// 1つの円グラフを表示させたい
// -------------------------------------------------------------

// 各ジャッジ名ごとに「judge_type」を集計する
// $result はイベントの情報を含む連想配列
// 各ジャッジの好みを集計するための配列
$tendencies = [];

foreach ($result as $record) {
    $judge_name = $record["judge_name"];
    $judge_type = $record["judge_type"];

    // ジャッジが初めて出てきた場合、初期化する
    if (!isset($tendencies[$judge_name])) {
        $tendencies[$judge_name] = [
            "大きさ" => 0,
            "アイデア" => 0,
            "音に乗れているか" => 0,
            "情熱" => 0,
        ];
    }
    // ジャッジの好みをカウントする
    if (array_key_exists($judge_type, $tendencies[$judge_name])) {
        $tendencies[$judge_name][$judge_type]++;
    }
}

// var_dump($record["judge_name"]);
// exit();
//⇒string(3) "馬"
//⇒OKではないな

// var_dump($record["judge_type"]);
// exit();
//⇒string(6) "情熱"
//⇒OKではないな

// var_dump($tendencies[$judge_name]);
// exit();
//⇒array(4) { ["大きさ"]=> int(0) ["アイデア"]=> int(0) ["音に乗れているか"]=> int(3) ["情熱"]=> int(1) }
//⇒OKではないな





// -------------------------------------------------------------
// カラム名でいうと「judge_name」、
// ブラウザに表示されている項目名でいうと「ジャッジ名」1つにつき、
// 1つの円グラフを表示させたい
// -------------------------------------------------------------

// 各ジャッジ名ごとに「judge_type」を集計する
// $result はイベントの情報を含む連想配列
// 各ジャッジの好みを集計するための配列
// $tendencies = [];

// foreach ($result as $record) {
//     $judge_name = $record["judge_name"];
//     $judge_type = $record["judge_type"];

//     // ジャッジ名が存在しない場合のみ初期化 ※ここ修正版
//     if (!array_key_exists($judge_name, $tendencies)) {
//         $tendencies[$judge_name] = [
//             "大きさ" => 0,
//             "アイデア" => 0,
//             "音に乗れているか" => 0,
//             "情熱" => 0,
//         ];
//     }
//     // ジャッジの好みをカウントする
//     if (array_key_exists($judge_type, $tendencies[$judge_name])) {
//         $tendencies[$judge_name][$judge_type]++;
//     }
// }

// var_dump($record["judge_name"]);
// exit();
//⇒string(3) "馬"
//⇒OKではないな

// var_dump($record["judge_type"]);
// exit();
//⇒string(6) "情熱"
//⇒OKではないな

// var_dump($tendencies[$judge_name]);
// exit();
//⇒array(4) { ["大きさ"]=> int(0) ["アイデア"]=> int(0) ["音に乗れているか"]=> int(3) ["情熱"]=> int(1) }
//⇒OKではないな





// ----------------------------------------------------------
//↓ここor HTMLのbody どちらかにforeachがあれば画像複数表示できる
// -----------------------------------------------------------
// --------------------------------------
// RDBのテーブル結合※じっちゃんP2P
// ---------------------------------------

// テーブルの各行を出力するためのHTML文字列
$output = "";
foreach ($result as $record) {
    $output .= "
    <tr>
      <td>{$record["event_day"]}</td>
      <td><a href='reservation_form.php?event_id={$record["id"]}'>{$record["event_name"]}</a></td>
      <td>{$record["event_place"]}</td>
     
      <td>{$record["judge_name"]}</td>
      <td><img src='data:image/jpeg;base64," . base64_encode($record["picture"]) . "' alt='画像'></td>
      <td>{$record["judge_type"]}</td>
      <td>{$record["battle"]}</td>
      <td>{$record["judge_choice"]}</td>
      <td>{$record["A_type"]}</td>
      <td>{$record["B_type"]}</td>
      

      <td><a href='event_edit.php?id={$record["id"]}'>編集</a></td>
      <td><a href='event_delete.php?id={$record["id"]}'>削除</a></td>


      <td>
            <!-- 各ジャッジの円グラフを描画するキャンバス -->
            <div class='engurahu'>
            <canvas id='{$record["judge_name"]}PieChart' width='100' height='100' ></canvas>
            </div>
        </td>

    </tr>
  ";
}

//↑[""]内にはDBテーブルのカラム名入れる
//↑いいね数表示の際⇒like{$record["like_count"]}追加






// var_dump($record["id"]);
// exit();
// ⇒int(10)

// var_dump($record["event_name"]);
// exit();
//⇒string(7) "THEREAL"







//避難⇒
//<td><a href='event_join.php?user_id={$user_id}&event_id={$record["id"]}'>join{$record["join_count"]}</a></td>
//<td><a href='event_join.php?judge_id={$judge_id}&event_id={$record["id"]}'>join{$record["join_count"]}</a></td>

// <td>
// <canvas id='<?= str_replace(' ', '', {$record["judge_name"]}) ?PieChart' width='100' height='100'></canvas>
//             <script>
//                 var ctx{$record["judge_name"]} = document.getElementById('<?= str_replace(' ', '', {$record["judge_name"]}) ?PieChart').getContext('2d');
//                 var myPieChart{$record["judge_name"]} = new Chart(ctx{$record["judge_name"]}, {
//                     type: 'pie',
//                     data: {
//                         labels: " . json_encode(array_keys($tendencies[$record["judge_name"]]), JSON_UNESCAPED_UNICODE) . ",
//                         datasets: [{
//                             backgroundColor: [
//                                 '#BB5179',
//                                 '#FAFF67',
//                                 '#58A27C',
//                                 '#3C00FF',
//                             ],
//                             data: " . json_encode(array_values($tendencies[$record["judge_name"]])) . "
//                         }]
//                     },
//                     options: {
//                         title: {
//                             display: true,
//                             text: '{$record["judge_name"]}の好み'
//                         }
//                     }
//                 });
//             </script>
//         </td>



// -------------------------------------------------------------------------
// 「judge_type」カラムを円グラフに連動させたい
// ⇒ジャッジ1人につき1円グラフではなく、ジャッジ全員につき1円グラフだった
// -----------------------------------------------------------------------

// 「judge_type」のカウントを初期化
// $tendencies = [
//     "大きさ" => 0,
//     "アイデア" => 0,
//     "音に乗れているか" => 0,
//     "情熱" => 0,
// ];

// // 各傾向のカウントを集計
// foreach ($result as $record) {
//     $tendency = $record["judge_type"]; // カラム「judge_type」の値を取得
//     if (array_key_exists($tendency, $tendencies)) {
//         $tendencies[$tendency]++;
//     }
// }

// // カウント結果を円グラフに反映するデータに変換
// $tendencyLabels = array_keys($tendencies);
// $tendencyCounts = array_values($tendencies);







?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>②ジャッジリスト（一覧画面）</title>

    <style>
        img {
            width: 400px;
            height: 360px;
            border-radius: 50%;
            /* 画像を丸くする */
            object-fit: cover;
            /* 画像を適切に収めるためのスタイル */
            border: 5px solid #4CAF50;
        }


        /* --------------------------- */
        /* 削除ボタンのモーダルウィンドウが動かない⇒とばす*/
        /* --------------------------- */


        /* モーダルのスタイル */
        .modal {
            display: none;
            /* モーダルを初めは非表示にする */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* ボタンのスタイル */
        .deleteBtn {
            cursor: pointer;
            color: red;
        }




        /* ------------------------------ */
        /* テーブルのヘッダー部分を固定 */
        /* ---------------------------------- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            /* テーブルと上部の間隔 */
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            position: sticky;
            top: 0;
            background-color: white;
            /* ヘッダーの背景色 */
            z-index: 1;
            /* ヘッダーが他の要素の上に表示されるようにする */
        }



        /* .engurahu{
            width:20px;
            height:20px;
        } */
        /* ⇒ダメ */


        /* .my-chart {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        } */
        /* ⇒円グラフではなく、左下「各ジャッジの好み」が反応してるけど */


        .engurahu {
            width: 600px;
            height: 600px;
        }





        /* ---------------------------------- */
        /* event_read.phpの見た目 */
        /* -------------------------------- */

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            font-size: 14px;
        }





        /* .my-chart {
            display: block;
            margin: 0 auto;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }




        th {
            position: sticky;
            top: 0;
            background-color: #f2f2f2;
            z-index: 1;
        } */

        /* -------------------------------------- */
    </style>

</head>

<body>



    <h2>②イベントリスト（一覧画面）</h2>
    <fieldset>

        <legend><?= $_SESSION["username"] ?>さんがログイン中</legend>
        <a href="event_input.php">イベント入力画面</a>
        <a href="event_logout.php">logout</a>
        <a href="judge_read.php">ジャッジ画面へ</a>
        <!-- <a href="judge_admin.php">管理者ページ</a> -->

        <table>
            <thead>


                <!-- --------------------------------------
                    RDBのテーブル結合※じっちゃんP2P
                --------------------------------------- -->
                <tr>
                    <th>イベント日</th>
                    <th>イベント名</th>

                    <th>場所</th>
                    <th>ジャッジ名</th>
                    <th>画像</th>
                    <th>好み</th>
                    <th>VS</th>
                    <th>どちらを選んだ？</th>
                    <th>Aのタイプ</th>
                    <th>Bのタイプ</th>

                    <th>編集</th>
                    <th>削除</th>
                    <th>円グラフ</th>


                </tr>
            </thead>
            <tbody>
                <?= $output ?>

            </tbody>
        </table>
    </fieldset>






    <!-- モーダル -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <p>本当に削除してもよろしいですか？</p>
            <form id="deleteForm" action="event_delete.php" method="GET">
                <!-- ↑judge_delete.phpファイルは$_GETで受け取ろうとしてるから -->
                <!-- ↑送る側もGETにしないとダメ -->

                <input type="hidden" name="id" id="deleteId">
                <button type="submit" name="confirm_delete">はい</button>
                <button type="button" id="cancelDelete">いいえ</button>
            </form>
        </div>
    </div>



    <script>
        // 削除ボタンをクリックした時の処理
        document.querySelectorAll('.deleteBtn').forEach(item => {
            item.addEventListener('click', event => {
                const id = item.getAttribute('data-id'); // 削除対象のIDを取得
                document.getElementById('deleteId').value = id; // 削除フォームにIDを設定
                document.getElementById('myModal').style.display = "block"; // モーダルを表示
            });
        });


        // モーダル外のクリックやキャンセルボタンをクリックした時の処理
        document.getElementById('cancelDelete').addEventListener('click', event => {
            document.getElementById('myModal').style.display = "none"; // モーダルを非表示
        });

        // モーダルの外をクリックした時の処理
        window.addEventListener('click', event => {
            const modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = "none"; // モーダルを非表示
            }
        });
    </script>



    <!-- --------------------- -->
    <!-- 円グラフ -->
    <!-- -------------------- -->

    <!-- -------------------------------------------------------------
    カラム名でいうと「judge_name」、
    ブラウザに表示されている項目名でいうと「ジャッジ名」1つにつき、
    1つの円グラフを表示させたい
    --------------------------------------------------------------->


    <!-- <h2>各ジャッジの好み</h2>
    ?php foreach ($tendencies as $judge_name => $tendencyData) : ?>
        <h3>?= $judge_name ?>の好み</h3>
        <canvas id="?= str_replace(' ', '', $judge_name) ?>PieChart"></canvas> -->


    <!-- <canvas id="myPieChart"></canvas> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script> -->








    <!--  ----------------------------------------------------------------
     各ジャッジに対して、1つ円グラフ表示できた ※横一行に円グラフ配置できてはない時点の
    event_read.phpコピー6.16.1720
    -------------------------------------------------------------- -->


    <!-- <h2>各ジャッジの好み</h2> -->
    <?php foreach ($tendencies as $judge_name => $tendencyData) : ?>
        <!-- <h3>?= $judge_name ?>の好み</h3> -->



        <!-- HTMLのbodyセクションの後にJavaScriptを記述 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>


        <!-- class 属性を付けた canvas タグ -->
        <canvas class="my-chart" id="<?= str_replace(' ', '', $judge_name) ?>PieChart" width="150" height="150"></canvas>


        <script>
            var ctx<?= str_replace(' ', '', $judge_name) ?> = document.getElementById("<?= str_replace(' ', '', $judge_name) ?>PieChart").getContext('2d');
            var myPieChart<?= str_replace(' ', '', $judge_name) ?> = new Chart(ctx<?= str_replace(' ', '', $judge_name) ?>, {
                type: 'pie',
                data: {
                    labels: <?= json_encode(array_keys($tendencyData), JSON_UNESCAPED_UNICODE) ?>,
                    datasets: [{
                        backgroundColor: [
                            "#BB5179",
                            "#FAFF67",
                            "#58A27C",
                            "#3C00FF",
                        ],
                        data: <?= json_encode(array_values($tendencyData)) ?>
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: '<?= $judge_name ?>の好み'
                    }
                }
            });
        </script>
    <?php endforeach; ?>




    <!-- --------------------- -->
    <!-- ver.3 -->
    <!-- --------------------- -->

    <!-- HTMLのbodyセクションの後にJavaScriptを記述 -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <script>
        // PHPから生成された $tendencies をJavaScriptに変換
        var tendencies = ?php echo json_encode($tendencies); ?>;

        // 各ジャッジごとに円グラフを描画する
        ?php foreach ($result as $record) : ?>
            var ctx_?php echo $record["judge_name"]; ?> = document.getElementById('?php echo $record["judge_name"]; ?>PieChart').getContext('2d');
            var myPieChart_?php echo $record["judge_name"]; ?> = new Chart(ctx_?php echo $record["judge_name"]; ?>, {
                type: 'pie',
                data: {
                    labels: ?php echo json_encode(array_keys($tendencies[$record["judge_name"]]), JSON_UNESCAPED_UNICODE); ?>,
                    datasets: [{
                        backgroundColor: [
                            '#BB5179',
                            '#FAFF67',
                            '#58A27C',
                            '#3C00FF',
                        ],
                        data: ?php echo json_encode(array_values($tendencies[$record["judge_name"]])); ?>
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: '?php echo $record["judge_name"]; ?>の好み'
                    }
                }
            });
        ?php endforeach; ?>
    </script> -->






    <!-- <script>
        ---------------------------------------------------------
        ver.2
        -------------------------------------------------


        var ctx?= str_replace(' ', '', $judge_name) ?> = document.getElementById("?= str_replace(' ', '', $judge_name) ?>PieChart").getContext('2d');
        var myPieChart?= str_replace(' ', '', $judge_name) ?> = new Chart(ctx?= str_replace(' ', '', $judge_name) ?>, {
            type: 'pie',
            data: {
                labels: ?= json_encode(array_keys($tendencyData), JSON_UNESCAPED_UNICODE) ?>,
                datasets: [{
                    backgroundColor: [
                        "#BB5179",
                        "#FAFF67",
                        "#58A27C",
                        "#3C00FF",
                    ],
                    data: ?= json_encode(array_values($tendencyData)) ?>
                }]
            },
            options: {
                title: {
                    display: true,
                    text: '?= $judge_name ?>の好み'
                }
            }
        });





        -------------------------------------------------------------------------
        ver.1
        「judge_type」カラムを円グラフに連動させたい
        ⇒ジャッジ1人につき1円グラフではなく、ジャッジ全員につき1円グラフだった
        -----------------------------------------------------------------------

        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ?= json_encode($tendencyLabels, JSON_UNESCAPED_UNICODE) ?>,

                datasets: [{
                    backgroundColor: [
                        "#BB5179",
                        "#FAFF67",
                        "#58A27C",
                        "#3C00FF",

                    ],
                    data: ?= json_encode($tendencyCounts) ?>
                    // 円グラフ元々の「 data: [1, 1, 1, 1]」 だけを改造
                    // ここ「data: decadeData」で.txtファイルの保存データの「年」と円グラフが連動した
                    // ↑GPTで出なかった
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'ジャッジ傾向'
                }
            }
        });
        
    </script> -->

    <!-- ?php endforeach; ?> -->


    <!-- ?php foreach ($result as $record) : ?>
        ?= $record["judge_type"] ?>
    ?php endforeach; ?> -->




</body>

</html>