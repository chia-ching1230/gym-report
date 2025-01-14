<?php
require __DIR__.'/includes/init.php';
header('Content-Type: application/json');
date_default_timezone_set("Asia/Taipei");

$output = [
    'success' => false , 
    'bodyData' => $_POST, 
    'code' =>0, 
    'error'=>'', 
    'lastInsertId' =>0,
];

$sql = "UPDATE `orders`
SET `order_id` = ?, `member_id` = ?, `total_amount` = ?, `self_pickup_store` = ?,`payment_method`, `status`= CURRENT_TIMESTAMP
WHERE `order_id` = ?"; //待檢查


$stmt = $pdo->prepare($sql); 
$stmt -> execute([
    $_POST['order_id'],
    $_POST['member_id'],
    $_POST['total_amount'],
    $_POST['self_pickup_store'],
    $_POST['payment_method'],
    $_POST['status']
]);
$output['success'] = !!$stmt->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();



echo json_encode($output,JSON_UNESCAPED_UNICODE);


