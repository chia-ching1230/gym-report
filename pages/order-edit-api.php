<?php
require __DIR__.'/includes/init.php';
header('Content-Type: application/json');
date_default_timezone_set("Asia/Taipei");

$output = [
    'success' => false , 
    'bodyData' => $_POST, 
    'code' =>0, 
    'error'=>'' 

];

$sql = "UPDATE `orders`
SET `member_id` = ?, 
`total_amount` = ?, 
`self_pickup_store` = ?,
`payment_method` = ?, 
`status` = ?
WHERE `order_id` = ?"; 


$stmt = $pdo->prepare($sql); 
$stmt -> execute([
    $_POST['member_id'],
    $_POST['total_amount'],
    $_POST['self_pickup_store'],
    $_POST['payment_method'],
    $_POST['status'],
    $_POST['order_id']
]);
$output['success'] = !!$stmt->rowCount();



echo json_encode($output,JSON_UNESCAPED_UNICODE);


