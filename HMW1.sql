Create DATABASE hw1;
USE hw1;

CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(255) not null unique,
    password varchar(255) not null,
    email varchar(255) not null ,
    name varchar(255) not null,
    surname varchar(255) not null,
    data date,
    avatar varchar(255)
) Engine = InnoDB;

CREATE TABLE film(
    
    id VARCHAR(255) primary key,
    userid VARCHAR(255)  not null,
    content json

    
)Engine = InnoDB;

CREATE TABLE comment(
    
    id integer primary key auto_increment,
    userid VARCHAR(255)  not null,
    content json

    
)Engine = InnoDB;