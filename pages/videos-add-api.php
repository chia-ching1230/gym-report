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
$sql = "INSERT INTO `Videos`
(`title`, `description`, `video_url`, `category`,`status`) 
VALUES (?,?,?,?,?)"; 


$stmt = $pdo->prepare($sql); 
$stmt -> execute([
    $_POST['title'],
    $_POST['description'],
    $_POST['video_url'],
    $_POST['category'],
    $_POST['status']
]);
$output['success'] = !!$stmt->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();

echo json_encode($output,JSON_UNESCAPED_UNICODE);


