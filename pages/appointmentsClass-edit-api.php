<?php
require __DIR__.'/includes/init.php';
header('Content-Type: application/json');
date_default_timezone_set("Asia/Taipei");

$output = [
    'success' => false,
    'bodyData' => $_POST,
    'code' => 0,
    'error' => '',
    'lastInsertId' => 0,
];

$sql = "UPDATE `appointments` 
        SET `member_id` = ?,
            `course_id` = ?,
            `status` = ?,
            `updated_at` = CURRENT_TIMESTAMP
        WHERE `appointment_id` = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['member_id'],
    $_POST['course_id'],
    $_POST['status'],
    $_POST['appointment_id']
]);

$output['success'] = !!$stmt->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();

echo json_encode($output, JSON_UNESCAPED_UNICODE);