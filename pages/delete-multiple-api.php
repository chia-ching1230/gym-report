<?php
require __DIR__ . '/includes/init.php';

header('Content-Type: application/json');

// 確認請求是否為 POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// 獲取傳遞的 ID 數組
$data = json_decode(file_get_contents('php://input'), true);
if (empty($data['ids']) || !is_array($data['ids'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit;
}

$ids = array_map('intval', $data['ids']); // 確保 ID 為整數
$idList = implode(',', $ids); // 將數組轉為逗號分隔的字符串

// 執行批量刪除
$sql = "DELETE FROM products WHERE id IN ($idList)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

