<?php

    include_once __DIR__.'/main.php';
    include_once __DIR__.'/include_db.php';

    // === создание сущностей ===

    $db->run('SET FOREIGN_KEY_CHECKS = 0;');
    $db->run('SET UNIQUE_CHECKS = 0;');

    // создание таблицы employees
    $db->run('DROP TABLE IF EXISTS `employees`;');
    $db->run(
        'CREATE TABLE `employees` ( 
            `employee_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `username` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
            `password` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
            `salt` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL ,
            `first_name` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `seconds_name` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `patronymic` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `phone` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `email` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `reg_date` DATE NOT NULL , 
            PRIMARY KEY (`employee_id`) ,
            UNIQUE `username_index` (`username`(32))
        ) 
        ENGINE = InnoDB'
    );

    // создание таблицы clients
    $db->run('DROP TABLE IF EXISTS `clients`;');
    $db->run(
        'CREATE TABLE `clients` ( 
            `client_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `first_name` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `seconds_name` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `patronymic` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `birth_date` DATE NOT NULL , 
            `phone` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `email` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL , 
            `reg_date` DATE NOT NULL , 
            PRIMARY KEY (`client_id`)
        ) 
        ENGINE = InnoDB'
    );

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

    // создание таблицы positions
    $db->run('DROP TABLE IF EXISTS `positions`;');
    $db->run(
        'CREATE TABLE `positions` ( 
            `position_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `position` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            PRIMARY KEY (`position_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы apartments
    $db->run('DROP TABLE IF EXISTS `apartments`;');
    $db->run(
        'CREATE TABLE `apartments` ( 
            `apartment_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `type` INT UNSIGNED NOT NULL , 
            `address` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `developer` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `construction_date` DATE NOT NULL , 
            `publication_date` DATE NOT NULL , 
            `price` INT UNSIGNED NOT NULL , 
            PRIMARY KEY (`apartment_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы contracts
    $db->run('DROP TABLE IF EXISTS `contracts`;');
    $db->run(
        'CREATE TABLE `contracts` ( 
            `contract_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `type` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `date` DATE NOT NULL , 
            PRIMARY KEY (`contract_id`)
        ) 
        ENGINE = InnoDB'
    );

    // создание таблицы passports
    $db->run('DROP TABLE IF EXISTS `passports`;');
    $db->run(
        'CREATE TABLE `passports` ( 
            `passport_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `number` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `birth_location` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `address` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `birth_date` DATE NOT NULL , 
            `organ` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `issue_date` DATE NOT NULL , 
            PRIMARY KEY (`passport_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы services
    $db->run('DROP TABLE IF EXISTS `services`;');
    $db->run(
        'CREATE TABLE `services` ( 
            `service_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `service` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `description` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `price` INT UNSIGNED NOT NULL , 
            PRIMARY KEY (`service_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы deals
    $db->run('DROP TABLE IF EXISTS `deals`;');
    $db->run(
        'CREATE TABLE `deals` ( 
            `deal_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `deal` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `deal_date` DATE NOT NULL , 
            PRIMARY KEY (`deal_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы sessions
    $db->run('DROP TABLE IF EXISTS `sessions`;');
    $db->run(
        'CREATE TABLE `sessions` ( 
            `sesshash` TINYTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
            `employee_id` INT UNSIGNED NOT NULL , 
            `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (`sesshash`(32)),
            INDEX `employee_id` (`employee_id`)
        )
        ENGINE = InnoDB;'
    );

    // === таблицы для организации связей многие ко многим, один ко многим ===

    // создание таблицы employees_roles
    $db->run('DROP TABLE IF EXISTS `employees_roles`;');
    $db->run(
        'CREATE TABLE `employees_roles` ( 
            `employee_id` INT UNSIGNED NOT NULL , 
            `role_id` INT UNSIGNED NOT NULL , 
            PRIMARY KEY (`employee_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы employees_positions
    $db->run('DROP TABLE IF EXISTS `employees_positions`;');
    $db->run(
        'CREATE TABLE `employees_positions` ( 
            `employee_id` INT UNSIGNED NOT NULL , 
            `position_id` INT UNSIGNED NOT NULL , 
            PRIMARY KEY (`employee_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы deals_services
    $db->run('DROP TABLE IF EXISTS `deals_services`;');
    $db->run(
        'CREATE TABLE `deals_services` ( 
            `deal_id` INT UNSIGNED NOT NULL , 
            `service_id` INT UNSIGNED NOT NULL , 
            PRIMARY KEY (`deal_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы deals_apartments
    $db->run('DROP TABLE IF EXISTS `deals_apartments`;');
    $db->run(
        'CREATE TABLE `deals_apartments` ( 
            `deal_id` INT UNSIGNED NOT NULL , 
            `apartment_id` INT UNSIGNED NOT NULL , 
            PRIMARY KEY (`deal_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы deals_contracts
    $db->run('DROP TABLE IF EXISTS `deals_contracts`;');
    $db->run(
        'CREATE TABLE `deals_contracts` ( 
            `deal_id` INT UNSIGNED NOT NULL , 
            `contract_id` INT UNSIGNED NOT NULL , 
            PRIMARY KEY (`deal_id`) , 
            INDEX `contract_id` (`contract_id`)
        )
        ENGINE = InnoDB;'
    );

    // создание таблицы deals_clients
    $db->run('DROP TABLE IF EXISTS `deals_clients`;');
    $db->run(
        'CREATE TABLE `deals_clients` ( 
            `deal_id` INT UNSIGNED NOT NULL , 
            `client_id` INT UNSIGNED NOT NULL , 
            PRIMARY KEY (`deal_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // создание таблицы clients_passports
    $db->run('DROP TABLE IF EXISTS `clients_passports`;');
    $db->run(
        'CREATE TABLE `clients_passports` ( 
            `client_id` INT UNSIGNED NOT NULL , 
            `passport_id` INT UNSIGNED NOT NULL , 
            PRIMARY KEY (`client_id`) , 
            INDEX `passport_id` (`passport_id`)
        )
        ENGINE = InnoDB;'
    );

    // создание таблицы deals_employees
    $db->run('DROP TABLE IF EXISTS `deals_employees`;');
    $db->run(
        'CREATE TABLE `deals_employees` ( 
            `deal_id` INT UNSIGNED NOT NULL , 
            `employee_id` INT UNSIGNED NOT NULL , 
            PRIMARY KEY (`deal_id`)
        ) 
        ENGINE = InnoDB;'
    );

    // === организация связей ===

    $db->run('SET FOREIGN_KEY_CHECKS = 1;');
    $db->run('SET UNIQUE_CHECKS = 1;');

    // employees --- roles
    // установка связи между таблицами employees и employees_roles по индексу employee_id
    // при удалении пользователя, будет удалена запись о роли этого пользователя
    $db->run(
        'ALTER TABLE `employees_roles` ADD FOREIGN KEY (`employee_id`) 
        REFERENCES `employees`(`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );
    // установка связи между таблицами employees и employees_roles по индексу role_id
    // при удалении роли, эта роль будет удалена у всех пользователей
    $db->run(
        'ALTER TABLE `employees_roles` ADD FOREIGN KEY (`role_id`) 
        REFERENCES `roles`(`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );

    // employees --- sessions
    // установка связи между таблицами employees и employees_sessions по индексу employee_id
    // при удалении пользователя, будет удалены все сессии этого пользователя
    $db->run(
        'ALTER TABLE `sessions` ADD FOREIGN KEY (`employee_id`) 
        REFERENCES `employees`(`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );

    // employees --- positions
    $db->run(
        'ALTER TABLE `employees_positions` ADD FOREIGN KEY (`employee_id`) 
        REFERENCES `employees`(`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );
    $db->run(
        'ALTER TABLE `employees_positions` ADD FOREIGN KEY (`position_id`) 
        REFERENCES `positions`(`position_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );

    // deals --- services
    $db->run(
        'ALTER TABLE `deals_services` ADD FOREIGN KEY (`deal_id`) 
        REFERENCES `deals`(`deal_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );
    $db->run(
        'ALTER TABLE `deals_services` ADD FOREIGN KEY (`service_id`) 
        REFERENCES `services`(`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );

    // deals --- apartments
    $db->run(
        'ALTER TABLE `deals_apartments` ADD FOREIGN KEY (`deal_id`) 
        REFERENCES `deals`(`deal_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );
    $db->run(
        'ALTER TABLE `deals_apartments` ADD FOREIGN KEY (`apartment_id`) 
        REFERENCES `apartments`(`apartment_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );

    // deals --- clients
    $db->run(
        'ALTER TABLE `deals_clients` ADD FOREIGN KEY (`deal_id`) 
        REFERENCES `deals`(`deal_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );
    $db->run(
        'ALTER TABLE `deals_clients` ADD FOREIGN KEY (`client_id`) 
        REFERENCES `clients`(`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );

    // deals --- contracts
    $db->run(
        'ALTER TABLE `deals_contracts` ADD FOREIGN KEY (`deal_id`) 
        REFERENCES `deals`(`deal_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );
    $db->run(
        'ALTER TABLE `deals_contracts` ADD FOREIGN KEY (`contract_id`) 
        REFERENCES `contracts`(`contract_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );

    // clients --- passports
    $db->run(
        'ALTER TABLE `clients_passports` ADD FOREIGN KEY (`client_id`) 
        REFERENCES `clients`(`client_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );
    $db->run(
        'ALTER TABLE `clients_passports` ADD FOREIGN KEY (`passport_id`) 
        REFERENCES `passports`(`passport_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );

    // deals --- employees
    $db->run(
        'ALTER TABLE `deals_employees` ADD FOREIGN KEY (`deal_id`) 
        REFERENCES `deals`(`deal_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );
    $db->run(
        'ALTER TABLE `deals_employees` ADD FOREIGN KEY (`employee_id`) 
        REFERENCES `employees`(`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;'
    );

    // === создание ролей ===
    $admin->createRole('admin');
    $admin->createRole('default');

    // создание пользователя admin
    $admin_uuid = $admin->createUser('admin', 'r00tPassw0rd');

    // присвоение роли admin пользователю admin
    $admin->setRoleToUser('admin', $admin_uuid);

    // создание пользователя test
    $user_uuid = $admin->createUser('test', '123456');

    // присвоение роли default пользователю test
    $admin->setRoleToUser('default', $user_uuid);
    
    echo('ok');

?>