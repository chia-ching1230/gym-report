<?php
require __DIR__ . '/includes/init.php';

$gym_id = isset($_GET['gym_id']) ? intval($_GET['gym_id']) : 0;
$output = [
    'success' => false , 
    'bodyData' => $_POST, 
    'code' =>0, 
    'error'=>'', 
    'lastInsertId' =>0,
    'gyms'=>'',
];

if ($gym_id > 0) {
    $sql = "SELECT * FROM gyms WHERE gym_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$gym_id]);
    $gyms = $stmt->fetch();

    if ($gyms) {
            $output['success'] = true;
            $output['gyms'] = $gyms;
    } else {
        $output['error'] = '據點不存在';
    }
} else {
    $output['error'] = '據點ID無效';
}

echo json_encode($output,JSON_UNESCAPED_UNICODE);