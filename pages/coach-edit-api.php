<?php require __DIR__ . '/includes/init.php';

header('Content-Type: application/json');


$output = [
    'success' => false,
    'bodyData' => $_POST,
    'code' => 0,
    'error' => "",
];


// 先檢查除了目前這筆資料以外，是否有其他資料使用相同的 email
$sql = "SELECT * FROM coaches WHERE email=? AND coach_id!=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_POST['email'], $_POST['coach_id']]);

if ($stmt->rowCount() > 0) {
    $output['success'] = false;
    $output['error'] = 'duplicate_email';
    echo json_encode($output);
    exit;
}



$sql = "UPDATE `coaches` SET 
    `name` = ?,
    `specialty` = ?,
    `email` = ?,
    `phone` = ?,
    `profile_image` = ?,
    `bio` = ?
WHERE `coach_id` = ? ";



# ********* TODO: 欄位檢查 *************
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
if (!$email) {
    $output['code'] = 401; # 自行決定的除錯編號
    $output['error'] = '請填寫正確的 Email !';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_POST['name'])) {
    $output['code'] = 405;
    $output['error'] = '請填寫教練姓名';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
;





// # *** 處理日期
// if (empty($_POST['course_date'])) {
//     $course_date = null;
// } else {
//     $course_date = strtotime($_POST['course_date']); # 轉換成 timestamp
//     if ($course_date === false) {
//         // 如果格式是錯的, 無法轉換
//         $course_date = null;
//     } else {
//         $course_date = date("Y-m-d", $course_date);
//     }
// }
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST["name"],
    $_POST["specialty"],
    $_POST["email"],
    $_POST["phone"],
    $_POST["profile_image"],
    $_POST["bio"],
    $_POST["coach_id"]
]);

$output["success"] = !!$stmt->rowCount();


echo json_encode($output, JSON_UNESCAPED_UNICODE);