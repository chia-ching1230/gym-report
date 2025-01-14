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
$sql = "INSERT INTO `gym_news`
(`title`, `content`, `author_id`, `uploadStatus`) 
VALUES (?,?,?,?)"; 


$stmt = $pdo->prepare($sql); 
$stmt -> execute([
    $_POST['title'],
    $_POST['content'],
    $_POST['author_id'],
    $_POST['uploadStatus']
]);
$output['success'] = !!$stmt->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();

echo json_encode($output,JSON_UNESCAPED_UNICODE);


