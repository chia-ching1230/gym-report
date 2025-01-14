<?php
header('Content-Type: application/json');
require __DIR__ . '/includes/init.php';

$output = [
    'success' => false,
    'error' => ''
];

// 檢查 email 是否存在且為 active 狀態
$check_sql = "SELECT COUNT(*) FROM coaches WHERE email = :email AND status = 'active'";
$check_stmt = $pdo->prepare($check_sql);
$check_stmt->execute(['email' => $_POST['email']]);

if ($check_stmt->fetchColumn() > 0) {
    $output['error'] = 'duplicate_email';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

// 檢查是否為 inactive 狀態的 email
$check_inactive_sql = "SELECT coach_id FROM coaches WHERE email = :email AND status = 'inactive'";
$check_inactive_stmt = $pdo->prepare($check_inactive_sql);
$check_inactive_stmt->execute(['email' => $_POST['email']]);
$inactive_coach = $check_inactive_stmt->fetch();

try {
    if ($inactive_coach) {
        // 如果是 inactive 的 email，更新該筆資料
        $sql = "UPDATE coaches SET 
        name = ?,
        coach_number = ?,
        specialty = ?,
        phone = ?,
        profile_image = ?,
        bio = ?,
        status = 'active'
        WHERE coach_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['name'],
            $_POST['coach_number'],
            $_POST['specialty'],
            $_POST['phone'],
            $_POST['profile_image'],
            $_POST['bio'],
            $inactive_coach['coach_id']
        ]);
    } else {
        // 完全新的 email，執行插入
        $sql = "INSERT INTO coaches (
            name,
            coach_number,
            specialty,
            email,
            phone,
            profile_image,
            bio,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['name'],
            $_POST['coach_number'],
            $_POST['specialty'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['profile_image'],
            $_POST['bio'],
            'active'
        ]);

    }
    $output['success'] = true;
} catch (PDOException $ex) {
    error_log('SQL Error: ' . $ex->getMessage());
    error_log('Error Code: ' . $ex->getCode());
    error_log('Error Info: ' . print_r($ex->errorInfo, true));
    $output['error'] = '新增/更新失敗: ' . $ex->getMessage();
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);