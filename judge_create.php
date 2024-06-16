<?php
include("judge_functions.php");

session_start();
check_session_id();
// ログインした人しか画面見せないとき追加


if (
    !isset($_POST['jajjimei']) || $_POST['jajjimei'] === '' ||
    !isset($_FILES['gazou']) || $_FILES['gazou'] === '' ||
    !isset($_POST['keikou']) || $_POST['keikou'] === '' ||
    !isset($_POST['A']) || $_POST['A'] === '' ||
    !isset($_POST['B']) || $_POST['B'] === '' ||
    !isset($_POST['dotti']) || $_POST['dotti'] === '' ||
    !isset($_POST['Atype']) || $_POST['Atype'] === '' ||
    !isset($_POST['Btype']) || $_POST['Btype'] === ''
) {
    exit('入力されていません');
}
//↑inputのname名を入力


$jajjimei = $_POST['jajjimei'];
$gazou = $_FILES['gazou'];
$keikou = $_POST['keikou'];
$A = $_POST['A'];
$B = $_POST['B'];
$dotti = $_POST['dotti'];
$Atype = $_POST['Atype'];
$Btype = $_POST['Btype'];



// var_dump($jajjimei);
// echo "<pre>";
// //⇒string(21) "タイト・アイズ"

// var_dump($gazou);
// //⇒array(6) {
// //   ["name"]=>string(25) "クランプダンス.jpg"
// //   ["full_path"]=>string(25) "クランプダンス.jpg"
// //   ["type"]=>string(10) "image/jpeg"
// //   ["tmp_name"]=>string(52) "C:\Users\Taiki Hattori\Desktop\xampp\tmp\phpA1F0.tmp"
// //   ["error"]=>int(0)
// //   ["size"]=>int(89762)
// //}

// var_dump($keikou);
// //⇒string(15) "大きさ重視"

// var_dump($A);
// //⇒string(3) "あ"

// var_dump($B);
// //⇒string(3) "い"

// var_dump($dotti);
// //⇒string(3) "あ"

// var_dump($Atype);
// //⇒string(9) "大きさ"

// var_dump($Btype);
// exit();
//⇒string(9) "細かさ"

// ⇒ここまでOK






// DB接続
$pdo = connect_to_db();


// ---------------------
// 画像保存
// ----------------


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
} else {
    // 画像を保存
    if (!empty($_FILES['gazou']['name'])) {
        // $name = $_FILES['gazou']['name'];
        // $type = $_FILES['gazou']['type'];
        // $size = $_FILES['gazou']['size'];

        $content = file_get_contents($_FILES['gazou']['tmp_name']);


        $sql = 'INSERT INTO php_judge_table(id, judge_name, picture,judge_type,battle,judge_choice,A_type,B_type, created_at, updated_at,deleted_at) 
        VALUES(NULL, :judge_name, :picture,:judge_type,:battle,:judge_choice,:A_type,:B_type, now(), now(),now())';

        $stmt = $pdo->prepare($sql);




        $stmt->bindValue(':judge_name', $jajjimei, PDO::PARAM_STR);
        // ↓画像データをバイナリ形式でデータベースに挿入
        $stmt->bindValue(':picture', file_get_contents($_FILES['gazou']['tmp_name']), PDO::PARAM_LOB);
        $stmt->bindValue(':judge_type', $keikou, PDO::PARAM_STR);
        $stmt->bindValue(':battle', $A . $B, PDO::PARAM_STR);
        // ↑ここの「$A . $B」大丈夫か？
        $stmt->bindValue(':judge_choice', $dotti, PDO::PARAM_STR);
        $stmt->bindValue(':A_type', $Atype, PDO::PARAM_STR);
        $stmt->bindValue(':B_type', $Btype, PDO::PARAM_STR);




        try {
            $status = $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["sql error" => "{$e->getMessage()}"]);
            exit();
        }
    }
}



header("Location:judge_input.php");
exit();
