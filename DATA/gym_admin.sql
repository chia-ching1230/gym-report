use  gym_database;

CREATE TABLE gym_admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_name VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    admin_password_hash VARCHAR(255) NOT NULL,
    admin_role INT NOT NULL,
    admin_code VARCHAR(10) UNIQUE DEFAULT 'A0000',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

insert into gym_admin(admin_name, email, admin_password_hash,admin_role,admin_code)
values
("Owen","dtes95105@gmail.com","$2y$10$pLXg5uJbrJ6Kzu3GL49t/OGD2SzRBYCLfSyTsgNoXriW66qYKzeIi",1,"A2501"),
("Pao","mwz236268@gmail.com","$2y$10$1xD0C2DglUWwfrw1jSRLHeH5G7UqGuF/pjAxLqOpjziC0e7ckR6km",2,"A2502"),
("Ching","s22h20@gmail.com","$2y$10$V07IfoGb9jBDCkv9S/Y7tunjfbxefqlxzFH5G3REEYPHKfWZgLjQa",2,"A2503");
-- ("Yang","abcd6968688@gmail.com","P@ssw0rdo3",2,"A2504");
 select * from gym_admin;


 -- drop table gym_admin;-- 