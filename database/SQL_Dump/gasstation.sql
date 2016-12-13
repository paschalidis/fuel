-- -----------------------------------------------------
-- Schema fuel
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fuel` DEFAULT CHARACTER SET utf8 ;
USE `fuel` ;

-- -----------------------------------------------------
-- Table `fuel`.`gasstations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fuel`.`gasstations` (
  `gasStationID` SMALLINT UNSIGNED NOT NULL,
  `gasStationLat` DECIMAL(10,7) NULL,
  `gasStationLong` DECIMAL(10,7) NULL,
  `fuelCompID` TINYINT NOT NULL,
  `fuelCompNormalName` VARCHAR(45) NOT NULL,
  `gasStationOwner` VARCHAR(128) NOT NULL,
  `ddID` VARCHAR(10) NOT NULL,
  `ddNormalName` VARCHAR(45) NOT NULL,
  `municipalityID` VARCHAR(10) NOT NULL,
  `municipalityNormalName` VARCHAR(45) NOT NULL,
  `countyID` VARCHAR(10) NOT NULL,
  `countyName` VARCHAR(64) NOT NULL,
  `gasStationAddress` VARCHAR(255) NULL,
  `phone1` CHAR(10) NULL,
  `username` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`gasStationID`))
ENGINE = InnoDB;