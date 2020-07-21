create schema if not exists Employee
default character set utf8
collate utf8_general_ci;


use Employee;

SET FOREIGN_KEY_CHECKS=0;
drop table if exists `Employees`;
drop table if exists `Contact`;
drop table if exists `Information`;
drop table if exists `UpdateLog`;
SET FOREIGN_KEY_CHECKS=1;


create table if not exists `Employees`(
`employeeID` int not null auto_increment primary key,
`name` varchar(50) not null,
`birthdate` datetime not null,
`SSN` int not null,
`isEmployee` bool not null,
`createdBy` varchar(200),
`insertDate` datetime
) DEFAULT CHARACTER SET = utf8;

create table if not exists `Contact` (
`id` int not null auto_increment primary key,
`email` varchar(50),
`phone` varchar(50),
`address` varchar(100),
`employeeID` int not null,
UNIQUE INDEX `id_UNIQUE` (`id` ASC),
CONSTRAINT `fk_contact_detail`
    FOREIGN KEY (`employeeID`)
    REFERENCES `Employees` (`employeeID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) DEFAULT CHARACTER SET = utf8;

create table if not exists `Information` (
`id` int not null auto_increment primary key,
`employee_introduction_english` nvarchar(2000),
`employee_introduction_spanish` nvarchar(2000),
`employee_introduction_french` nvarchar(2000),
`employee_experience` int,
`employee_experience_english` nvarchar(2000),
`employee_experience_spanish` nvarchar(2000),
`employee_experience_french` nvarchar(2000),
`employee_education` int,
`employee_education_english` nvarchar(2000),
`employee_education_spanish` nvarchar(2000),
`employee_education_french` nvarchar(2000),
`employeeID` int not null,
UNIQUE INDEX `id_UNIQUE` (`id` ASC),
CONSTRAINT `fk_information_detail`
    FOREIGN KEY (`employeeID`)
    REFERENCES `Employees` (`employeeID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) DEFAULT CHARACTER SET = utf8;

create table if not exists `UpdateLog` (
`id` int not null auto_increment primary key,
`email` varchar(50),
`email_old` varchar(50),
`phone` varchar(50),
`phone_old` varchar(50),
`address` varchar(100),
`address_old` varchar(100),
`employeeID` int not null,
`employee_introduction_english` varchar(1000),
`employee_introduction_english_old` varchar(1000),
`employee_introduction_spanish` varchar(1000),
`employee_introduction_spanish_old` varchar(1000),
`employee_introduction_french` varchar(1000),
`employee_introduction_french_old` varchar(1000),
`employee_experience` int,
`employee_experience_old` int,
`employee_experience_english` varchar(1000),
`employee_experience_english_old` varchar(1000),
`employee_experience_spanish` varchar(1000),
`employee_experience_spanish_old` varchar(1000),
`employee_experience_french` varchar(1000),
`employee_experience_french_old` varchar(1000),
`employee_education_old` int,
`employee_education` int,
`employee_education_english_old` varchar(1000),
`employee_education_english` varchar(1000),
`employee_education_spanish_old` varchar(1000),
`employee_education_spanish` varchar(1000),
`employee_education_french_old` varchar(1000),
`employee_education_french` varchar(1000),
`updatedBy` varchar(200),
UNIQUE INDEX `id_UNIQUE` (`id` ASC),
CONSTRAINT `fk_updatelog_detail`
    FOREIGN KEY (`employeeID`)
    REFERENCES `Employees` (`employeeID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) DEFAULT CHARACTER SET = utf8;

insert into Employees (name,birthdate,SSN,isEmployee,createdBy,insertDate) values ('John Doe','2020-01-01','123123',true,'Unknown',now());
insert into Employees (name,birthdate,SSN,isEmployee,createdBy,insertDate) values ('Jane Doe','2019-01-01','63423',false,'Administrator',DATE_SUB(NOW(), INTERVAL 30 DAY));
insert into Employees (name,birthdate,SSN,isEmployee,createdBy,insertDate) values ('Sahan CAVA','1991-06-11','5232123',true,'localhost',DATE_SUB(NOW(), INTERVAL 5 DAY));

insert into Contact (email,phone,address,employeeID) values ('janedoe@email.com','Phone Number of Jane Doe','Address of Jane Doe',2);
insert into Contact (email,phone,address,employeeID) values ('johndoe@email.com','Phone Number of John Doe','Address of John Doe',1);
insert into Contact (email,phone,address,employeeID) values ('sahancava@email.com','Phone Number of Sahan CAVA','Address of Sahan CAVA',3);

insert into Information (
employee_introduction_english,
employee_introduction_spanish,
employee_introduction_french,
employee_experience,
employee_experience_english,
employee_experience_spanish,
employee_experience_french,
employee_education,
employee_education_english,
employee_education_spanish,
employee_education_french,
employeeID) values (
'employee_introduction_english - user/1',
'employee_introduction_spanish - user/1',
'employee_introduction_french - user/1',
2,
'employee_experience_english - user/1',
'employee_experience_spanish - user/1',
'employee_experience_french - user/1',
2,
'employee_education_english - user/1',
'employee_education_spanish - user/1',
'employee_education_french - user/1',
1
),(
'employee_introduction_english - user/2',
'employee_introduction_spanish - user/3',
'employee_introduction_french - user/2',
2,
'employee_experience_english - user/2',
'employee_experience_spanish - user/2',
'employee_experience_french - user/2',
2,
'employee_education_english - user/2',
'employee_education_spanish - user/2',
'employee_education_french - user/2',
2
),(
'employee_introduction_english - user/3',
'employee_introduction_spanish - user/3',
'employee_introduction_french - user/3',
2,
'employee_experience_english - user/3',
'employee_experience_spanish - user/3',
'employee_experience_french - user/3',
2,
'employee_education_english - user/3',
'employee_education_spanish - user/3',
'employee_education_french - user/3',
3
)