CREATE DATABASE prueba;

USE prueba;

CREATE TABLE `prueba`.`lista_de_tareas` (
  `id_task` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `v_description` VARCHAR(1000) NOT NULL,
  `d_execution_time` DATETIME,
  `i_finished` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`id_task`));
