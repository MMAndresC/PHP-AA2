<?php

require_once "db_connection.php";
const CREATE_DATABASE = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . "  CHARACTER SET utf8 COLLATE utf8_spanish_ci";
const CREATE_TABLE_USERS = "CREATE TABLE IF NOT EXISTS `user` ( 
    `username` VARCHAR(20) NOT NULL , 
    `name` VARCHAR(30) NOT NULL , 
    `surname` VARCHAR(30) NOT NULL , 
    `email` VARCHAR(50) NOT NULL , 
    `password` VARCHAR(70) NOT NULL , 
    `role` VARCHAR(10) NOT NULL ,
    `image_path` VARCHAR(100) ,
    `verified` BOOLEAN DEFAULT FALSE ,
    `verification_token` CHAR(64) DEFAULT NULL ,
    `reset_token` CHAR(100) DEFAULT NULL ,
    `reset_token_expires` DATETIME DEFAULT NULL ,
    PRIMARY KEY (`email`)
) ENGINE = InnoDB;";

const CREATE_TABLE_THEMES = "CREATE TABLE IF NOT EXISTS `theme` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(50) NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
";

const CREATE_TABLE_TOPICS = "CREATE TABLE IF NOT EXISTS `topic` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `theme_id` INT(11) NOT NULL  ,
    `name` VARCHAR(50) NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `description` VARCHAR(200) ,
     FOREIGN KEY (`theme_id`) REFERENCES `theme`(`id`) ON DELETE CASCADE ON UPDATE CASCADE ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
";

const CREATE_TABLE_THREADS = "CREATE TABLE IF NOT EXISTS `thread` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `topic_id` INT(11) NOT NULL  ,
     `title` VARCHAR(50) NOT NULL ,
    `status` VARCHAR(20) NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `last_updater` VARCHAR(50) ,
    FOREIGN KEY (`topic_id`) REFERENCES `topic`(`id`) ON DELETE CASCADE ON UPDATE CASCADE ,
    FOREIGN KEY (`last_updater`) REFERENCES `user`(`email`) ON UPDATE CASCADE ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
";

const CREATE_TABLE_SUB_THREADS = "CREATE TABLE IF NOT EXISTS `sub_thread` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `thread_id` INT(11) NOT NULL ,
    `creator` VARCHAR(50) NOT NULL ,
    `content` TEXT NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `main` BOOLEAN NOT NULL DEFAULT FALSE ,
    PRIMARY KEY (`id`) , 
    FOREIGN KEY (`creator`) REFERENCES `user`(`email`) ON UPDATE CASCADE ,
    FOREIGN KEY (`thread_id`) REFERENCES `thread`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;
";

const COUNT_USERS = "SELECT COUNT(*) FROM `user`";
const COUNT_THEMES = "SELECT COUNT(*) FROM `theme`";
const COUNT_TOPICS = "SELECT COUNT(*) FROM `topic`";
const COUNT_THREADS = "SELECT COUNT(*) FROM `thread`";
const COUNT_SUB_THREADS = "SELECT COUNT(*) FROM `sub_thread`";

const FIND_EMAIL_USER = "SELECT * FROM `user` WHERE `email` = :email";
const FIND_USERNAME_USER = "SELECT * FROM `user` WHERE `username` = :username";
const FIND_EMAIL_VERIFIED_USER = "SELECT * FROM `user` WHERE `email` = :email AND `verified` = true";
const FIND_VERIFICATION_TOKEN_USER = "SELECT * FROM `user` WHERE `verification_token` = :verification_token";
const FIND_RESET_PASSWORD_USER = "SELECT * FROM `user` WHERE `reset_token` = :reset_token AND reset_token_expires > NOW()";

const INSERT_USER = "INSERT INTO user (email, password, username, name, surname, role, verification_token) 
    VALUES (:email, :password, :username, :name, :surname, :role, :verification_token)";

const UPDATE_VERIFIED_USER = "UPDATE `user` SET `verified` = true, `verification_token` = NULL WHERE  email = :email";

const UPDATE_RESET_PASSWORD = "UPDATE `user` SET `reset_token` = :reset_token, `reset_token_expires` = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE `email` = :email";
const UPDATE_CHANGE_PASSWORD = "UPDATE `user` SET `password` = :password, `reset_token` = NULL, `reset_token_expires` = NULL WHERE `email` = :email";

