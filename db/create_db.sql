
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(40) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `hash` varchar(256) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `user_type` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `hash`, `activated`, `user_type`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@mail.invalid', '$2y$10$65g7M7Zpx5v7Mk65T59Vf.zREqI3m2gkpa/vaOHdpSGhf0E92On6q', '', 1, 100, NULL, '2019-03-27 13:57:32');