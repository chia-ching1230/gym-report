CREATE DATABASE gym_database;
 USE gym_database;
-- drop table gyms;
-- gym點資料表 
CREATE DATABASE gym_database;
USE gym_database;

-- 刪除舊資料表
-- DROP TABLE gyms;

-- 創建 gym 資料表，將營業星期放在開門時間前面
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
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- 自動記錄創建時間
);

-- 插入資料，營業星期作為逗號分隔字串
INSERT INTO gyms (name, address, business_days, opening_hours, closing_hours, description, contact_info, email, manager)
VALUES
('健身房A', '台南市中華東路100號', 'Monday, Tuesday, Wednesday, Thursday, Friday', '08:00:00', '22:00:00', '提供各類健身器材，適合健身初學者與進階者使用，並提供專業指導課程。', '06-1234-5678', 'contactA@gym.com', '王大明'),
('健身房B', '台南市永康區中正路200號', 'Monday, Tuesday, Wednesday, Thursday, Friday, Saturday', '07:00:00', '23:00:00', '擁有先進的重訓設備及寬敞的游泳池，設有個人化健身計劃設計服務。', '06-2345-6789', 'contactB@gym.com', '李小華'),
('健身房C', '台南市安平區建國路300號', 'Tuesday, Wednesday, Thursday, Friday, Saturday', '06:30:00', '21:30:00', '提供多樣的有氧運動課程及高效的跑步機，環境清新舒適。', '06-3456-7890', 'contactC@gym.com', '張志強'),
('健身房D', '台南市北區成功路400號', 'Monday, Wednesday, Friday, Saturday', '09:00:00', '20:00:00', '專業拳擊訓練課程、自由重訓區，專注於力量與耐力的提升。', '06-4567-8901', 'contactD@gym.com', '陳美麗'),
('健身房E', '台南市西區府前路500號', 'Monday, Tuesday, Wednesday, Thursday, Friday', '08:00:00', '22:30:00', '提供各式團體課程及無氧設備，讓您更有效率地達成健身目標。', '06-5678-9012', 'contactE@gym.com', '林俊杰');


select * from gyms ;