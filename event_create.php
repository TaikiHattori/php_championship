<?php
include("event_functions.php");

session_start();
check_session_id();
// ログインした人しか画面見せないとき追加


if (
    !isset($_POST['ibentobi']) || $_POST['ibentobi'] === '' ||
    !isset($_POST['ibentomei']) || $_POST['ibentomei'] === '' ||
    !isset($_POST['jajji_aidi']) || $_POST['jajji_aidi'] === '' ||
    !isset($_POST['basho']) || $_POST['basho'] === ''
) {
    exit('入力されていません');
}
//↑inputのname名を入力


$ibentobi = $_POST['ibentobi'];
$ibentomei = $_POST['ibentomei'];
$jajji_aidi = $_POST['jajji_aidi'];
$basho = $_POST['basho'];


// var_dump($jajji_aidi);
// exit();
//⇒string(1) "9"
// ⇒ここまでOK




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






// DB接続
$pdo = connect_to_db();





$sql = 'INSERT INTO php_event_table(id, event_day, event_name,judge_id,event_place, created_at, updated_at,deleted_at) 
        VALUES(NULL, :event_day, :event_name,:judge_id,:event_place, now(), now(),now())';

$stmt = $pdo->prepare($sql);




$stmt->bindValue(':event_day', $ibentobi, PDO::PARAM_STR);
$stmt->bindValue(':event_name', $ibentomei, PDO::PARAM_STR);
$stmt->bindValue(':judge_id', $jajji_aidi, PDO::PARAM_STR);
$stmt->bindValue(':event_place', $basho, PDO::PARAM_STR);
//$_ _ _もちゃんと更新


try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}


header("Location:event_input.php");
exit();
