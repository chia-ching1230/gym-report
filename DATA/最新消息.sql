CREATE TABLE gym_news (
    news_id INT AUTO_INCREMENT PRIMARY KEY,  
    title VARCHAR(255) NOT NULL,                
    content TEXT NOT NULL,                      
    author_id INT NOT NULL,                      
    uploadStatus INT DEFAULT 0,                  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);
INSERT INTO gym_news (title, content, author_id, upload_status, created_at, updated_at) VALUES
('健身房最新開設瑜伽課程', '我們的健身房將於下個月開始提供瑜伽課程，歡迎大家報名參加！', 1, 1, NOW(), NOW()),
('夏季優惠活動開始了', '我們的夏季優惠活動開始了，現在報名即可享受9折優惠！', 2, 1, NOW(), NOW()),
('新的健身器材上架', '我們的健身房已經更新了全新的健身器材，快來體驗吧！', 3, 1, NOW(), NOW()),
('健身挑戰賽活動', '健身房將於下個月舉辦健身挑戰賽，獎品豐富，大家不要錯過！', 4, 1, NOW(), NOW()),
('節假日開放時間公告', '即將到來的節假日期間，健身房將按照特別時間營業，請查詢具體時間表。', 5, 1, NOW(), NOW()),
('加入我們的團隊，招聘健身教練', '我們正在招聘全職健身教練，如果你有健身經驗並熱愛這份工作，快來加入我們！', 6, 0, NOW(), NOW()),
('新設計健身房布局', '我們近期對健身房進行了重新設計，新增了更多運動空間，提升了整體的使用體驗。', 7, 1, NOW(), NOW()),
('健身房會員專屬優惠券', '健身房為所有會員提供專屬的優惠券，可在下次使用時享受折扣。', 8, 1, NOW(), NOW()),
('健康飲食講座即將開講', '我們將舉辦一次健康飲食講座，專家將分享如何在健身的同時保持均衡飲食。', 9, 1, NOW(), NOW()),
('健身房即將舉辦公益活動', '健身房將於下個月舉辦公益活動，邀請大家來一起參加，為社區貢獻愛心。', 10, 0, NOW(), NOW());
