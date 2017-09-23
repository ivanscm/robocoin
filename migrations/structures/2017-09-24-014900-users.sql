CREATE TABLE `users` (
  `id`      INT(10)        NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name`    VARCHAR(255)   NOT NULL,
  `balance` DECIMAL(10, 2) NOT NULL
)
  ENGINE = 'InnoDB'
  COLLATE 'utf8_general_ci';