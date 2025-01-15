<?php
# 權限管控
if (! isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
