<?php
require __DIR__ . '/includes/init.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => ''
];

if (empty($_POST['coach_id'])) {
    $output['error'] = '缺少教練編號';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

// 開始交易
$pdo->beginTransaction();

try {
    // 先刪除該教練課程的所有預約記錄
    $sql_appointments = "DELETE FROM appointments 
                        WHERE course_id IN (
                            SELECT course_id FROM courses 
                            WHERE coach_id=:coach_id
                        )";
    $stmt_appointments = $pdo->prepare($sql_appointments);
    $stmt_appointments->execute([
        'coach_id' => $_POST['coach_id']
    ]);

    // 再刪除該教練的所有課程
    $sql_courses = "DELETE FROM courses WHERE coach_id=:coach_id";
    $stmt_courses = $pdo->prepare($sql_courses);
    $stmt_courses->execute([
        'coach_id' => $_POST['coach_id']
    ]);

    // 最後更新教練狀態為inactive
    $sql_coach = "UPDATE coaches SET status='inactive' WHERE coach_id=:coach_id";
    $stmt_coach = $pdo->prepare($sql_coach);
    $stmt_coach->execute([
        'coach_id' => $_POST['coach_id']
    ]);

    // 如果教練狀態更新成功，提交交易
    if($stmt_coach->rowCount()) {
        $pdo->commit();
        $output['success'] = true;
    } else {
        // 如果沒有更新任何資料，回滾交易
        $pdo->rollBack();
        $output['error'] = '找不到該教練';
    }

} catch(PDOException $ex) {
    // 發生錯誤時回滾交易
    $pdo->rollBack();
    $output['error'] = '資料更新發生錯誤：' . $ex->getMessage();
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);