<?php
require __DIR__ . '/includes/init.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'bodyData' => $_POST,
    'code' => 0,
    'error' => "",
    'lastInsertId' => 0,
];

// 預約新增
function createAppointment() {
    global $pdo, $output;
    
    $sql = "INSERT INTO appointments (
        member_id, 
        course_id,
        status,
        created_at
    ) VALUES (?, ?, 'pending', NOW())";
    
    if (empty($_POST['member_id'])) {
        $output['code'] = 405;
        $output['error'] = '請選擇會員';
        return $output;
    }
    
    if (empty($_POST['course_id'])) {
        $output['code'] = 405;
        $output['error'] = '請選擇課程';
        return $output;
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['member_id'],
        $_POST['course_id']
    ]);
    
    $output['success'] = !!$stmt->rowCount();
    $output['lastInsertId'] = $pdo->lastInsertId();
    return $output;
}

// 路由處理
$result = createAppointment();
echo json_encode($result, JSON_UNESCAPED_UNICODE);