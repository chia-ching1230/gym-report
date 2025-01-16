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


$sql = "UPDATE `gym_admin`
SET
`admin_name`=?,
`email`=?,
`admin_role`=?
WHERE
`admin_id`=?";


$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['admin_name'],
    $_POST['email'],
    $_POST['admin_role'],
    $_POST['admin_id']
]);
$output['success'] = !!$stmt->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();



echo json_encode($output, JSON_UNESCAPED_UNICODE);
