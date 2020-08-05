-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `application`;
CREATE TABLE `application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `token` varchar(250) NOT NULL,
  `secret` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `application` (`id`, `name`, `token`, `secret`, `created_at`) VALUES
(1,	'localhost',	'token-1234567',	'secret-12345678',	'2020-08-05 14:14:59');

DROP TABLE IF EXISTS `chatting`;
CREATE TABLE `chatting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `participant_token` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chatting_id` (`room_id`),
  CONSTRAINT `chatting_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `participant`;
CREATE TABLE `participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `local_id` varchar(100) DEFAULT NULL,
  `token` varchar(250) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `token` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `application_id` (`application_id`),
  CONSTRAINT `room_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `room_participant`;
CREATE TABLE `room_participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  KEY `user_id` (`participant_id`),
  CONSTRAINT `room_participant_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`),
  CONSTRAINT `room_participant_ibfk_2` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2020-08-05 08:08:57
