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

$sql = "UPDATE `gym_news`
SET `title` = ?, `content` = ?, `author_id` = ?, `uploadStatus` = ?,`updated_at`= CURRENT_TIMESTAMP
WHERE `news_id` = ?"; 


$stmt = $pdo->prepare($sql); 
$stmt -> execute([
    $_POST['title'],
    $_POST['content'],
    $_POST['author_id'],
    $_POST['uploadStatus'],
    $_POST['news_id']
]);
$output['success'] = !!$stmt->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();



echo json_encode($output,JSON_UNESCAPED_UNICODE);


