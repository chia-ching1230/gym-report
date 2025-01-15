<?php
require __DIR__ . '/includes/init.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'bodyData' => $_POST,
    'code' => 0,
    'error' => '',
    'lastInsertId' => 0,
];


$sql = "INSERT INTO `gym_admin`
    (`admin_name`,`email`,`admin_password`,`admin_role`,`admin_code`)
    VALUE (?,?,?,?,?)";


$stmt1 = $pdo->prepare($sql_basic);
$stmt1->execute([
    $_POST['member_name'],
    $_POST['birthday'],
    $_POST['gender'],
    $_POST['phone'],
    $_POST['address']
]);

$admin_id = $pdo->lastInsertId();
$hashedPassword = password_hash($_POST['member_password'], PASSWORD_BCRYPT);
$sql_auth = "INSERT INTO `member_auth`
(`member_id`,`email`, `member_password`) 
VALUES (?,?,?)";

$stmt2 = $pdo->prepare($sql_auth);
$stmt2->execute([
    $member_id,
    $_POST['email'],
    $hashedPassword

]);