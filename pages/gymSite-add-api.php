<?php
require __DIR__.'/includes/init.php';
header('Content-Type: application/json');

$output = [
    'success' => false , 
    'bodyData' => $_POST, 
    'code' =>0, 
    'error'=>'', 
    'lastInsertId' =>0,
];

$business_days = implode(',', $_POST['business_days']);
$sql = "INSERT INTO `gyms`
(`name`, `address`, `business_days`, `opening_hours`, `closing_hours`, `description`, `contact_info`, `email`, `manager`,`image_url`,`google_map_link`) 
VALUES (?,?,?,?,?,?,?,?,?,?,?)"; 


$stmt = $pdo->prepare($sql); 
$stmt -> execute([
    $_POST['name'],
    $_POST['address'],
    $business_days,
    $_POST['open'],
    $_POST['colse'],
    $_POST['description'],
    $_POST['tel'],
    $_POST['email'],
    $_POST['manager'],
    $_POST['image_url'],
    $_POST['google_map_link']
]);
$output['success'] = !!$stmt->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();

echo json_encode($output,JSON_UNESCAPED_UNICODE);


