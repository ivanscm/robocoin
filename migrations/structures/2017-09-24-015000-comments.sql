CREATE TABLE `comments` (
  `id`      INT     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(10) NOT NULL,
  `text`    TEXT    NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE NO ACTION
)
  ENGINE = 'InnoDB'
  COLLATE 'utf8_general_ci';