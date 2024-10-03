create database YmmerChat;

create user "YmmerUser"@"localhost" identified by "}KYyCV\4^JO|l@i";
GRANT insert,update,delete ON YmmerChat.* TO 'YmmerUser'@'localhost';

use YmmerChat;

create table user (
id int not null auto_increment,
username varchar(100),
email varchar(255),
nom varchar(100),
prenom varchar(100),
num varchar(10),
password varchar(512),
primary key (id)

);

create table conversation (
id int not null auto_increment,
name varchar(255),
author int,
created_AT DateTime default now(),
primary key (id),
CONSTRAINT fk_user foreign key (author) references user(id) on delete cascade
);

create table participant (
id int not null auto_increment,
user_id int not null,
conversation_id int not null,
primary key(id),
CONSTRAINT fk_user_participants foreign key (user_id) references user(id),
CONSTRAINT fk_conversation_participants foreign key (conversation_id) references conversation(id) on delete cascade
);

create table message(
id int not null auto_increment,
texte text,
participant_id int not null,
date DateTime default now(),
primary key(id),
constraint fk_message_participants foreign key (participant_id) references participant(id) on delete cascade
);