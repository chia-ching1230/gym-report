<?php
// 沒啟動再啟動
if(!isset($_SESSION)){
    session_start();
}
// 連線資料庫
require __DIR__.'/db-connect.php';