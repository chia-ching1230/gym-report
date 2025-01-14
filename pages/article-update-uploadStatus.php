<?php
require __DIR__ . '/includes/init.php';

$article_id = isset($_GET['article_id']) ? intval($_GET['article_id']) : 0;
$status = isset($_GET['status']) ? intval($_GET['status']) : 0;

if ($article_id > 0 && ($status == 0 || $status == 1)) {
    // 使用預處理語句更新資料庫
    $sql = "UPDATE articles SET uploadStatus = :status WHERE article_id = :article_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':status' => $status,
        ':article_id' => $article_id,
    ]);

    if ($stmt->rowCount()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => '更新失敗']);
    }
} else {
    echo json_encode(['success' => false, 'error' => '無效的參數']);
}
