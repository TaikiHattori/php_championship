<?php


session_start();
include("judge_functions.php");
check_session_id();

$id = $_GET["id"];

$pdo = connect_to_db();

$sql = "DELETE FROM php_judge_table WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:judge_read.php");
exit();
