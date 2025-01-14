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

$sql = "UPDATE `Videos`
SET `title` = ?, `description` = ?, `video_url` = ?, `category` = ?,`status`= ?
WHERE `videos_id` = ?"; 


$stmt = $pdo->prepare($sql); 
$stmt -> execute([
    $_POST['title'],
    $_POST['description'],
    $_POST['video_url'],
    $_POST['category'],
    $_POST['status'],
    $_POST['videos_id']
]);
$output['success'] = !!$stmt->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();



echo json_encode($output,JSON_UNESCAPED_UNICODE);


