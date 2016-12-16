ALTER TABLE `fuel`.`gasstations`  
  ADD CONSTRAINT `fk_gasstation_user` FOREIGN KEY (`username`) REFERENCES `fuel`.`users`(`username`) ON UPDATE CASCADE ON DELETE CASCADE;
