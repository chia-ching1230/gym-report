use  gym_database;

create table gym_admin (
admin_id int auto_increment primary key,
admin_name varchar(50) NOT NULL,
email varchar(255) NOT NULL UNIQUE,
admin_password varchar(255) NOT NULL,
admin_role int NOT NULL,
admin_code VARCHAR(10) UNIQUE,  
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  
);

insert into gym_admin(admin_name, email, admin_password,admin_role,admin_code)
values
("Owen","dtes95105@gmail.com","P@ssw0rdo0",1,"A2501"),
("Pao","mwz236268@gmail.com","P@ssw0rdo1",2,"A2502"),
("Ching","s22h20@gmail.com","P@ssw0rdo2",2,"A2503");
-- ("Yang","abcd6968688@gmail.com","P@ssw0rdo3",2,"A2504");
 select * from gym_admin;


-- drop table gym_admin;