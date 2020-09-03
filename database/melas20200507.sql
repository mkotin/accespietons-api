ALTER TABLE `demandes` CHANGE `statut` `statut` INT(11) NULL DEFAULT 0;
ALTER TABLE `demandes` ADD `ref` VARCHAR(200) NULL AFTER `id`;

CREATE TABLE `accespietons`.`static_data`
( `id` INT NOT NULL AUTO_INCREMENT ,
 `code` VARCHAR(200) NULL ,
  `value` INT(200) NULL ,
   PRIMARY KEY (`id`)) ENGINE = InnoDB;
