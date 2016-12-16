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