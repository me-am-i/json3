CREATE DATABASE IF NOT EXISTS gp_DB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

USE gp_DB;

CREATE TABLE IF NOT EXISTS `posts` (
    `id` int UNSIGNED UNIQUE NOT NULL,
    `userId` int UNSIGNED NOT NULL,
    `title` text NOT NULL,
    `body` text NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comments` (
    `id` int UNSIGNED UNIQUE NOT NULL,
    `postId` int UNSIGNED NOT NULL,
    `name` text NOT NULL,
    `email` varchar(255) NOT NULL,
    `body` text NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
