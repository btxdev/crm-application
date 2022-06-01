<?php

    include_once __DIR__.'/main.php';
    include_once __DIR__.'/include_db.php';

    //

    $db->run('SET FOREIGN_KEY_CHECKS = 0;');
    $db->run('SET UNIQUE_CHECKS = 0;');

    // создание сущностей

    // создание таблицы users
    $db->run('DROP TABLE IF EXISTS `users`;');
    $db->run(
        'CREATE TABLE `users` ( 
            `uuid` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `username` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
            `password` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
            `salt` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
            `first_name` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `second_name` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `patronymic` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `phone` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `email` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `reg_date` DATE NOT NULL , 
            PRIMARY KEY (`uuid`) ,
            UNIQUE `username_index` (`username`(32))
        ) 
        ENGINE = InnoDB'
    );

    // создание таблицы orders
    $db->run('DROP TABLE IF EXISTS `orders`;');
    $db->run(
        'CREATE TABLE `orders` ( 
            `order_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `status` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `order_date` DATE NOT NULL , 
            PRIMARY KEY (`order_id`)
        ) 
        ENGINE = InnoDB'
    );

    // создание таблицы items
    $db->run('DROP TABLE IF EXISTS `items`;');
    $db->run(
        'CREATE TABLE `items` ( 
            `item_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `title` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `description` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `image` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `count` INT UNSIGNED DEFAULT 0 , 
            `price` INT UNSIGNED DEFAULT 0 , 
            PRIMARY KEY (`item_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы categories
    $db->run('DROP TABLE IF EXISTS `categories`;');
    $db->run(
        'CREATE TABLE `categories` ( 
            `category_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `title` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `icon` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            PRIMARY KEY (`category_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // сущности необходимые для авторизации

    // создание таблицы roles
    $db->run('DROP TABLE IF EXISTS `roles`;');
    $db->run(
        'CREATE TABLE `roles` ( 
            `role_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `role` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            PRIMARY KEY (`role_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы sessions
    $db->run('DROP TABLE IF EXISTS `sessions`;');
    $db->run(
        'CREATE TABLE `sessions` ( 
            `sesshash` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `uuid` INT UNSIGNED NOT NULL , 
            `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (`sesshash`(32)),
            INDEX `uuid` (`uuid`)
        )
        ENGINE = InnoDB;'
    );

    // связь users и sessions
    $db->run(
        'ALTER TABLE `sessions` ADD FOREIGN KEY (`uuid`) 
        REFERENCES `users`(`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );

    // организация связей

    $admin->relation_1N('roles', 'users', 'role_id', 'uuid');
    $admin->relation_1N('users', 'orders', 'uuid', 'order_id');
    $admin->relation_NN('orders', 'items', 'order_id', 'item_id');
    $admin->relation_NN('items', 'categories', 'item_id', 'category_id');

    //

    $db->run('SET FOREIGN_KEY_CHECKS = 1;');
    $db->run('SET UNIQUE_CHECKS = 1;');

    // создание ролей
    $admin->createRole('admin');
    $admin->createRole('default');

    // создание пользователей
    $admin_uuid = $admin->createUser('admin', 'r00tPassw0rd');

    // присвоение роли admin пользователю admin
    $admin->setRoleToUser('admin', $admin_uuid);

    // создание пользователя default
    $default_uuid = $admin->createUser('default', 'default');

    // присвоение роли default пользователю default
    $admin->setRoleToUser('default', $default_uuid);
    
    echo('ok');

?>