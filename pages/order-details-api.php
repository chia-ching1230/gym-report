<?php
require __DIR__ . '/includes/init.php';

$article_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$output = [
    'success' => false , 
    'bodyData' => $_POST, 
    'code' =>0, 
    'error'=>'', 
    'lastInsertId' =>0,
    'article'=>'',
];

if ($order_id > 0) {
    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$article_id]);
    $article = $stmt->fetch();

    if ($order) {
            $output['success'] = true;
            $output['order'] = $order;
    } else {
        $output['error'] = '文章不存在';
    }
} else {
    $output['error'] = '文章ID無效';
}

echo json_encode($output,JSON_UNESCAPED_UNICODE);