<?php
require __DIR__ . '/includes/init.php';

$news_id = isset($_GET['news_id']) ? intval($_GET['news_id']) : 0;
$output = [
    'success' => false , 
    'bodyData' => $_POST, 
    'code' =>0, 
    'error'=>'', 
    'lastInsertId' =>0,
    'gymNews'=>'',
];

if ($news_id > 0) {
    $sql = "SELECT * FROM gym_news WHERE news_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$news_id]);
    $gymNews = $stmt->fetch();

    if ($gymNews) {
            $output['success'] = true;
            $output['gymNews'] = $gymNews;
    } else {
        $output['error'] = '文章不存在';
    }
} else {
    $output['error'] = '文章ID無效';
}

echo json_encode($output,JSON_UNESCAPED_UNICODE);