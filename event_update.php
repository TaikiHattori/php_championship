<?php
session_start();
include("event_functions.php");
check_session_id();


// var_dump($_POST['jajji_aidi']);
// exit();
//⇒string(1) "2"
// ⇒ここまでOK


// echo "<pre>";
// var_dump($_POST['jajjimei']);
// var_dump($_FILES['gazou']);
// var_dump($_POST['keikou']);
// var_dump($_POST['A']);
// var_dump($_POST['B']);
// var_dump($_POST['dotti']);
// var_dump($_POST['Atype']);
// var_dump($_POST['Btype']);
// var_dump($_POST['id']);
// exit();
//⇒string(21) "タイト・アイズ"
// array(6) {
//   ["name"]=>
//   string(13) "みかん.jpg"
//   ["full_path"]=>
//   string(13) "みかん.jpg"
//   ["type"]=>
//   string(10) "image/jpeg"
//   ["tmp_name"]=>
//   string(52) "C:\Users\Taiki Hattori\Desktop\xampp\tmp\phpC2EB.tmp"
//   ["error"]=>
//   int(0)
//   ["size"]=>
//   int(189999)
// }
// string(15) "大きさ重視"
// string(6) "あい"
// string(6) "あい"
// string(3) "あ"
// string(9) "大きさ"
// string(9) "細かさ"
// string(1) "1"
//⇒ここまでOK




if (
    !isset($_POST['ibentobi']) || $_POST['ibentobi'] === '' ||
    !isset($_POST['ibentomei']) || $_POST['ibentomei'] === '' ||
    !isset($_POST['jajji_aidi']) || $_POST['jajji_aidi'] === '' ||
    !isset($_POST['basho']) || $_POST['basho'] === '' ||
    !isset($_POST['id']) || $_POST['id'] === ''
) {
    exit('paramError');
}



$ibentobi = $_POST["ibentobi"];
$ibentomei = $_POST["ibentomei"];
$jajji_aidi = $_POST["jajji_aidi"];
$basho = $_POST["basho"];
$id = $_POST["id"];




$pdo = connect_to_db();

$sql = "UPDATE php_event_table SET event_day=:event_day,event_name=:event_name,judge_id=:judge_id,event_place=:event_place, updated_at=now() WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':event_day', $ibentobi, PDO::PARAM_STR);
$stmt->bindValue(':event_name', $ibentomei, PDO::PARAM_STR);
$stmt->bindValue(':judge_id', $jajji_aidi, PDO::PARAM_STR);
$stmt->bindValue(':event_place', $basho, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);


try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:event_read.php");
exit();

//⇒更新済み6/14
//judge_id追加6.15