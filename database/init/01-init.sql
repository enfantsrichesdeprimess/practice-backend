CREATE DATABASE IF NOT EXISTS mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mvc;

CREATE TABLE IF NOT EXISTS `address` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `town` VARCHAR(100) NOT NULL,
    `home` VARCHAR(50),
    `home_number` INT,
    `flat` INT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `post` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `department` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `type` ENUM('teaching', 'support', 'admin', 'other') NOT NULL DEFAULT 'other'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `workers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `surname` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100),
    `gender` ENUM('male', 'female'),
    `birthday` DATE,
    `address_id` INT,
    `post_id` INT,
    CONSTRAINT `fk_workers_address` FOREIGN KEY (`address_id`) REFERENCES `address`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_workers_post` FOREIGN KEY (`post_id`) REFERENCES `post`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `workers_in_departments` (
    `worker_id` INT,
    `department_id` INT,
    PRIMARY KEY (`worker_id`, `department_id`),
    CONSTRAINT `fk_wid_worker` FOREIGN KEY (`worker_id`) REFERENCES `workers`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_wid_dept` FOREIGN KEY (`department_id`) REFERENCES `department`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `login` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'hr') NOT NULL DEFAULT 'hr'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `address` (`town`, `home`, `home_number`, `flat`)
SELECT 'Томск', 'Ленина', 36, 14
WHERE NOT EXISTS (SELECT 1 FROM `address` WHERE `id` = 1);

INSERT INTO `post` (`id`, `name`)
SELECT 1, 'Профессор'
WHERE NOT EXISTS (SELECT 1 FROM `post` WHERE `id` = 1);

INSERT INTO `post` (`id`, `name`)
SELECT 2, 'Ассистент'
WHERE NOT EXISTS (SELECT 1 FROM `post` WHERE `id` = 2);

INSERT INTO `post` (`id`, `name`)
SELECT 3, 'Лаборант'
WHERE NOT EXISTS (SELECT 1 FROM `post` WHERE `id` = 3);

INSERT INTO `department` (`id`, `name`, `type`)
SELECT 1, 'Кафедра ИТ', 'teaching'
WHERE NOT EXISTS (SELECT 1 FROM `department` WHERE `id` = 1);

INSERT INTO `department` (`id`, `name`, `type`)
SELECT 2, 'Отдел кадров', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM `department` WHERE `id` = 2);

INSERT INTO `workers` (`id`, `name`, `surname`, `last_name`, `gender`, `birthday`, `address_id`, `post_id`)
SELECT 1, 'Иван', 'Иванов', 'Иванович', 'male', '1980-05-15', 1, 1
WHERE NOT EXISTS (SELECT 1 FROM `workers` WHERE `id` = 1);

INSERT INTO `workers_in_departments` (`worker_id`, `department_id`)
SELECT 1, 1
WHERE NOT EXISTS (
    SELECT 1 FROM `workers_in_departments` WHERE `worker_id` = 1 AND `department_id` = 1
);

INSERT INTO `users` (`login`, `password`, `role`)
SELECT 'admin', MD5('admin'), 'admin'
WHERE NOT EXISTS (SELECT 1 FROM `users` WHERE `login` = 'admin');
