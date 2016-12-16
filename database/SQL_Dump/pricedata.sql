-- -----------------------------------------------------
-- Schema fuel
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fuel` DEFAULT CHARACTER SET utf8 ;
USE `fuel` ;

-- -----------------------------------------------------
-- Table `fuel`.`pricedata`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fuel`.`pricedata` (
  `gasStationID` SMALLINT UNSIGNED NOT NULL,
  `fuelTypeID` TINYINT UNSIGNED NOT NULL,
  `fuelSubTypeID` TINYINT UNSIGNED NOT NULL,
  `fuelNormalName` VARCHAR(64) NOT NULL,
  `fuelName` VARCHAR(128) NOT NULL,
  `fuelPrice` DECIMAL(4,3) NOT NULL,
  `dateUpdated` TIMESTAMP NULL,
  `isPremium` TINYINT(1) NULL,
  PRIMARY KEY (`gasStationID`, `fuelTypeID`, `fuelSubTypeID`),
  CONSTRAINT `fk_pricedata_gasstations`
  FOREIGN KEY (`gasStationID`)
  REFERENCES `fuel`.`gasstations` (`gasStationID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
  ENGINE = InnoDB;