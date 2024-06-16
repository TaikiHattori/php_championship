<?php
session_start();
include("judge_functions.php");
check_session_id();




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
    !isset($_POST['jajjimei']) || $_POST['jajjimei'] === '' ||
    !isset($_FILES['gazou']) || $_FILES['gazou'] === '' ||
    !isset($_POST['keikou']) || $_POST['keikou'] === '' ||
    !isset($_POST['A']) || $_POST['A'] === '' ||
    !isset($_POST['B']) || $_POST['B'] === '' ||
    !isset($_POST['dotti']) || $_POST['dotti'] === '' ||
    !isset($_POST['Atype']) || $_POST['Atype'] === '' ||
    !isset($_POST['Btype']) || $_POST['Btype'] === ''
) {
    exit('paramError');
}



$jajjimei = $_POST['jajjimei'];
$gazou = $_FILES['gazou'];
$keikou = $_POST['keikou'];
$A = $_POST['A'];
$B = $_POST['B'];
$dotti = $_POST['dotti'];
$Atype = $_POST['Atype'];
$Btype = $_POST['Btype'];
$id = $_POST["id"];




$pdo = connect_to_db();

$sql = "UPDATE php_judge_table SET judge_name=:judge_name,picture=:picture,judge_type=:judge_type,battle=:battle,judge_choice=:judge_choice,A_type=:A_type,B_type=:B_type, updated_at=now() WHERE id=:id";

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
$stmt->bindValue(':id', $id, PDO::PARAM_INT);


try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:judge_read.php");
exit();

//⇒更新済み6/13
//⇒event ver.にしてしまってたのを修正6.15