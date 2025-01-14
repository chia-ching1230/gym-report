<?php
require __DIR__ . '/includes/init.php';

$videos_id = isset($_GET['videos_id']) ? intval($_GET['videos_id']) : 0;
$output = [
    'success' => false , 
    'bodyData' => $_POST, 
    'code' =>0, 
    'error'=>'', 
    'lastInsertId' =>0,
    'Video'=>'',
];

if ($videos_id > 0) {
    $sql = "SELECT * FROM Videos WHERE videos_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$videos_id]);
    $Video = $stmt->fetch();

    if ($Video) {
            $output['success'] = true;
            $output['Video'] = $Video;
    } else {
        $output['error'] = '影片不存在';
    }
} else {
    $output['error'] = '影片ID無效';
}

echo json_encode($output,JSON_UNESCAPED_UNICODE);