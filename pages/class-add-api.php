<?php require __DIR__ . '/includes/init.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'bodyData' => $_POST,
    'code' => 0,
    'error' => "",
    'lastInsertId' => 0,
];
$sql = "INSERT INTO courses (`course_name`, `course_description`, `coach_id`, `course_date`, `course_time`) 
VALUES (?, ?, ?, ?, ?)";

// if (empty($_POST['course_name'])) {
//     $output['code'] = 405;
//     $output['error'] = '請填寫課程名稱';
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// };


# *** 處理日期
if (empty($_POST['course_date'])) {
    $course_date = null;
} else {
    $course_date = strtotime($_POST['course_date']); # 轉換成 timestamp
    if ($course_date === false) {
        // 如果格式是錯的, 無法轉換
        $course_date = null;
    } else {
        $course_date = date("Y-m-d", $course_date);
    }
}
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST["course_name"],
    $_POST["course_description"],
    $_POST["coach_id"],
    $course_date,
    $_POST["course_time"]
]);

$output["success"] = !!$stmt->rowCount();
$output["lastInsertId"] = $pdo->lastInsertId();

echo json_encode($output, JSON_UNESCAPED_UNICODE);