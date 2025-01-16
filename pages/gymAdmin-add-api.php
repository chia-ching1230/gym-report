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


$sql1 = "INSERT INTO `gym_admin`
    (`admin_name`,`email`,`admin_password_hash`,`admin_role`)
    VALUES (?,?,?,?)";
$hashedPassword = password_hash($_POST['admin_password'], PASSWORD_BCRYPT);

$stmt1 = $pdo->prepare($sql1);
$stmt1->execute([
    $_POST['admin_name'],
    $_POST['email'],
    $hashedPassword,
    $_POST['admin_role'],
]);

$admin_id = $pdo->lastInsertId();

$admin_number = 2500 + intval($admin_id);
$admin_code = "A" . $admin_number;

$sql2 = "UPDATE `gym_admin`
SET
`admin_code`=?
WHERE
`admin_id`=?";

$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([
    strval($admin_code),
    $admin_id
]);

$output['success'] = !!$stmt2->rowCount();
$output['lastInsertId'] = $admin_id;


echo json_encode($output, JSON_UNESCAPED_UNICODE);
