CREATE TABLE `transfers` (
  `id`           INT            NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `from_user_id` INT            NOT NULL,
  `to_user_id`   INT            NOT NULL,
  `type`         VARCHAR(24)    NOT NULL,
  `amout`        DECIMAL(10, 2) NOT NULL,
  `dt`           DATETIME       NOT NULL
)
  ENGINE = 'InnoDB'
  COLLATE 'utf8_general_ci';