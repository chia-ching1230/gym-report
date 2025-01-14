<?php


require __DIR__ . '/includes/init.php';

# 取得指定的 PK
$course_id = empty($_GET['course_id']) ? 0 : intval($_GET['course_id']);

if ($course_id) {
  $sql = "DELETE FROM `courses` WHERE course_id={$course_id} ";
  $pdo->query($sql);
}

$come_from = 'class.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  # 從哪個頁面來的
  $come_from = $_SERVER['HTTP_REFERER'];
}


header("Location: $come_from");
