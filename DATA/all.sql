-- DROP DATABASE gym_database;
CREATE DATABASE gym_database;
USE gym_database;

CREATE TABLE appointments (
  appointment_id int NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  member_id int NOT NULL,
  course_id int NOT NULL,
  status enum('pending','confirmed','cancelled')  DEFAULT 'pending',
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- course課程
CREATE TABLE `courses` (
  `course_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `course_name` varchar(255)  DEFAULT NULL,
  `course_description` text ,
  `coach_id` int DEFAULT NULL,
  `course_date` date DEFAULT NULL,
  `course_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
INSERT INTO `courses` (`course_id`, `course_name`, `course_description`, `coach_id`, `course_date`, `course_time`) VALUES
(1, '初級瑜珈', '適合初學者的基礎瑜珈課程，專注於基本姿勢和呼吸技巧', 1, '2025-01-20', '09:00:00'),
(2, '進階瑜珈', '針對有經驗者的進階瑜珈課程，包含更具挑戰性的姿勢', 2, '2025-01-21', '10:30:00'),
(3, '皮拉提斯', '核心訓練與身體協調性提升課程', 3, '2025-01-22', '14:00:00'),
(4, '有氧舞蹈', '充滿活力的舞蹈有氧運動，適合各年齡層', 4, '2025-01-23', '16:00:00'),
(5, '核心訓練', '強化腹部和背部肌群的專項訓練課程', 5, '2025-01-24', '11:00:00'),
(6, '伸展放鬆', '緩解壓力和肌肉緊張的伸展課程', 1, '2025-01-25', '15:30:00'),
(7, '功能性訓練', '提升日常生活動作能力的綜合訓練', 2, '2025-01-26', '13:00:00'),
(8, '冥想課程', '專注力訓練與壓力管理課程', 3, '2025-01-27', '08:30:00'),
(9, '瑜珈療癒', '結合瑜珈與身心靈療癒的特色課程', 4, '2025-01-28', '17:00:00'),
(10, '體態雕塑', '全身性的肌肉訓練與體態調整課程', 5, '2025-01-29', '10:00:00'),
(11, '晨間瑜珈', '啟動一天的活力瑜珈課程', 1, '2025-01-30', '07:00:00'),
(12, '墊上核心', '專注於核心肌群訓練的墊上運動', 2, '2025-01-31', '12:00:00'),
(13, '舒緩瑜珈', '緩解身體疲勞的溫和瑜珈課程', 3, '2025-02-01', '16:30:00'),
(14, '肌力訓練', '增進整體肌力的重量訓練課程', 4, '2025-02-02', '14:30:00'),
(15, '彈力帶訓練', '使用彈力帶的全身性訓練課程', 5, '2025-02-03', '11:30:00'),
(16, '體態調整', '改善姿勢和體態的專業課程', 1, '2025-02-04', '09:30:00'),
(17, '呼吸練習', '專注於呼吸技巧和身心平衡的課程', 2, '2025-02-05', '15:00:00'),
(18, '柔軟度訓練', '提升全身柔軟度的系統性訓練', 3, '2025-02-06', '13:30:00'),
(19, '平衡訓練', '增進身體平衡感與協調性的課程', 4, '2025-02-07', '10:30:00'),
(20, '體能訓練', '全方位提升體能的綜合訓練課程', 5, '2025-02-08', '16:00:00');

-- coach
CREATE TABLE `coaches` (
  `coach_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100)  NOT NULL,
  `specialty` varchar(255)  DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_image` varchar(255)  DEFAULT NULL,
  `bio` text,
  `status` enum('active','inactive') DEFAULT'active',
  `coach_number` varchar(100)  NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
INSERT INTO coaches (coach_id, name, specialty, email, phone, profile_image, bio, status, coach_number) VALUES
(1, '張育瑄', '瑜珈,皮拉提斯', 'yuhsuan.chang@email.com', '0912-345-678', 'coach1.jpg', '專業瑜珈教練，擁有10年教學經驗，專精於初學者指導與體態調整。', 'active', 'C001'),
(2, '林明宏', '重量訓練,核心訓練', 'minghong.lin@email.com', '0923-456-789', 'coach2.jpg', '資深健身教練，擅長制定個人化訓練計畫，協助學員達成健身目標。', 'active', 'C002'),
(3, '王雅婷', '舞蹈,有氧運動', 'yating.wang@email.com', '0934-567-890', 'coach3.jpg', '專業舞蹈老師，教學風格活潑生動，善於帶動課堂氣氛。', 'active', 'C003'),
(4, '李志豪', '功能性訓練,肌力訓練', 'zhihao.lee@email.com', '0945-678-901', 'coach4.jpg', '運動科學碩士，專注於姿勢矯正與功能性訓練指導。', 'active', 'C004'),
(5, '陳思穎', '瑜珈,冥想', 'siying.chen@email.com', '0956-789-012', 'coach5.jpg', '具有多年靜心冥想教學經驗，專注於心靈療癒與壓力管理。', 'active', 'C005'),
(6, '吳建志', '伸展,體態調整', 'jianzhi.wu@email.com', '0967-890-123', 'coach6.jpg', '物理治療師背景，專精於身體評估與矯正運動設計。', 'active', 'C006'),
(7, '許雅琪', '皮拉提斯,核心訓練', 'yaqi.xu@email.com', '0978-901-234', 'coach7.jpg', '美國皮拉提斯認證教練，專精於產後恢復與體態雕塑。', 'active', 'C007'),
(8, '黃志偉', '重量訓練,體能訓練', 'zhiwei.huang@email.com', '0989-012-345', 'coach8.jpg', '前職業運動員，擅長運動表現提升與體能訓練規劃。', 'inactive', 'C008'),
(9, '楊曉君', '舞蹈,彈力帶訓練', 'xiaojun.yang@email.com', '0990-123-456', 'coach9.jpg', '專業舞者出身，結合舞蹈與體適能訓練的創新課程設計。', 'active', 'C009'),
(10, '蔡明達', '瑜珈,平衡訓練', 'mingda.tsai@email.com', '0901-234-567', 'coach10.jpg', '資深瑜珈教練，專注於體式調整與呼吸技巧指導。', 'active', 'C010');



-- gym點 資料表，將營業星期放在開門時間前面
CREATE TABLE gyms (
  gym_id  SERIAL PRIMARY KEY,        
  name VARCHAR(255) NOT NULL,        
  address VARCHAR(255),            
  business_days TEXT,  -- 營業星期，存儲為逗號分隔的字串
  opening_hours TIME,              
  closing_hours TIME,  -- 結束營業時間
  description TEXT,  -- 描述
  contact_info VARCHAR(50),               
  email VARCHAR(255),  -- 電子郵件
  manager VARCHAR(50),  -- 負責人
  image_url VARCHAR(255),  -- 新增圖片 URL 欄位
  google_map_link VARCHAR(255),  -- 新增 Google 地圖連結
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- 自動記錄創建時間
);


-- 插入資料，營業星期作為逗號分隔字串
INSERT INTO gyms (name, address, business_days, opening_hours, closing_hours, description, contact_info, email, manager, image_url, google_map_link)
VALUES
('健身房A', '台南市中華東路100號', 'Monday, Tuesday, Wednesday, Thursday, Friday', '08:00:00', '22:00:00', '提供各類健身器材，適合健身初學者與進階者使用，並提供專業指導課程。', '06-1234-567', 'contactA@gym.com', '王大明', 'https://example.com/images/gymA.jpg', 'https://goo.gl/maps/abc123'),
('健身房B', '台南市永康區中正路200號', 'Monday, Tuesday, Wednesday, Thursday, Friday, Saturday', '07:00:00', '23:00:00', '擁有先進的重訓設備及寬敞的游泳池，設有個人化健身計劃設計服務。', '06-2345-678', 'contactB@gym.com', '李小華', 'https://example.com/images/gymB.jpg', 'https://goo.gl/maps/def456'),
('健身房C', '台南市安平區建國路300號', 'Tuesday, Wednesday, Thursday, Friday, Saturday', '06:30:00', '21:30:00', '提供多樣的有氧運動課程及高效的跑步機，環境清新舒適。', '06-3456-789', 'contactC@gym.com', '張志強', 'https://example.com/images/gymC.jpg', 'https://goo.gl/maps/ghi789'),
('健身房D', '台南市北區成功路400號', 'Monday, Wednesday, Friday, Saturday', '09:00:00', '20:00:00', '專業拳擊訓練課程、自由重訓區，專注於力量與耐力的提升。', '06-4567-890', 'contactD@gym.com', '陳美麗', 'https://example.com/images/gymD.jpg', 'https://goo.gl/maps/jkl012'),
('健身房E', '台南市西區府前路500號', 'Monday, Tuesday, Wednesday, Thursday, Friday', '08:00:00', '22:30:00', '提供各式團體課程及無氧設備，讓您更有效率地達成健身目標。', '06-5678-901', 'contactE@gym.com', '林俊杰', 'https://example.com/images/gymE.jpg', 'https://goo.gl/maps/mno345');

-- 文章列表 
CREATE TABLE articles (
    article_id INTEGER PRIMARY KEY auto_increment,
    title VARCHAR(255),
    content TEXT,
    author_id VARCHAR(50),
    uploadStatus INTEGER,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO articles (title, content, author_id,uploadStatus) VALUES
('如何開始健身：初學者指南', '健身對許多人來說是個全新的挑戰，對於初學者而言，最重要的是從基礎開始，避免過度訓練而受傷。本文將介紹如何開始健身，包括選擇適合自己的運動項目、如何安排每週的訓練計劃、以及訓練前後應該注意的事項。對於初學者，最好的建議是從輕度的有氧運動和基礎力量訓練入手，逐步增加強度與挑戰。', 'c25002',0),
('健身與飲食的關聯性', '很多人會認為只要多運動就能保持健康或減重，但其實飲食在健身過程中扮演著更為關鍵的角色。本文將深入探討運動和飲食的關係，從蛋白質的攝取到碳水化合物和脂肪的平衡，幫助你了解如何通過調整飲食來提升健身效果。飲食應該根據個人的健身目標來調整，增肌的人需要更多的蛋白質，而減脂的人則需要控制碳水化合物的攝取量。', 'c25001',1),
('高效燃脂的運動方式', '如果你的目標是燃燒脂肪，選擇正確的運動方式至關重要。本文將介紹幾種高效的燃脂運動，包括有氧運動（如跑步、游泳、騎自行車等）和高強度間歇訓練（HIIT）。這些運動不僅能幫助你在訓練中燃燒大量卡路里，還能提高新陳代謝，讓你在運動後持續燃燒脂肪。了解每種運動的特點，選擇最適合自己的方式，並且搭配適當的飲食，才能達到最佳燃脂效果。', 'c25002',1),
('增肌飲食建議：如何增加肌肉量', '增肌不僅僅是進行重量訓練，更重要的是合理的飲食計劃。本文將分享一些增肌飲食的基本原則，包括高蛋白飲食、適量的碳水化合物和健康的脂肪來源。增肌期間應該攝取足夠的蛋白質以支持肌肉修復與增長，並且保持熱量盈餘來促進肌肉的合成。此外，飲食時間的安排也很關鍵，運動前後攝取合適的營養有助於增肌效果。','c25002',1),
('如何避免健身過度訓練', '過度訓練是許多健身愛好者的常見問題，尤其是對於那些熱衷於快速達到健身目標的人來說。過度訓練會導致身體疲勞、免疫力下降、以及肌肉受傷。本文將討論如何避免過度訓練，並介紹有效的休息與恢復策略。合理安排訓練頻率、避免重複高強度訓練、並且注意聽從身體的信號，這些都是防止過度訓練的關鍵。', 'c25002',1),
('每週健身計劃：如何設置訓練目標', '設定一個具體的每週健身計劃是達到健身目標的關鍵。本文將教你如何根據自己的目標設置一個合理的每週訓練計劃，無論你的目標是減脂、增肌還是提高耐力。建立一個合理的訓練計劃不僅要考慮運動類型，還要充分考慮休息與恢復的時間，以避免過度訓練。每週的計劃應該有足夠的挑戰性，同時保持可持續性，這樣才能達到長期的健身效果。', 'c25002',0),
('居家健身器材推薦', '無需去健身房，居家也可以輕鬆進行高效訓練。本文將介紹幾款推薦的居家健身器材，包括啞鈴、彈力帶、壺鈴和瑜伽墊等，這些器材可以幫助你進行力量訓練、拉伸和瑜伽等各類運動。適合居家的健身器材不僅佔用空間小，而且價格相對便宜，是提升健身效果的好幫手。了解如何利用這些器材進行不同的運動，幫助你在家也能保持健康與身形。', 'c25002',0),
('運動後如何進行恢復', '運動後的恢復過程對於增強訓練效果及防止受傷至關重要。本文將探討運動後應該做哪些恢復工作，包括伸展、按摩、補充水分、補充營養等。適當的恢復不僅能緩解肌肉酸痛，還能促進肌肉的修復與增長。本文將提供一些具體的恢復技巧，如使用泡沫軸進行自我按摩，或者進行低強度的有氧運動來促進血液循環。', 'c25004',1),
('核心肌群訓練：必做的幾個動作', '強健的核心肌群對於日常生活中的動作和運動表現至關重要。本文將介紹幾個經典且高效的核心訓練動作，包括平板支撐、俄式轉體、死蟲式等。這些動作可以幫助你提升腹部、背部和髖部的穩定性，對於提高運動表現和預防運動傷害都有極大幫助。每週進行幾次核心訓練，讓你的核心更加穩定，動作更流暢。', 'c25002',1),
('有氧運動與重量訓練的區別', '有氧運動和重量訓練在健身中的作用各有不同。本文將分析有氧運動（如跑步、游泳）與重量訓練（如舉重、阻力訓練）的區別，並討論它們對健身目標的影響。有氧運動有助於提升心肺功能，增強耐力，而重量訓練則有助於增強肌肉力量與增肌。了解它們的不同，可以根據自己的目標選擇適合的運動方式，並將兩者結合起來達到全面的健身效果。', 'c25002',1),
('健身中的常見誤區', '在健身過程中，許多人會犯一些常見的誤區，這些誤區可能會影響到健身效果，甚至導致受傷。本文將列舉一些常見的健身誤區，包括過度依賴有氧運動、忽略力量訓練、過度訓練等，並提供如何避免這些誤區的建議。了解這些誤區，幫助你更加科學、有效地進行訓練，從而達到最佳的健身效果。', 'c25001',0),
('如何提高運動表現：訓練技巧分享', '想要提高運動表現，除了勤加練習，還需要掌握一些訓練技巧。本文將分享一些提升運動表現的小技巧，包括如何正確進行熱身、如何安排訓練計劃、如何進行有效的力量訓練等。掌握這些技巧，能夠讓你的訓練更加高效，提升運動表現，達到更好的健身效果。', 'c25005',0),
('健身中的營養補充：你需要知道的事情', '健身時，適當的營養補充至關重要，特別是蛋白質的攝取。本文將介紹健身過程中的營養補充，包括運動前後如何補充營養，補充蛋白質的最佳時間，以及如何根據訓練強度選擇合適的營養品。合理的營養補充能幫助你的肌肉更快恢復，達到更好的增肌效果。', 'c25002',1),
('減重期間如何保持肌肉量', '在減重的過程中，如何保持肌肉量是非常關鍵的。本文將分享一些保持肌肉量的技巧，包括如何設計訓練計劃、如何進行合理的飲食調整、以及如何避免過度減少熱量攝取等。保持足夠的蛋白質攝取並搭配力量訓練，是減重期間保持肌肉量的關鍵。', 'c25002',1),
('簡單的伸展運動，預防運動傷害', '伸展運動對於預防運動傷害非常重要，尤其是進行高強度訓練或長時間坐著工作後。本文將介紹一些簡單易學的伸展動作，幫助你保持肌肉的靈活性和彈性。這些動作可以幫助你減少受傷的風險，並促進肌肉的恢復。', 'c25002',0),
('如何使用健身追蹤器來提高訓練效果', '健身追蹤器能幫助你更好地監控訓練過程，進一步提升運動效果。本文將介紹如何使用健身追蹤器來測量心率、計算卡路里消耗、跟蹤訓練進度等。通過數據分析，你可以更精確地了解自己訓練的強度與效果，從而做出調整，提升健身效果。', 'c25002',1),
('有效的肌肉恢復方法：放鬆與按摩技巧', '運動後的肌肉恢復是提高訓練效果的關鍵。本文將介紹一些有效的肌肉恢復方法，包括使用泡沫軸進行自我按摩、深層組織按摩以及靜態拉伸等。這些方法能幫助放鬆肌肉，減少酸痛，並加速肌肉恢復。', 'c25003',0),
('為什麼你的健身計劃無法成功？', '很多人都會在健身計劃開始時充滿熱情，但過了一段時間後發現成效不如預期。本文將分析為什麼健身計劃無法成功，並提供一些解決方案，幫助你克服困難，持之以恆。', 3,0);

-- 最新消息 
CREATE TABLE gym_news (
    news_id INT AUTO_INCREMENT PRIMARY KEY,  
    title VARCHAR(255) NOT NULL,                
    content TEXT NOT NULL,                      
    author_id VARCHAR(50) NOT NULL,                      
    uploadStatus INT DEFAULT 0,                  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);
INSERT INTO gym_news (title, content, author_id, uploadStatus) VALUES
('健身房最新開設瑜伽課程', '我們的健身房將於下個月開始提供瑜伽課程，歡迎大家報名參加！', 'a2025001', 1),
('夏季優惠活動開始了', '我們的夏季優惠活動開始了，現在報名即可享受9折優惠！', 'a2025001', 1),
('新的健身器材上架', '我們的健身房已經更新了全新的健身器材，快來體驗吧！', 'a2025001', 1),
('健身挑戰賽活動', '健身房將於下個月舉辦健身挑戰賽，獎品豐富，大家不要錯過！', 'a2025001', 1),
('節假日開放時間公告', '即將到來的節假日期間，健身房將按照特別時間營業，請查詢具體時間表。', 'a2025001', 1),
('加入我們的團隊，招聘健身教練', '我們正在招聘全職健身教練，如果你有健身經驗並熱愛這份工作，快來加入我們！', 'a2025001', 0),
('新設計健身房布局', '我們近期對健身房進行了重新設計，新增了更多運動空間，提升了整體的使用體驗。', 'a2025001', 1),
('健身房會員專屬優惠券', '健身房為所有會員提供專屬的優惠券，可在下次使用時享受折扣。', 'a2025001', 1),
('健康飲食講座即將開講', '我們將舉辦一次健康飲食講座，專家將分享如何在健身的同時保持均衡飲食。', 'a2025001', 1),
('健身房即將舉辦公益活動', '健身房將於下個月舉辦公益活動，邀請大家來一起參加，為社區貢獻愛心。', 'a2025001', 0);


USE gym_database;

CREATE TABLE member_basic (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
     member_name VARCHAR(100),
    birthday DATE,
    gender ENUM('male', 'female'),
    phone VARCHAR(20),
    address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE member_profile (
    profile_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    height DECIMAL(5, 2),
    weight DECIMAL(5, 2),
    fitness_goals TEXT NOT NULL, 
    bio TEXT,
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES member_basic(member_id)
);

CREATE TABLE member_auth (
    auth_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT,
    email VARCHAR(255),
    member_password VARCHAR(255),
    last_login TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES member_basic(member_id)
);


INSERT INTO member_basic (member_name, birthday, gender, phone, address) 
VALUES
('張大明', '1990-01-15', 'male', '0912345678', '台北市信義區松山路123號'),
('李小美', '1985-03-22', 'female', '0912345679', '台中市西區建國路456號'),
('王志明', '1992-06-18', 'male', '0912345680', '高雄市左營區自由路789號'),
('陳怡君', '1988-11-02', 'female', '0912345681', '新北市板橋區中正路101號'),
('林子明', '1995-02-10', 'male', '0912345682', '桃園市中壢區忠孝路234號'),
('黃怡婷', '1993-05-25', 'female', '0912345683', '台北市大安區復興南路567號'),
('劉建國', '1980-07-30', 'male', '0912345684', '台中市南區建國路890號'),
('許思萱', '1994-10-05', 'female', '0912345685', '高雄市三民區大順路123號'),
('張家瑜', '1989-09-17', 'male', '0912345686', '台南市東區中華路456號'),
('李芷涵', '1996-12-03', 'female', '0912345687', '新北市三重區正義路789號'),
('周小鵬', '1992-07-30', 'male', '0912345688', '台北市內湖區港墘路234號'),
('劉思華', '1991-03-17', 'female', '0912345689', '高雄市苓雅區和平路567號'),
('陳宏志', '1987-05-24', 'male', '0912345690', '台中市北區崇德路890號'),
('林心如', '1994-11-09', 'female', '0912345691', '新竹市東區光復路123號'),
('鄭永成', '1993-01-05', 'male', '0912345692', '台南市西區府前路456號'),
('楊麗華', '1986-09-29', 'female', '0912345693', '台北市松山區南京東路789號'),
('張家豪', '1990-12-20', 'male', '0912345694', '新北市中和區建國路123號'),
('王美霞', '1995-07-12', 'female', '0912345695', '高雄市左營區忠孝路456號'),
('林明杰', '1988-10-17', 'male', '0912345696', '台中市西區民權路789號'),
('黃怡文', '1996-08-02', 'female', '0912345697', '新竹市北區光華路123號'),
('周建中', '1994-04-13', 'male', '0912345698', '高雄市前鎮區中山路456號'),
('張晨輝', '1990-11-25', 'female', '0912345699', '台北市大同區重慶北路789號'),
('陳健熙', '1987-03-08', 'male', '0912345700', '台中市南區建國路123號'),
('林麗瑄', '1993-06-14', 'female', '0912345701', '台南市中西區府前路456號'),
('劉俊傑', '1991-02-19', 'male', '0912345702', '新北市汐止區樹林路789號'),
('王曉雯', '1994-09-10', 'female', '0912345703', '台中市東區中華路123號'),
('李信豪', '1995-11-15', 'male', '0912345704', '台北市中正區南京東路456號'),
('周佳儀', '1989-08-22', 'female', '0912345705', '高雄市鳳山區建國路789號'),
('張子堯', '1993-04-05', 'male', '0912345706', '台南市東區中華路123號'),
('李秋儀', '1991-02-10', 'female', '0912345707', '新北市板橋區中正路234號'),
('楊紫婷', '1992-07-30', 'male', '0912345708', '高雄市左營區自由路789號'),
('王子豪', '1994-06-19', 'female', '0912345709', '台北市內湖區民權東路456號');


INSERT INTO member_profile (member_id, height, weight, fitness_goals, bio, profile_image) VALUES
(1, 170.50, 65.20, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '熱愛戶外活動，喜歡挑戰自我，擁有積極的健身習慣。', 'profile1.jpg'),
(2, 160.80, 54.10, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '享受健身房的時光，經常參加團體運動課程。', 'profile2.jpg'),
(3, 175.00, 70.50, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '我喜歡跑步和游泳，平時也會參加競技活動。', 'profile3.jpg'),
(4, 168.20, 58.40, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '健身是一種減壓方式，也希望結識更多志同道合的朋友。', 'profile4.jpg'),
(5, 165.70, 60.80, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '喜歡在健身中尋找自己的節奏，專注於長期的運動訓練。', 'profile5.jpg'),
(6, 172.30, 68.10, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '專注於康復訓練，希望提升身體機能和健康水平。', 'profile6.jpg'),
(7, 160.00, 50.50, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '跑步是我最大的興趣，健身讓我保持能量滿滿。', 'profile7.jpg'),
(8, 178.00, 75.00, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '對力量訓練充滿熱情，正在準備參加舉重比賽。', 'profile8.jpg'),
(9, 165.50, 55.00, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '健身幫助我釋放壓力，也讓我逐步實現身體目標。', 'profile9.jpg'),
(10, 170.10, 60.30, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '熱愛健康生活方式，擁有規律的運動習慣。', 'profile10.jpg'),
(11, 162.40, 52.20, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '我喜歡跳舞和有氧運動，這是我保持身心健康的方法。', 'profile11.jpg'),
(12, 180.00, 80.00, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '希望提升我的力量與速度，參與更多運動賽事。', 'profile12.jpg'),
(13, 168.80, 65.50, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '喜歡健走和騎車，享受戶外運動的樂趣。', 'profile13.jpg'),
(14, 172.60, 69.30, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '專注於長期的身體素質提升，健身讓我心情更好。', 'profile14.jpg'),
(15, 167.90, 57.10, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '我喜歡瑜伽和普拉提，這幫助我平衡身心。', 'profile15.jpg'),
(16, 176.40, 72.20, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '我的目標是參加馬拉松，並達到個人最佳狀態。', 'profile16.jpg'),
(17, 162.10, 51.40, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '跑步和冥想是我的日常，享受健康的生活方式。', 'profile17.jpg'),
(18, 169.50, 64.20, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '熱衷於力量訓練，希望挑戰更高的極限。', 'profile18.jpg'),
(19, 175.20, 71.80, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '喜歡團體運動和戶外活動，希望擴展交友圈。', 'profile19.jpg'),
(20, 170.80, 63.40, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '健身讓我保持專注和健康，希望完成長跑挑戰。', 'profile20.jpg'),
(21, 161.50, 53.00, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '我喜歡游泳和散步，這幫助我放鬆心情。', 'profile21.jpg'),
(22, 177.00, 78.30, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '健身是一種挑戰，也是一種熱情的表現。', 'profile22.jpg'),
(23, 166.70, 59.00, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '瑜伽和跳舞是我平時的愛好，幫助我保持活力。', 'profile23.jpg'),
(24, 173.50, 66.80, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '專注於健康管理，目標是達到更好的身材比例。', 'profile24.jpg'),
(25, 165.80, 55.70, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '喜歡健身房訓練，並規劃了個人的健身計畫。', 'profile25.jpg'),
(26, 178.20, 74.90, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '希望提升力量並保持身體健康，健身是一種生活方式。', 'profile26.jpg'),
(27, 163.40, 50.80, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '經常參加有氧運動課程，喜歡跳舞和普拉提。', 'profile27.jpg'),
(28, 171.70, 68.10, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '目標是完成一次登山挑戰，並提升體能。', 'profile28.jpg'),
(29, 159.90, 49.50, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量','我喜歡普拉提和瑜伽，這是我平衡身心的方式。', 'profile29.jpg'),
(30, 180.50, 82.40, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量','希望提升速度和耐力，成為更好的運動員。', 'profile30.jpg'),
(31, 172.50, 65.80, '增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量', '我是一名戶外運動愛好者，特別熱愛登山與跑步，並定期進行力量訓練來保持體能。', 'profile31.jpg'),
(32, 168.90, 58.70,'增肌, 減脂, 提高耐力, 增強體能 ,健康維持, 提高核心能量','平時喜歡瑜伽與普拉提，熱衷於通過運動來釋放壓力並保持身體健康。', 'profile32.jpg');


UPDATE member_auth SET member_password = '$2b$12$Fv.SV/04S5/Oc3zeyDeLHOu515QueVPkcMRkQExfVvOPE9lKGwddG' WHERE member_id = 1;
UPDATE member_auth SET member_password = '$2b$12$lLuXtZlRWncq1xohn7KEw.59BJM1vXRx.4LdfUL3N9syrogzDAMGu' WHERE member_id = 2;
UPDATE member_auth SET member_password = '$2b$12$V0IVgS45JcSGaio5kDsw.OKaTw1QvUg1VMqhxKpu.s6Yil8dRcHt2' WHERE member_id = 3;
UPDATE member_auth SET member_password = '$2b$12$EdjympMT41PI7/39KDbE3ukwGxXmUcs3AhxxHqcb4qIkVMZhCSewa' WHERE member_id = 4;
UPDATE member_auth SET member_password = '$2b$12$INL5mmfqRxoId4MwUkgh2O8lhjz2OTeehLJdcnXiUrQQCezAiLcMa' WHERE member_id = 5;
UPDATE member_auth SET member_password = '$2b$12$kbXtjAjf4V/Z0acJ1zAgMejWIoG4mGuMKPgAFT7OTcj1cwBEM7lN2' WHERE member_id = 6;
UPDATE member_auth SET member_password = '$2b$12$yzVVpcrHWiMxMouPqaUJOuXv9Wy9bBBckEhqAGyX6kWvaqbWfpRZa' WHERE member_id = 7;
UPDATE member_auth SET member_password = '$2b$12$F6zM8ZJNR6jnZY84lwRKSOBiasMvRo3Eu1djuwR3KnSlzqvbR/e6y' WHERE member_id = 8;
UPDATE member_auth SET member_password = '$2b$12$S9OzbvrAz6mvEN6bbvgSPeV2hDXvYKUoVGpe2rQvQ05z2oLuP/5DK' WHERE member_id = 9;
UPDATE member_auth SET member_password = '$2b$12$IXfFs9mJcNJ740KRFFCeNeZXJPQWjEiqnLxbiGUNrLvR43J0K062q' WHERE member_id = 10;
UPDATE member_auth SET member_password = '$2b$12$u815JsyIyUe3ClJnbzHGEeZBzvFD4nyLGr9bsAuHyx4DEoFR6rTom' WHERE member_id = 11;
UPDATE member_auth SET member_password = '$2b$12$wIKRua.O0nOLIgu4NH4uq./eD6HnA6YTzAPM9nJ3vzcOsXS.ZEBUm' WHERE member_id = 12;
UPDATE member_auth SET member_password = '$2b$12$0QtG.ajGwwqHmxRTCOaWQe8u7a2zJT2X1Jb/gOg3LQbaNtpM7pRP.' WHERE member_id = 13;
UPDATE member_auth SET member_password = '$2b$12$oniOxCuIvCIAr1/0tra2keFiiX/4Yo2qPYF/0Yxq2ZSIZZRHIrzrq' WHERE member_id = 14;
UPDATE member_auth SET member_password = '$2b$12$ogPMSWMqQ/rQlifI2al/tu3JMaBB4rTbR8vsphfuNj4LN1uYel1pi' WHERE member_id = 15;
UPDATE member_auth SET member_password = '$2b$12$4.gxTNMi2DFXdQ/nhDUL0eg9YZhtbrED0Zn72RDhad3mKjoPlibg6' WHERE member_id = 16;
UPDATE member_auth SET member_password = '$2b$12$UAetHabM6YWlegZbYG9VROAGDGpfV451V6pJH5sNP8ZOcusR1OVsy' WHERE member_id = 17;
UPDATE member_auth SET member_password = '$2b$12$M866kcXZ1MymtVOCFvAcg.cWb4.1HhyEUl/daBY5aDrPM4G9EU0JG' WHERE member_id = 18;
UPDATE member_auth SET member_password = '$2b$12$aDLcV.NsxoSem9jlAOT35OlkHRAFCzvxYPGc/f9NLjK58OjvknoCq' WHERE member_id = 19;
UPDATE member_auth SET member_password = '$2b$12$0UHKL/W0foJNQ2g1yt2XdeJ3..lTJNVAzntILTGbIb53rYjE/SyHC' WHERE member_id = 20;
UPDATE member_auth SET member_password = '$2b$12$bNGVMsUB18XxSSgVzUehxevPyFA4byJPDNE/auySsYR8LTUzwn54.' WHERE member_id = 21;
UPDATE member_auth SET member_password = '$2b$12$E706u4TZsgOHfWBTWDneVe4b6vdWhfUw5Z2cO.6UlpzTvzARUi2G2' WHERE member_id = 22;
UPDATE member_auth SET member_password = '$2b$12$HMimMdYDnX.Ij4rXItU1kuKpiYng1aLvHagK/USBeexAr5M/n5o5y' WHERE member_id = 23;
UPDATE member_auth SET member_password = '$2b$12$lynuSaFxY0KbAl.yhS0xpOi61TiXv48leGLTDHXVMfFW4Q9ksjW8q' WHERE member_id = 24;
UPDATE member_auth SET member_password = '$2b$12$AJS4vWSDBwCPOIT.QdfWhOXw/QEV8tQGHD.sHUW5bFFr6QPKBWJre' WHERE member_id = 25;
UPDATE member_auth SET member_password = '$2b$12$kIP9J25RfKWzPdOP/TS3..ZwVbBbOfZQxI791HcqzkTmkP27Cnz0G' WHERE member_id = 26;
UPDATE member_auth SET member_password = '$2b$12$OGUzxleK0LSCy/PrGIL5zumiiMGDXUQ5Zs47qoeaaM.Jt4.G9V0qC' WHERE member_id = 27;
UPDATE member_auth SET member_password = '$2b$12$t5x33KSOQYPV2Ja3JvpBVuzvfqL89dvy9HBhFax93SD0MagQIr9su' WHERE member_id = 28;
UPDATE member_auth SET member_password = '$2b$12$Vc1y7HmsWk047wFzXasyPO7Fw7kFwsYAP0hpPqmeC5NFSV74/DUJG' WHERE member_id = 29;
UPDATE member_auth SET member_password = '$2b$12$.i8hh.8xLTvBeKnksGCw7.D57fGM6BjxX915WM0sgVm3bHeQSCyTO' WHERE member_id = 30;
UPDATE member_auth SET member_password = '$2b$12$MdTKnVoZWeRUQsqJDA1Stez.4s5G7GQzv1ZpmCN6JMT5ZMTK9L2CW' WHERE member_id = 31;
UPDATE member_auth SET member_password = '$2b$12$vlUkM0jo3E0Si9yum.6RT.K1Ux0Q.ZDjAEBRLeOO.JogZ0fdm10my' WHERE member_id = 32;
select * from member_auth;
select * from member_profile;
select * from member_basic;



CREATE TABLE Products (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- 主鍵
    product_code VARCHAR(10) NOT NULL UNIQUE,    -- 商品編號 (格式 P001, P002...)
    name VARCHAR(255) NOT NULL,                 -- 商品名稱
    description TEXT,                           -- 商品描述
    category_name VARCHAR(255) NOT NULL,        -- 商品種類名稱
    weight DECIMAL(5, 2),                       -- 商品重量 (可為 NULL)
    base_price DECIMAL(10, 2) NOT NULL,         -- 商品基本價格
    image_url VARCHAR(255),                     -- 圖片路徑或網址
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- 建立時間
);

INSERT INTO Products (product_code, name, description, category_name, weight, base_price, image_url)
VALUES
-- 健身用品類別
('P001', '跑步機', '高性能跑步機，適合各種健身需求。', '健身用品', NULL, 150.00, 'images/treadmill.jpg'),
('P002', '啞鈴 8 公斤', '適合中等強度力量訓練。', '健身用品', 8.00, 50.00, 'images/dumbbell_set.jpg'),
('P003', '啞鈴 10 公斤', '適合中等強度力量訓練。', '健身用品', 10.00, 70.00, 'images/exercise_bike.jpg'),
('P004', '阻力帶', '耐用多功能的阻力帶套裝。', '健身用品', NULL, 20.00, 'images/resistance_bands.jpg'),
('P005', '壺鈴 4 公斤', '適合輕量訓練的壺鈴。', '健身用品', 4.00, 20.00, 'images/kettlebell_4kg.jpg'),
('P006', '壺鈴 8 公斤', '適合中等強度訓練的壺鈴。', '健身用品', 8.00, 40.00, 'images/kettlebell_8kg.jpg'),
('P007', '壺鈴 12 公斤', '適合進階力量訓練的壺鈴。', '健身用品', 12.00, 60.00, 'images/kettlebell_12kg.jpg'),
('P008', '壺鈴 16 公斤', '適合進階力量訓練的壺鈴。', '健身用品', 16.00, 80.00, 'images/kettlebell_set.jpg'),
('P009', '橢圓機', '適合全身鍛煉的橢圓機。', '健身用品', NULL, 220.00, 'images/elliptical_machine.jpg'),
('P010', '握力訓練器', '提升握力的便攜設備。', '健身用品', NULL, 15.00, 'images/grip_trainer.jpg'),
('P011', '跳繩', '高性能跳繩，適合快速訓練。', '健身用品', NULL, 10.00, 'images/jump_rope.jpg'),
('P012', '深蹲架', '適合深蹲和重量訓練的高強度架子。', '健身用品', NULL, 300.00, 'images/squat_rack.jpg'),
('P013', '重量訓練椅', '多角度可調節的重量訓練椅。', '健身用品', NULL, 100.00, 'images/weight_bench.jpg'),
('P014', '泡沫滾筒', '高密度泡沫滾筒，幫助肌肉放鬆。', '健身用品', NULL, 15.00, 'images/foam_roller.jpg'),
('P015', '腹肌滾輪', '輕便設計，專為腹部核心訓練設計。', '健身用品', NULL, 25.00, 'images/ab_roller.jpg'),
('P016', '槓鈴 10 公斤', '適合輕量級力量訓練的槓鈴。', '健身用品', 10.00, 50.00, 'images/barbell_10kg.jpg'),
('P017', '槓鈴 20 公斤', '適合進階力量訓練的槓鈴。', '健身用品', 20.00, 70.00, 'images/barbell_20kg.jpg'),
('P018', '核心訓練板', '提升核心穩定性的專業訓練設備。', '健身用品', NULL, 50.00, 'images/core_trainer.jpg'),
('P019', '阻力帶套裝', '多種阻力級別，適合全身鍛煉。', '健身用品', NULL, 25.00, 'images/resistance_band_set.jpg'),
('P020', '健身腳踏車', '安靜且舒適的室內健身腳踏車。', '健身用品', NULL, 120.00, 'images/exercise_bike.jpg'),


-- 拳擊用品類別
('P021', '拳擊手套', '高品質拳擊手套，適合訓練或比賽。', '拳擊用品', NULL, 45.00, 'images/boxing_gloves.jpg'),
('P022', '沙袋 10 公斤', '適合初學者的輕型拳擊沙袋。', '拳擊用品', 10.00, 50.00, 'images/light_punching_bag.jpg'),
('P023', '沙袋 20 公斤', '適合進階訓練的中型拳擊沙袋。', '拳擊用品', 20.00, 80.00, 'images/medium_punching_bag.jpg'),
('P024', '速度球', '輕巧且靈活的拳擊速度球。', '拳擊用品', NULL, 30.00, 'images/speed_bag.jpg'),
('P025', '拳擊靶', '適合快速拳擊訓練的靶子。', '拳擊用品', NULL, 25.00, 'images/focus_mitts.jpg'),
('P026', '拳擊反應球', '提高速度和敏捷度的拳擊訓練設備。', '拳擊用品', NULL, 12.00, 'images/reflex_ball.jpg'),
('P027', '護齒套裝', '耐用舒適的拳擊護齒套裝。', '拳擊用品', NULL, 8.00, 'images/mouth_guard_set.jpg'),
('P028', '拳擊計時器', '幫助設置訓練時間的電子計時器。', '拳擊用品', NULL, 30.00, 'images/boxing_timer.jpg'),
('P029', '拳擊護腕', '高支撐力的專業拳擊護腕。', '拳擊用品', NULL, 15.00, 'images/boxing_wrist_guard.jpg'),
('P030', '沙袋支架', '用於固定拳擊沙袋的耐用支架。', '拳擊用品', NULL, 90.00, 'images/bag_stand.jpg'),

-- 瑜伽輔具類別
('P031', '瑜伽墊', '高防滑性瑜伽墊，適合多種練習。', '瑜伽輔具', NULL, 20.00, 'images/yoga_mat.jpg'),
('P032', '瑜伽磚', '提供穩定支撐的高密度瑜伽磚。', '瑜伽輔具', NULL, 10.00, 'images/yoga_block.jpg'),
('P033', '瑜伽輪', '輔助拉伸和後彎訓練的瑜伽輪。', '瑜伽輔具', NULL, 30.00, 'images/yoga_wheel.jpg'),
('P034', '瑜伽包', '耐用且多功能的瑜伽裝備包。', '瑜伽輔具', NULL, 18.00, 'images/yoga_bag.jpg'),
('P035', '瑜伽冷感毛巾', '適合流汗練習的冷感毛巾。', '瑜伽輔具', NULL, 12.00, 'images/yoga_cooling_towel.jpg'),
('P036', '瑜伽帶', '輔助進階動作的多功能瑜伽帶。', '瑜伽輔具', NULL, 10.00, 'images/yoga_strap.jpg'),
('P037', '瑜伽墊背包', '可輕鬆攜帶瑜伽墊的背包。', '瑜伽輔具', NULL, 25.00, 'images/yoga_mat_bag.jpg'),
('P038', '瑜伽椅', '幫助完成倒立等高難度動作的專用椅子。', '瑜伽輔具', NULL, 50.00, 'images/yoga_chair.jpg'),
('P039', '瑜伽輪加強版', '適合進階練習的瑜伽輪。', '瑜伽輔具', NULL, 40.00, 'images/advanced_yoga_wheel.jpg'),
('P040', '冥想抱枕', '提供額外支撐的舒適抱枕。', '瑜伽輔具', NULL, 30.00, 'images/meditation_pillow.jpg'),
('P041', '瑜伽繩', '幫助拉伸和瑜伽動作的專業瑜伽繩。', '瑜伽輔具', NULL, 8.00, 'images/yoga_strap.jpg'),
('P042', '瑜伽毛巾', '吸汗快乾的瑜伽毛巾，適合多種場合。', '瑜伽輔具', NULL, 10.00, 'images/yoga_towel.jpg'),
('P043', '瑜伽球', '適合平衡訓練的大尺寸瑜伽球。', '瑜伽輔具', 1.50, 20.00, 'images/yoga_ball.jpg'),
('P044', '瑜伽椅', '提供穩定支撐的專業瑜伽椅。', '瑜伽輔具', NULL, 40.00, 'images/yoga_chair.jpg'),
('P045', '瑜伽頭枕', '舒適支撐的瑜伽專用頭枕。', '瑜伽輔具', NULL, 15.00, 'images/yoga_pillow.jpg'),


-- 其他商品
('P046', '按摩滾筒', '針對深層肌肉放鬆的按摩滾筒。', '其他', NULL, 25.00, 'images/foam_roller.jpg'),
('P047', '冷敷袋', '多用途冷敷袋，緩解運動後不適。', '其他', NULL, 8.00, 'images/ice_pack.jpg'),
('P048', '熱敷墊', '電子加熱的熱敷墊，促進血液循環。', '其他', 0.50, 35.00, 'images/heating_pad.jpg'),
('P049', '運動筆記本', '記錄運動計劃和目標的專業筆記本。', '其他', NULL, 10.00, 'images/sports_notebook.jpg'),
('P050', '運動毛巾', '大尺寸吸水運動毛巾，適合訓練後使用。', '其他', NULL, 12.00, 'images/sports_towel.jpg'),
('P051', '護膝', '專業運動護膝，保護膝蓋關節。', '運動護具', NULL, 20.00, 'images/knee_pad.jpg'),
('P052', '護腕', '加強支撐的運動護腕，減少受傷風險。', '運動護具', NULL, 12.00, 'images/wrist_support.jpg'),
('P053', '護肘', '輕量透氣的運動護肘。', '運動護具', NULL, 15.00, 'images/elbow_pad.jpg'),
('P054', '護踝', '高彈性運動護踝，適合多種運動。', '運動護具', NULL, 10.00, 'images/ankle_support.jpg'),
('P055', '護肩', '加厚型運動護肩，支撐肩部運動。', '運動護具', NULL, 25.00, 'images/shoulder_support.jpg');

CREATE TABLE Videos (
    videos_id INT AUTO_INCREMENT PRIMARY KEY,   -- 影片 ID (主鍵、自增)
    title VARCHAR(255) NOT NULL,         -- 影片標題
    description TEXT,                    -- 影片描述
    video_url VARCHAR(255) NOT NULL,     -- 影片 URL
    category VARCHAR(50) NOT NULL,       -- 影片類型 (例如: 居家徒手健身、居家器械運動、居家有氧)
    status INT NOT NULL           -- 影片狀態 (0: 停用, 1: 啟用)
);

INSERT INTO Videos (title, description, video_url, category, status)
VALUES 
    -- 居家徒手健身 (20 部影片)
    ('伏地挺身挑戰', '訓練胸部與三頭肌的經典動作', 'https://example.com/video1', '居家徒手健身', 1),
    ('深蹲訓練', '提升腿部力量與核心穩定', 'https://example.com/video2', '居家徒手健身', 1),
    ('仰臥起坐強化版', '針對腹部核心的強化訓練', 'https://example.com/video3', '居家徒手健身', 1),
    ('登山者動作', '高效燃脂的徒手運動', 'https://example.com/video4', '居家徒手健身', 0),
    ('側平板支撐挑戰', '訓練側腰與核心穩定性', 'https://example.com/video5', '居家徒手健身', 1),
    ('仰臥橋式進階版', '增強臀部與核心力量', 'https://example.com/video6', '居家徒手健身', 0),
    ('超人式核心訓練', '專注背部與核心肌群', 'https://example.com/video7', '居家徒手健身', 1),
    ('單腳深蹲挑戰', '提升平衡與腿部肌耐力', 'https://example.com/video8', '居家徒手健身', 1),
    ('波比跳燃脂版', '全身高強度間歇運動', 'https://example.com/video9', '居家徒手健身', 1),
    ('動態平板支撐', '增強全身穩定性的運動', 'https://example.com/video10', '居家徒手健身', 0),
    ('跳躍深蹲', '強化腿部爆發力的動作', 'https://example.com/video11', '居家徒手健身', 1),
    ('側向弓箭步', '針對大腿內外側肌群的訓練', 'https://example.com/video12', '居家徒手健身', 0),
    ('四足跪姿伸展', '訓練全身協調性的徒手動作', 'https://example.com/video13', '居家徒手健身', 1),
    ('原地跑步', '提升心肺功能的居家徒手運動', 'https://example.com/video14', '居家徒手健身', 1),
    ('單腿臀橋', '強化臀部與核心的進階訓練', 'https://example.com/video15', '居家徒手健身', 0),
    ('伏地挺身變式', '挑戰不同肌群的徒手訓練', 'https://example.com/video16', '居家徒手健身', 1),
    ('登山者動作進階版', '增加腹部核心與腿部耐力', 'https://example.com/video17', '居家徒手健身', 1),
    ('高抬腿', '提升心跳速率的簡單有氧運動', 'https://example.com/video18', '居家徒手健身', 1),
    ('跳箱訓練', '提升爆發力與耐力', 'https://example.com/video19', '居家徒手健身', 0),
    ('波比跳標準版', '居家全身強化運動', 'https://example.com/video20', '居家徒手健身', 1),

    -- 居家器械運動 (20 部影片)
    ('啞鈴肩推', '增加肩部力量的居家運動', 'https://example.com/video21', '居家器械運動', 1),
    ('壺鈴深蹲推舉', '結合腿部與上肢力量的器械訓練', 'https://example.com/video22', '居家器械運動', 1),
    ('彈力帶深蹲', '提升臀部與腿部穩定性的訓練', 'https://example.com/video23', '居家器械運動', 0),
    ('啞鈴划船', '專注於背部肌群的器械運動', 'https://example.com/video24', '居家器械運動', 1),
    ('彈力帶側步', '激活腿部與臀部肌群', 'https://example.com/video25', '居家器械運動', 1),
    ('壺鈴硬舉', '提升背部與下肢的協調性', 'https://example.com/video26', '居家器械運動', 0),
    ('啞鈴臂屈伸', '加強上肢肌群的訓練', 'https://example.com/video27', '居家器械運動', 1),
    ('壺鈴行走推舉', '結合核心穩定與肩部訓練', 'https://example.com/video28', '居家器械運動', 1),
    ('彈力帶雙臂推拉', '提升背部與胸部力量的動作', 'https://example.com/video29', '居家器械運動', 1),
    ('啞鈴深蹲', '提升腿部與臀部肌肉力量', 'https://example.com/video30', '居家器械運動', 0),

    -- 居家有氧 (15 部影片)
    ('高抬腿原地跑', '居家有氧的基礎動作', 'https://example.com/video31', '居家有氧', 1),
    ('開合跳', '提升心肺功能的經典運動', 'https://example.com/video32', '居家有氧', 1),
    ('波比跳燃脂挑戰', '高效燃燒卡路里的有氧訓練', 'https://example.com/video33', '居家有氧', 0),
    ('動態平板支撐', '結合力量與耐力的居家運動', 'https://example.com/video34', '居家有氧', 1),
    ('高強度跳躍', '訓練全身耐力與爆發力的動作', 'https://example.com/video35', '居家有氧', 0),
    ('跳繩燃脂訓練', '適合快速燃燒卡路里的運動', 'https://example.com/video36', '居家有氧', 1),
    ('階梯爬行模擬', '提升腿部與心肺功能的運動', 'https://example.com/video37', '居家有氧', 1),
    ('快速步伐訓練', '加強靈敏度與心肺耐力的動作', 'https://example.com/video38', '居家有氧', 1),
    ('大幅度開合跳', '居家有氧的進階挑戰', 'https://example.com/video39', '居家有氧', 0),
    ('高抬腿波比跳', '結合有氧與核心的全身運動', 'https://example.com/video40', '居家有氧', 1),
    ('原地快跑', '適合初學者的有氧運動', 'https://example.com/video41', '居家有氧', 1),
    ('跳台階訓練', '模擬戶外的居家有氧運動', 'https://example.com/video42', '居家有氧', 0),
    ('交替登高模擬', '簡單卻高效的心肺運動', 'https://example.com/video43', '居家有氧', 1),
    ('交叉腿開合跳', '增加靈活性與心肺耐力', 'https://example.com/video44', '居家有氧', 1),
    ('有氧快走模擬', '低衝擊的心肺功能訓練', 'https://example.com/video45', '居家有氧', 1);
select * from Videos;


#create database gym_database;
#use gym_database;
#show warnings;
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,         
    member_id INT NOT NULL,          -- 外鍵，參照 member 資料表                   
    total_amount DECIMAL(10, 0) NOT NULL,             
    status VARCHAR(50) NOT NULL,                      
    self_pickup_store TEXT NOT NULL,                  
    payment_method VARCHAR(50) NOT NULL,             
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
    
);
desc orders;
#drop table orders;

INSERT INTO orders (member_id, total_amount, status, self_pickup_store, payment_method)
VALUES
(1, 150, 'pending', '健身房A', '信用卡'),
(2, 250, 'completed', '健身房B', '現金'),
(3, 99, 'canceled', '健身房C', '信用卡'),
(4, 300, 'pending', '健身房D', '現金'),
(5, 450, 'completed', '健身房E', '信用卡'),
(6, 120, 'pending', '健身房A', '現金'),
(7, 200, 'completed', '健身房B', '信用卡'),
(8, 330, 'canceled', '健身房C', '現金'),
(9, 175, 'pending', '健身房D', '信用卡'),
(10, 550, 'completed', '健身房E', '現金'),
(11, 120, 'pending', '健身房A', '信用卡'),
(12, 300, 'completed', '健身房B', '現金'),
(13, 410, 'pending', '健身房C', '信用卡'),
(14, 95, 'canceled', '健身房D', '現金'),
(15, 210, 'completed', '健身房E', '信用卡'),
(16, 305, 'pending', '健身房A', '現金'),
(17, 480, 'completed', '健身房B', '信用卡'),
(18, 150, 'canceled', '健身房C', '現金'),
(19, 225, 'pending', '健身房D', '信用卡'),
(20, 310, 'completed', '健身房E', '現金'),
(21, 95, 'pending', '健身房A', '信用卡'),
(22, 215, 'completed', '健身房B', '現金'),
(23, 405, 'pending', '健身房C', '信用卡'),
(24, 310, 'canceled', '健身房D', '現金'),
(25, 220, 'completed', '健身房E', '信用卡'),
(26, 500, 'pending', '健身房A', '現金'),
(27, 130, 'completed', '健身房B', '信用卡'),
(28, 345, 'canceled', '健身房C', '現金'),
(29, 290, 'pending', '健身房D', '信用卡'),
(30, 425, 'completed', '健身房E', '現金');

select * from orders;
#delete from orders;


CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY, 
    order_id INT NOT NULL,                        -- 外鍵，參照 orders 資料表
    product_id INT NOT NULL,                      -- 外鍵，參照 products 資料表
    quantity INT NOT NULL,                        -- 商品數量
    total_price DECIMAL(10, 0) NOT NULL,          -- 商品總金額
    rental_days INT NOT NULL,                     -- 租借天數
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- 訂單項目建立時間
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- 訂單項目更新時間
    
);
-- FOREIGN KEY (order_id) REFERENCES orders(order_id), -- 設定外鍵
-- FOREIGN KEY (product_id) REFERENCES products(product_id) -- 設定外鍵

INSERT INTO order_items (order_id, product_id, quantity, total_price, rental_days, created_at, updated_at)
VALUES
(1, 1, 2, 300, 3, '2025-01-10 10:00:00', '2025-01-10 10:00:00'),
(2, 2, 1, 150, 2, '2025-01-10 11:00:00', '2025-01-10 11:00:00'),
(3, 3, 3, 450, 5, '2025-01-11 09:30:00', '2025-01-11 09:30:00'),
(4, 4, 1, 120, 1, '2025-01-11 14:20:00', '2025-01-11 14:20:00'),
(5, 5, 2, 250, 2, '2025-01-12 08:00:00', '2025-01-12 08:00:00'),
(6, 6, 4, 600, 6, '2025-01-12 15:30:00', '2025-01-12 15:30:00'),
(7, 7, 2, 500, 4, '2025-01-13 13:45:00', '2025-01-13 13:45:00'),
(8, 8, 3, 330, 3, '2025-01-13 16:10:00', '2025-01-13 16:10:00'),
(9, 9, 1, 200, 2, '2025-01-14 09:20:00', '2025-01-14 09:20:00'),
(10, 10, 5, 750, 5, '2025-01-14 12:00:00', '2025-01-14 12:00:00'),
(11, 11, 2, 400, 4, '2025-01-15 10:30:00', '2025-01-15 10:30:00'),
(12, 12, 1, 150, 3, '2025-01-15 11:45:00', '2025-01-15 11:45:00'),
(13, 13, 3, 450, 6, '2025-01-16 14:10:00', '2025-01-16 14:10:00'),
(14, 14, 2, 240, 2, '2025-01-16 16:00:00', '2025-01-16 16:00:00'),
(15, 15, 1, 180, 3, '2025-01-17 09:00:00', '2025-01-17 09:00:00'),
(16, 16, 4, 600, 6, '2025-01-17 10:45:00', '2025-01-17 10:45:00'),
(17, 17, 2, 420, 4, '2025-01-18 11:30:00', '2025-01-18 11:30:00'),
(18, 18, 3, 360, 3, '2025-01-18 14:00:00', '2025-01-18 14:00:00'),
(19, 19, 1, 150, 2, '2025-01-19 12:20:00', '2025-01-19 12:20:00'),
(20, 20, 2, 300, 3, '2025-01-19 15:10:00', '2025-01-19 15:10:00'),
(21, 21, 2, 400, 4, '2025-01-20 09:00:00', '2025-01-20 09:00:00'),
(22, 22, 3, 450, 3, '2025-01-20 11:15:00', '2025-01-20 11:15:00'),
(23, 23, 1, 120, 2, '2025-01-21 10:30:00', '2025-01-21 10:30:00'),
(24, 24, 4, 720, 6, '2025-01-21 13:00:00', '2025-01-21 13:00:00'),
(25, 25, 2, 300, 3, '2025-01-22 14:45:00', '2025-01-22 14:45:00'),
(26, 26, 3, 450, 3, '2025-01-22 16:30:00', '2025-01-22 16:30:00'),
(27, 27, 1, 200, 2, '2025-01-23 09:15:00', '2025-01-23 09:15:00'),
(28, 28, 2, 350, 5, '2025-01-23 11:00:00', '2025-01-23 11:00:00'),
(29, 29, 4, 480, 4, '2025-01-24 08:45:00', '2025-01-24 08:45:00'),
(30, 30, 3, 540, 6, '2025-01-24 14:30:00', '2025-01-24 14:30:00'),
(31, 31, 2, 300, 3, '2025-01-25 09:20:00', '2025-01-25 09:20:00'),
(32, 32, 5, 600, 6, '2025-01-25 12:10:00', '2025-01-25 12:10:00'),
(33, 33, 3, 450, 3, '2025-01-26 10:45:00', '2025-01-26 10:45:00'),
(34, 34, 1, 150, 2, '2025-01-26 13:30:00', '2025-01-26 13:30:00'),
(35, 35, 2, 240, 4, '2025-01-27 09:50:00', '2025-01-27 09:50:00'),
(36, 36, 3, 360, 3, '2025-01-27 11:20:00', '2025-01-27 11:20:00'),
(37, 37, 4, 600, 6, '2025-01-28 08:30:00', '2025-01-28 08:30:00'),
(38, 38, 1, 120, 2, '2025-01-28 12:40:00', '2025-01-28 12:40:00'),
(39, 39, 2, 250, 5, '2025-01-29 09:10:00', '2025-01-29 09:10:00'),
(40, 40, 3, 450, 3, '2025-01-29 14:15:00', '2025-01-29 14:15:00'),
(41, 41, 1, 200, 2, '2025-01-30 09:00:00', '2025-01-30 09:00:00'),
(42, 42, 4, 600, 6, '2025-01-30 10:45:00', '2025-01-30 10:45:00'),
(43, 43, 2, 300, 3, '2025-01-31 11:30:00', '2025-01-31 11:30:00'),
(44, 44, 5, 750, 5, '2025-01-31 15:10:00', '2025-01-31 15:10:00'),
(45, 45, 3, 450, 3, '2025-02-01 08:50:00', '2025-02-01 08:50:00'),
(46, 46, 2, 250, 2, '2025-02-01 12:30:00', '2025-02-01 12:30:00'),
(47, 47, 1, 180, 3, '2025-02-02 09:10:00', '2025-02-02 09:10:00'),
(48, 48, 3, 540, 6, '2025-02-02 13:40:00', '2025-02-02 13:40:00'),
(49, 49, 2, 300, 3, '2025-02-03 10:20:00', '2025-02-03 10:20:00'),
(50, 50, 4, 480, 4, '2025-02-03 15:00:00', '2025-02-03 15:00:00'),
(51, 51, 3, 450, 3, '2025-02-04 11:10:00', '2025-02-04 11:10:00'),
(52, 52, 1, 120, 2, '2025-02-04 14:30:00', '2025-02-04 14:30:00'),
(53, 53, 2, 400, 4, '2025-02-05 08:45:00', '2025-02-05 08:45:00'),
(54, 54, 3, 540, 6, '2025-02-05 13:50:00', '2025-02-05 13:50:00'),
(55, 55, 2, 300, 3, '2025-02-06 09:20:00', '2025-02-06 09:20:00');

select * from order_items;
 #drop table order_items;

CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY, 
    order_id INT NOT NULL,                     -- 外鍵，參照 orders 資料表
    amount DECIMAL(10, 0) NOT NULL,            -- 付款金額
    payment_method VARCHAR(50) NOT NULL,       -- 付款方式 (例如：信用卡、現金)
    payment_status VARCHAR(50) NOT NULL,       -- 付款狀態 (例如：success、failed、pending)
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- 付款時間
    
);
-- FOREIGN KEY (order_id) REFERENCES orders(order_id) -- 設定外鍵，關聯到 orders 表

INSERT INTO payments (order_id, amount, payment_method, payment_status, payment_date) 
VALUES
(1, 150, '信用卡', 'success', '2025-01-10 14:20:00'),
(2, 250, '現金', 'success', '2025-01-10 15:30:00'),
(3, 99, '信用卡', 'failed', '2025-01-11 10:00:00'),
(4, 300, '現金', 'success', '2025-01-11 11:45:00'),
(5, 450, '信用卡', 'success', '2025-01-12 09:20:00'),
(6, 120, '現金', 'pending', '2025-01-12 10:50:00'),
(7, 200, '信用卡', 'failed', '2025-01-13 13:30:00'),
(8, 330, '現金', 'success', '2025-01-13 14:10:00'),
(9, 175, '信用卡', 'pending', '2025-01-14 08:50:00'),
(10, 550, '現金', 'success', '2025-01-14 16:20:00'),
(11, 120, '信用卡', 'success', '2025-01-15 11:00:00'),
(12, 300, '現金', 'failed', '2025-01-15 12:30:00'),
(13, 410, '信用卡', 'success', '2025-01-16 14:50:00'),
(14, 95, '現金', 'pending', '2025-01-16 15:40:00'),
(15, 210, '信用卡', 'success', '2025-01-17 09:10:00'),
(16, 305, '現金', 'success', '2025-01-17 10:20:00'),
(17, 480, '信用卡', 'success', '2025-01-18 13:50:00'),
(18, 150, '現金', 'failed', '2025-01-18 14:30:00'),
(19, 225, '信用卡', 'pending', '2025-01-19 11:20:00'),
(20, 310.00, '現金', 'success', '2025-01-19 15:00:00');

select * from payments;
#drop table payments;
#delete from payments;