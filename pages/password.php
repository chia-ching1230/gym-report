<?php
$password = "123456"; // 原始密碼
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password; // 這個結果就是要存入資料庫的值