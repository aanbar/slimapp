CREATE TABLE `users`(
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB CHARSET=utf8;

# password=admin
INSERT INTO `users` (first_name, last_name, email, password) VALUES ('Example', 'User', 'admin@example.com', '$2y$10$0h2pZJZJBgF/Um2mlnIfnOs9SOg6Vt6qtBtnWsMdRDPQn1GZgHgtO');
