-- -----------------------------------------------------
-- Schema fuel
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fuel` DEFAULT CHARACTER SET utf8 ;
USE `fuel` ;

-- -----------------------------------------------------
-- Table `fuel`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fuel`.`users` (
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NULL,
  `password` VARCHAR(32) NOT NULL,
  `create_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`username`))
ENGINE = InnoDB;