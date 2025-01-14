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




$sql_basic = "INSERT INTO `member_basic`
    (`member_name`,`birthday`,`gender`,`phone`,`address`)
    VALUE (?,?,?,?,?)";


$stmt1 = $pdo->prepare($sql_basic);
$stmt1->execute([
    $_POST['member_name'],
    $_POST['birthday'],
    $_POST['gender'],
    $_POST['phone'],
    $_POST['address']
]);


$member_id = $pdo->lastInsertId();
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

$fitness_goals = implode(',', $_POST['fitness_goals']);
$sql_profile = "INSERT INTO `member_profile`
   (`member_id`,`height`,`weight`,`fitness_goals`,`bio`)
   VALUE (?,?,?,?,?)";

$stmt3 = $pdo->prepare($sql_profile);
$stmt3->execute([
    $member_id,
    $_POST['height'],
    $_POST['weight'],
    $fitness_goals,
    $_POST['bio']
]);




$output['success'] = !!$stmt1->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();
echo json_encode($output, JSON_UNESCAPED_UNICODE);
