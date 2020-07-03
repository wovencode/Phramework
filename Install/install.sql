--
-- PHRAMEWORK INSTALL
--

--
-- TABLE ACCOUNT
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
	`id` INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(32) NOT NULL,
	`uniqueId` VARCHAR(32) NOT NULL,
	`passwordHash` VARCHAR(255) NOT NULL,
	`newPassword` VARCHAR(255) NOT NULL,
	`avatar` VARCHAR(128) NOT NULL,
	`language` VARCHAR(32) NOT NULL,
	`email` VARCHAR(64) NOT NULL DEFAULT '',
	`newEmail` VARCHAR(64) NOT NULL DEFAULT '',
	`agent` VARCHAR(128) NOT NULL,
	`ip` VARCHAR(64) NOT NULL,
	`securityToken` VARCHAR(64) NOT NULL,
	`loginToken` VARCHAR(64) NOT NULL,
	`penalty` INT(3) NOT NULL,
	`rememberMe` INT(1) NOT NULL,
	`admin` INT(1) NOT NULL,
	`confirmed` INT(1) NOT NULL,
	`deleted` INT(1) NOT NULL,
	`banned` INT(1) NOT NULL,
	`created` DATETIME NOT NULL,
	`lastlogin` DATETIME NOT NULL,
	`lastriskyaction` DATETIME NOT NULL,
	`lastVeryRiskyAction` DATETIME NOT NULL,
	`lasttoken` DATETIME NOT NULL,
	`lastonline` DATETIME NOT NULL
);

--
-- TABLE SYSTEM TASK
--

DROP TABLE IF EXISTS `system_task`;
CREATE TABLE `system_task` (
	`id` INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(32) NOT NULL,
	`count` INT(9) NOT NULL,
	`tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);