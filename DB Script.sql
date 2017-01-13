-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'Users'
-- 
-- ---

DROP TABLE IF EXISTS `Users`;
		
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- ---
-- Table 'Games'
-- 
-- ---

DROP TABLE IF EXISTS `Games`;
		
CREATE TABLE `Games` (
  `id` INTEGER NULL AUTO_INCREMENT ,
  `topic` VARCHAR(40) NULL ,
  `admin_id` INTEGER NOT NULL,
  `players_count` INTEGER NOT NULL DEFAULT 2,
  `turns_count` INTEGER NOT NULL DEFAULT 2,
  `finished` INTEGER NOT NULL DEFAULT 0,
  `players_ready` INTEGER NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'Stories'
-- 
-- ---

DROP TABLE IF EXISTS `Stories`;
		
CREATE TABLE `Stories` (
  `id` INTEGER NULL AUTO_INCREMENT ,
  `game_id` INTEGER NOT NULL,
  `user_id` INTEGER NOT NULL,
  `text` MEDIUMTEXT NOT NULL,
  `order_number` INTEGER NOT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'Orders'
-- 
-- ---

DROP TABLE IF EXISTS `Orders`;
		
CREATE TABLE `Orders` (
  `id` INTEGER NULL AUTO_INCREMENT ,
  `game_id` INTEGER NOT NULL,
  `user_id` INTEGER NOT NULL ,
  `made_turns` INTEGER NOT NULL DEFAULT 0,
  `turn_now` INTEGER NOT NULL DEFAULT 0,
  `order_number` INTEGER NOT NULL ,
  PRIMARY KEY (`id`)
);

-- ---
-- Foreign Keys 
-- ---

ALTER TABLE `Games` ADD FOREIGN KEY (admin_id) REFERENCES `Users` (`id`);
ALTER TABLE `Stories` ADD FOREIGN KEY (game_id) REFERENCES `Games` (`id`);
ALTER TABLE `Stories` ADD FOREIGN KEY (user_id) REFERENCES `Users` (`id`);
ALTER TABLE `Orders` ADD FOREIGN KEY (game_id) REFERENCES `Games` (`id`);
ALTER TABLE `Orders` ADD FOREIGN KEY (user_id) REFERENCES `Users` (`id`);

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `Users` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `Games` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `Stories` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `Orders` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `Users` (`id`,`login`,`password`) VALUES
-- ('','','');
-- INSERT INTO `Games` (`id`,`topic`,`admin_id`,`players_count`,`turns_count`,`finished`,`players_ready`) VALUES
-- ('','','','','','','');
-- INSERT INTO `Stories` (`id`,`game_id`,`user_id`,`text`,`order_number`) VALUES
-- ('','','','','');
-- INSERT INTO `Orders` (`id`,`game_id`,`user_id`,`made_turns`,`turn_now`,`order_number`) VALUES
-- ('','','','','','');