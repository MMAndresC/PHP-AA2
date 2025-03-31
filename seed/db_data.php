<?php

const USER_DATA = [
    "INSERT INTO `user` (`username`, `name`, `surname`, `email`, `password`, `role`, `verified`) 
    VALUES ('controller', 'johnny', 'doe', 'admin@example.com', :hashed_password, 'admin', true);",
    "INSERT INTO `user` (`username`, `name`, `surname`, `email`, `password`, `role`, `verified`) 
    VALUES ('Super Pro', 'Jane', 'Doe', 'super_pro99@example.com', :hashed_password, 'moderator', true);",
    "INSERT INTO `user` (`username`, `name`, `surname`, `email`, `password`, `role`, `verified`) 
    VALUES ('anonimo97', 'Anna', 'Doe', 'gg@example.com', :hashed_password, 'user', true);"
];
const THEME_DATA = [
    "INSERT INTO `theme` (`description`,`name`, `banner`) VALUES 
      ('Comparte todas tus recetas, consejos y dudas', 'Cocina española', 'banner_spanish.png');",
    "INSERT INTO `theme` (`description`,`name`, `banner`) VALUES 
      ('Cocina tradicional mediterranea', 'Cocina mediterranea', 'banner_mediterranean.png');",
    "INSERT INTO `theme` (`description`,`name`, `banner`) VALUES 
      ('La gastronomía o cocina criolla es un estilo de cocina nacido en la época colonial, de la fusión entre las culturas europea, africana y América precolombina', 'Cocina criolla', 'banner_criolla.png');",
    "INSERT INTO `theme` (`description`,`name`, `banner`) VALUES 
      ('Comparte todas tus recetas, consejos y dudas', 'Cocina japonesa', 'banner_japanese.png');",
    "INSERT INTO `theme` (`description`,`name`, `banner`) VALUES 
      ('Comparte todas tus recetas, consejos y dudas', 'Cocina coreana', 'banner_korean.png');",
    "INSERT INTO `theme` (`description`,`name`, `banner`) VALUES 
      ('Comparte todas tus recetas, consejos y dudas', 'Cocina europea', 'banner_european.png');",
    "INSERT INTO `theme` (`description`,`name`, `banner`) VALUES 
      ('Comparte todas tus recetas, consejos y dudas', 'Cocina china', 'banner_chinese.png');",
    "INSERT INTO `theme` (`description`,`name`, `banner`) VALUES 
      ('Comparte todas tus recetas, consejos y dudas', 'Cocina mejicana', 'banner_mexican.png');",
    "INSERT INTO `theme` (`description`,`name`) VALUES ('Comparte todas tus recetas, consejos y dudas', 'Cocina paises suramericana');",
    "INSERT INTO `theme` (`description`,`name`) VALUES ('Comparte todas tus recetas, consejos y dudas', 'Cocina paises asiaticos');"
];

const THREAD_DATA = [
    "INSERT INTO `thread` (`theme_id`, `title`, `status`, `last_updater`) 
     VALUES (1, 'Cual es la mejor tortilla de patata, con cebolla o sin cebolla. Mejores trucos', 'active', 'gg@example.com');",
    "INSERT INTO `thread` (`theme_id`, `title`, `status`, `last_updater`) 
     VALUES (1, 'Mi receta de cocido', 'active', 'super_pro99@example.com');",
    "INSERT INTO `thread` (`theme_id`, `title`, `status`, `last_updater`) 
     VALUES (1, 'Los mejores macarrones', 'active', 'gg@example.com');",
    "INSERT INTO `thread` (`theme_id`, `title`, `status`, `last_updater`) 
     VALUES (1, 'Receta de flan', 'active', 'super_pro99@example.com');",
    "INSERT INTO `thread` (`theme_id`, `title`, `status`, `last_updater`) 
     VALUES (1, 'Arroz con leche, con cebolla o sin cebolla. Mejores trucos', 'active', 'gg@example.com');",
    "INSERT INTO `thread` (`theme_id`, `title`, `status`, `last_updater`) 
     VALUES (1, 'Echarle guisantes a la paella', 'active', 'super_pro99@example.com');",
     "INSERT INTO `thread` (`theme_id`, `title`, `status`, `last_updater`) 
     VALUES (4, 'La mejor manera de cocinar sushi', 'active', 'super_pro99@example.com');",
    "INSERT INTO `thread` (`theme_id`, `title`, `status`, `last_updater`) 
     VALUES (3, 'La mejor receta criolla', 'active', 'super_pro99@example.com');"
];

const SUB_THREAD_DATA = [
    "INSERT INTO `sub_thread` (`thread_id`, `author`, `content`, `main`) 
    VALUES (1, 'admin@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', TRUE);",
    "INSERT INTO `sub_thread` (`thread_id`, `author`, `content`, `main`) 
    VALUES (1, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', FALSE);",
    "INSERT INTO `sub_thread` (`thread_id`, `author`, `content`, `main`) 
    VALUES (2, 'super_pro99@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', TRUE);",
    "INSERT INTO `sub_thread` (`thread_id`, `author`, `content`, `main`) 
    VALUES (3, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', TRUE);",
    "INSERT INTO `sub_thread` (`thread_id`, `author`, `content`, `main`) 
    VALUES (4, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', TRUE);",
    "INSERT INTO `sub_thread` (`thread_id`, `author`, `content`, `main`) 
    VALUES (5, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', TRUE);",
    "INSERT INTO `sub_thread` (`thread_id`, `author`, `content`, `main`) 
    VALUES (6, 'gg@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', TRUE);"
];
