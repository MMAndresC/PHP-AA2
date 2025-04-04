<?php

/* Consultas de la tabla User*/
const FIND_EMAIL_USER = "SELECT * FROM `user` WHERE `email` = :email";
const FIND_USERNAME_USER = "SELECT * FROM `user` WHERE `username` = :username";
const FIND_EMAIL_VERIFIED_USER = "SELECT * FROM `user` WHERE `email` = :email AND `verified` = true";
const FIND_VERIFICATION_TOKEN_USER = "SELECT * FROM `user` WHERE `verification_token` = :verification_token AND `verification_expires` > NOW()";
const FIND_RESET_PASSWORD_USER = "SELECT * FROM `user` WHERE `reset_token` = :reset_token AND reset_token_expires > NOW()";
const FIND_USERNAME_NOT_EMAIL_USER = "SELECT * FROM `user` WHERE `username` = :username AND `email` != :email";

const INSERT_USER = "INSERT INTO user (email, password, username, name, surname, role, verification_token, verification_expires) 
    VALUES (:email, :password, :username, :name, :surname, :role, :verification_token, DATE_ADD(NOW(), INTERVAL 1 HOUR))";

const UPDATE_VERIFIED_USER = "UPDATE `user` SET `verified` = true, `verification_token` = NULL, `verification_expires` = NULL WHERE  email = :email";
const UPDATE_RESET_PASSWORD = "UPDATE `user` SET `reset_token` = :reset_token, `reset_token_expires` = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE `email` = :email";
const UPDATE_CHANGE_PASSWORD = "UPDATE `user` SET `password` = :password, `reset_token` = NULL, `reset_token_expires` = NULL WHERE `email` = :email";
const UPDATE_EDIT_USER_WITHOUT_PASS = "UPDATE `user` SET `name` = :name, `surname` = :surname, `username` = :username, `image_name` = :image_name WHERE `email` = :email ";
const UPDATE_EDIT_USER_WITH_PASS = "UPDATE `user` SET `name` = :name, `surname` = :surname, `username` = :username, `image_name` = :image_name, `password` = :password WHERE `email` = :email ";

const DELETE_USER = "DELETE FROM `user` WHERE `email` = :email";
const DELETE_SUB_THREAD_USER = "DELETE FROM `sub_thread` WHERE `author` = :email";

