<?php
session_start();

# 移除陣列裡的某個屬性
unset($_SESSION['admin']);

# 預設回到首頁
$come_from = 'index_.php';
if (isset($_SERVER['HTTP_REFERER'])) {
  # 從哪個頁面來的
  $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");