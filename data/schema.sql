CREATE DATABASE IF NOT EXISTS forhonor;

DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `fighter`;

CREATE TABLE `fighter` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `Name` varchar(20) NOT NULL,
 `Class` int(11) NOT NULL, --0 = Tank, 1 = Assassin, 2 = Warrior
 `HealthPoints` int(11) NOT NULL,
 `StrengthPoints` int(11) NOT NULL,
 PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `Username` varchar(30) NOT NULL,
 `Password` varchar(255) NOT NULL,
 `Fighter_ID` int(11) DEFAULT NULL,
 `Wins` int(11) NOT NULL DEFAULT '0',
 `TotalGames` int(11) NOT NULL DEFAULT '0',
 `Points` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
  FOREIGN KEY (`Fighter_ID`) 
  REFERENCES `fighter`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

