<?php

require_once "model/connection/db_connection.php";
const CREATE_DATABASE = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . "  CHARACTER SET utf8 COLLATE utf8_spanish_ci";
const CREATE_TABLE_USERS = "CREATE TABLE IF NOT EXISTS `user` ( `username` VARCHAR(20) NOT NULL , 
`name` VARCHAR(20) NOT NULL , 
`surname` VARCHAR(20) NOT NULL , 
`email` VARCHAR(50) NOT NULL , 
`password` VARCHAR(100) NOT NULL , 
PRIMARY KEY (`username`)) ENGINE = InnoDB;";

 ?>