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
    (`admin_name`,`email`,`admin_password_hash`,`admin_role`,`admin_code`)
    VALUE (?,?,?,?,?)";
$hashedPassword = password_hash($_POST['admin_password'], PASSWORD_BCRYPT);

$stmt1 = $pdo->prepare($sql);
$stmt1->execute([
    $_POST['admin_name'],
    $_POST['email'],
    $hashedPassword,
    $_POST['admin_role'],
    $_POST['admin_code']
]);

// $admin_id = $pdo->lastInsertId();
$output['success'] = !!$stmt1->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();
echo json_encode($output, JSON_UNESCAPED_UNICODE);

