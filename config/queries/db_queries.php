<?php

require_once __DIR__ . "/../db_connection.php";

/* Crear la base de datos forum*/
const CREATE_DATABASE = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . "  CHARACTER SET utf8 COLLATE utf8_spanish_ci";

/* Crear todas las tablas*/
const CREATE_TABLE_USERS = "CREATE TABLE IF NOT EXISTS `user` ( 
    `username` VARCHAR(20) NOT NULL , 
    `name` VARCHAR(30) NOT NULL , 
    `surname` VARCHAR(30) NOT NULL , 
    `email` VARCHAR(50) NOT NULL , 
    `password` VARCHAR(70) NOT NULL , 
    `role` VARCHAR(10) NOT NULL ,
    `image_name` VARCHAR(100) DEFAULT NULL ,
    `verified` BOOLEAN DEFAULT FALSE ,
    `verification_token` CHAR(64) DEFAULT NULL ,
    `verification_expires` DATETIME DEFAULT NULL,
    `reset_token` CHAR(100) DEFAULT NULL ,
    `reset_token_expires` DATETIME DEFAULT NULL ,
    PRIMARY KEY (`email`)
) ENGINE = InnoDB;";

const CREATE_TABLE_THEMES = "CREATE TABLE IF NOT EXISTS `theme` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(50) NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `description` VARCHAR(200) ,
    `banner` VARCHAR(100) DEFAULT 'banner_default.png' ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
";

const CREATE_TABLE_THREADS = "CREATE TABLE IF NOT EXISTS `thread` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `theme_id` INT(11) NOT NULL  ,
     `title` VARCHAR(50) NOT NULL ,
    `status` VARCHAR(20) NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `created_by` VARCHAR(50)  ,
    `last_updater` VARCHAR(50) ,
    FOREIGN KEY (`theme_id`) REFERENCES `theme`(`id`) ON DELETE CASCADE ON UPDATE CASCADE ,
    FOREIGN KEY (`created_by`) REFERENCES `user`(`email`) ON DELETE SET NULL ON UPDATE CASCADE ,
    FOREIGN KEY (`last_updater`) REFERENCES `user`(`email`) ON DELETE SET NULL ON UPDATE CASCADE ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
";

const CREATE_TABLE_SUB_THREADS = "CREATE TABLE IF NOT EXISTS `sub_thread` ( 
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `thread_id` INT(11) NOT NULL ,
    `author` VARCHAR(50) ,
    `content` TEXT NOT NULL ,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    `main` BOOLEAN NOT NULL DEFAULT FALSE ,
    PRIMARY KEY (`id`) , 
    FOREIGN KEY (`author`) REFERENCES `user`(`email`) ON DELETE SET NULL ON UPDATE CASCADE ,
    FOREIGN KEY (`thread_id`) REFERENCES `thread`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;
";

/* Consultas de conteo de registros de todas las tablas*/
const COUNT_USERS = "SELECT COUNT(*) FROM `user`";
const COUNT_THEMES = "SELECT COUNT(*) FROM `theme`";
const COUNT_THREADS = "SELECT COUNT(*) FROM `thread`";
const COUNT_SUB_THREADS = "SELECT COUNT(*) FROM `sub_thread`";

