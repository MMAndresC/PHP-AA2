<?php

const USER_DATA = [
    "INSERT INTO `user` (`username`, `name`, `surname`, `email`, `password`, `role`, `image_path`, `verified`) 
    VALUES ('controller', 'johnny', 'doe', 'admin@example.com', :hashed_password, 'admin', 'images/controller.jpg', true);",
    "INSERT INTO `user` (`username`, `name`, `surname`, `email`, `password`, `role`, `image_path`, `verified`) 
    VALUES ('Super Pro', 'Jane', 'Doe', 'super_pro99@example.com', :hashed_password, 'moderator', 'images/super_pro.jpg', true);",
    "INSERT INTO `user` (`username`, `name`, `surname`, `email`, `password`, `role`, `image_path`, `verified`) 
    VALUES ('anonimo97', 'Anna', 'Doe', 'gg@example.com', :hashed_password, 'user', 'images/anonimo.jpg', true);"
];

const THEME_DATA = [
    "INSERT INTO `theme` (`name`) VALUES ('General');",
    "INSERT INTO `theme` (`name`) VALUES ('Personajes');",
    "INSERT INTO `theme` (`name`) VALUES ('Multimedia');"
];
const TOPIC_DATA = [
    "INSERT INTO `topic` (`theme_id`,`name`) VALUES (1, 'Temporada 1');",
    "INSERT INTO `topic` (`theme_id`,`name`) VALUES (1, 'Temporada 2');",
    "INSERT INTO `topic` (`theme_id`,`name`) VALUES (1, 'Temporada 3');",
    "INSERT INTO `topic` (`theme_id`,`name`) VALUES (1, 'Spoilers');",
    "INSERT INTO `topic` (`theme_id`,`name`, `description`) VALUES (1, 'Lore', 'Mundo donde se desarrolla la historia');",
    "INSERT INTO `topic` (`theme_id`,`name`) VALUES (1, 'Curiosidades');",
    "INSERT INTO `topic` (`theme_id`,`name`, `description`) VALUES (1, 'Libros', 'Discusion sobre los libros');",
    "INSERT INTO `topic` (`theme_id`, `name`) VALUES (2, 'Rand alThor');",
    "INSERT INTO `topic` (`theme_id`,`name`) VALUES (2, 'Moirane Damodred');",
    "INSERT INTO `topic` (`theme_id`,`name`) VALUES (2, 'Mat Cauthon');",
    "INSERT INTO `topic` (`theme_id`,`name`, `description`) VALUES (3, 'Premieres', 'Entrevistas pre-temporadas');"
];

const THREAD_DATA = [
    "INSERT INTO `thread` (`topic_id`, `title`, `status`, `last_updater`) 
     VALUES (1, 'Desarrollo de la historia', 'open', 'gg@example.com');",
    "INSERT INTO `thread` (`topic_id`, `title`, `status`, `last_updater`) 
     VALUES (1, 'Mejores escenas', 'open', 'super_pro99@example.com');"
];

const SUB_THREAD_DATA = [
    "INSERT INTO `sub_thread` (`thread_id`, `creator`, `content`, `main`) 
    VALUES (1, 'admin@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', TRUE);",
    "INSERT INTO `sub_thread` (`thread_id`, `creator`, `content`, `main`) 
    VALUES (1, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', FALSE);",
    "INSERT INTO `sub_thread` (`thread_id`, `creator`, `content`, `main`) 
    VALUES (2, 'super_pro99@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', TRUE);"
];
