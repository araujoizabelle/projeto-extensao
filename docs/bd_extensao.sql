-- MySQL Script generated by MySQL Workbench
-- Thu Oct  5 15:15:47 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema bd_evento
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bd_evento
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bd_evento` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema new_schema1
-- -----------------------------------------------------
USE `bd_evento` ;

-- -----------------------------------------------------
-- Table `bd_evento`.`tb_tipoEvento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_evento`.`tb_tipoEvento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_evento`.`tb_evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_evento`.`tb_evento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `data_inscricao` DATETIME NOT NULL,
  `tipo_evento_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_evento_tipo_evento_idx` (`tipo_evento_id` ASC),
  CONSTRAINT `fk_evento_tipo_evento`
    FOREIGN KEY (`tipo_evento_id`)
    REFERENCES `bd_evento`.`tb_tipoEvento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_evento`.`tb_horarioEvento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_evento`.`tb_horarioEvento` (
  `id` INT NOT NULL,
  `data_inicio` DATETIME NOT NULL,
  `data_termino` DATETIME NOT NULL,
  `evento_id` INT NOT NULL,
  `sala` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_evento_horario_evento1_idx` (`evento_id` ASC),
  CONSTRAINT `fk_evento_horario_evento1`
    FOREIGN KEY (`evento_id`)
    REFERENCES `bd_evento`.`tb_evento` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_evento`.`tb_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_evento`.`tb_usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `email` VARCHAR(300) NOT NULL,
  `senha` VARCHAR(300) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_evento`.`tb_inscricao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_evento`.`tb_inscricao` (
  `usuario_id` INT NOT NULL,
  `evento_id` INT NOT NULL,
  PRIMARY KEY (`usuario_id`, `evento_id`),
  INDEX `fk_participante_has_evento_evento1_idx` (`evento_id` ASC),
  INDEX `fk_participante_has_evento_participante1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_participante_has_evento_participante1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `bd_evento`.`tb_usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_participante_has_evento_evento1`
    FOREIGN KEY (`evento_id`)
    REFERENCES `bd_evento`.`tb_evento` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
