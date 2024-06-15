-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/06/2024 às 02:53
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `conexao_php`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(3, 'Sara', 'sara@gmail.com', '$2y$10$otkbG8vKjUaB5MKG/NErDOgBsB28c4FgY/GvWF7xyXuH0Ds17rYHu'),
(4, 'Taylor', 'taylor@gmail.com', '$2y$10$7aL5lrSE.FMW.kl5owFc6ejba2z3MNXaAFt3usqY5c9dM/4gYdEg.'),
(5, 'Julia', 'julia@gmail.com', '$2y$10$4DBqKzw3UKS0fWkWKxBaz.PfaN5l98Ws9WVXOe.8ncKqZZ.Spc1Km'),
(7, 'Fernanda', 'fernanda@gmail.com', '$2y$10$Tv6A1mW.Tx/vMDSH7Updo.asW68RXjj1VpGRYM5lNyayaeo9NKHda'),
(8, 'Fernanda', 'fernanda@gmail.com', '$2y$10$Tyr1FQ8xfv2NgN2t3ZTjn..FtJJQVeSp/LzllKz3F4J1fvA/QtBZO');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
