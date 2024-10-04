create database YmmerChat;


create user "YmmerUser"@"localhost" identified by "Arachnide";
grant insert,update,delete,select ON YmmerChat.* TO 'YmmerUser'@'localhost';

use YmmerChat;

create table user (
user_id int not null auto_increment,
username varchar(100),
email varchar(255),
nom varchar(100),
prenom varchar(100),
num varchar(10),
password varchar(512),
token varchar(255),
primary key (user_id)

)ENGINE=InnoDB;

create table conversation (
conv_id int not null auto_increment,
name varchar(255),
author int,
created_AT DateTime default now(),
primary key (conv_id)
)ENGINE=InnoDB;

create table participant (
participant_id int not null auto_increment,
user_id int ,
conversation_id int ,
primary key(participant_id),
CONSTRAINT fk_user_participants foreign key (user_id) references user(user_id) on delete cascade,
CONSTRAINT fk_conversation_participants foreign key (conversation_id) references conversation(conv_id) on delete cascade
)ENGINE=InnoDB;

ALTER TABLE conversation ADD CONSTRAINT fk_user foreign key (author) references participant(participant_id) on delete cascade;

create table message(
id int not null auto_increment,
texte text,
participant_id int not null,
date DateTime default now(),
primary key(id),
constraint fk_message_participants foreign key (participant_id) references participant(participant_id) on delete cascade
)ENGINE=InnoDB;