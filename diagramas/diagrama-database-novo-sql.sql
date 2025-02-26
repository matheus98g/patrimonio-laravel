CREATE TABLE `users` (
  `id` int PRIMARY KEY,
  `name` integer,
  `email` varchar(255),
  `password` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `ativos` (
  `id` int PRIMARY KEY,
  `descricao` varchar(255),
  `quantidade` int,
  `quantidade_min` int,
  `status` varchar(255),
  `id_tipo` int,
  `id_marca` int,
  `id_user` int,
  `imagem` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `locais` (
  `id` int PRIMARY KEY,
  `descricao` varchar(255),
  `observacao` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `tipos` (
  `id` int PRIMARY KEY,
  `descricao` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `marcas` (
  `id` int PRIMARY KEY,
  `descricao` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `ativo_local` (
  `id` int PRIMARY KEY,
  `id_ativo` int,
  `id_local` int,
  `quantidade` int,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `movimentacoes` (
  `id` int PRIMARY KEY,
  `id_user` int,
  `id_ativo` int,
  `quantidade_mov` int,
  `local_origem` int,
  `local_destino` int,
  `status` varchar(255),
  `observacao` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

ALTER TABLE `tipos` ADD FOREIGN KEY (`id`) REFERENCES `ativos` (`id_tipo`);

ALTER TABLE `marcas` ADD FOREIGN KEY (`id`) REFERENCES `ativos` (`id_marca`);

ALTER TABLE `users` ADD FOREIGN KEY (`id`) REFERENCES `ativos` (`id_user`);

ALTER TABLE `ativos` ADD FOREIGN KEY (`id`) REFERENCES `ativo_local` (`id_ativo`);

ALTER TABLE `locais` ADD FOREIGN KEY (`id`) REFERENCES `ativo_local` (`id_local`);

ALTER TABLE `users` ADD FOREIGN KEY (`id`) REFERENCES `movimentacoes` (`id_user`);

ALTER TABLE `ativos` ADD FOREIGN KEY (`id`) REFERENCES `movimentacoes` (`id_ativo`);

ALTER TABLE `locais` ADD FOREIGN KEY (`id`) REFERENCES `movimentacoes` (`local_origem`);

ALTER TABLE `locais` ADD FOREIGN KEY (`id`) REFERENCES `movimentacoes` (`local_destino`);
