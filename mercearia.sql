-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/11/2024 às 19:55
-- Versão do servidor: 8.0.33
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mercearia`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `detalhes_encomenda`
--

CREATE TABLE `detalhes_encomenda` (
  `id` int NOT NULL,
  `encomenda_id` int NOT NULL,
  `produto_nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quantidade` int NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `detalhes_encomenda`
--

INSERT INTO `detalhes_encomenda` (`id`, `encomenda_id`, `produto_nome`, `quantidade`, `preco_unitario`) VALUES
(1, 30, 'Escrivaninha', 2, 300.00),
(2, 31, 'Cadeira de Madeira', 1, 150.00),
(3, 31, 'Banco de Jardim', 1, 120.00),
(4, 32, 'Escrivaninha', 2, 300.00),
(5, 33, 'Banco de Jardim', 2, 120.00),
(6, 34, 'Mesa de Cabiceira', 2, 600.00),
(7, 35, 'Mesa de Cabiceira', 2, 600.00),
(8, 36, 'Porta de Madeira', 1, 1000.00),
(9, 37, 'Porta de Madeira', 1, 1000.00),
(10, 38, 'Porta de Madeira', 1, 1000.00),
(11, 39, 'Porta de Madeira', 18, 1000.00),
(12, 40, 'Mesa de Cabiceira', 1, 600.00),
(13, 41, 'Mesa de Cabiceira', 1, 600.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `id` int NOT NULL,
  `nome_cliente` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `morada` text COLLATE utf8mb4_general_ci NOT NULL,
  `produtos` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantidade_total` int NOT NULL,
  `preco_total` decimal(10,2) NOT NULL,
  `data_encomenda` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `encomendas`
--

INSERT INTO `encomendas` (`id`, `nome_cliente`, `data_nascimento`, `morada`, `produtos`, `quantidade_total`, `preco_total`, `data_encomenda`) VALUES
(30, 'Mayran', '2000-01-01', 'vila irma dulce', '[\"Escrivaninha (x2)\"]', 2, 600.00, '2024-11-25 22:26:55'),
(31, 'Jessica Maria', '1991-11-11', 'Pio 12', '[\"Cadeira de Madeira (x1)\",\"Banco de Jardim (x1)\"]', 2, 270.00, '2024-11-26 00:29:59'),
(32, 'Gabriela', '1996-11-30', 'Hugo Napoleao', '[\"Escrivaninha (x2)\"]', 2, 600.00, '2024-11-26 18:46:51'),
(33, 'Flavio', '1996-02-20', 'teste', '[\"Banco de Jardim (x2)\"]', 2, 240.00, '2024-11-26 22:35:55'),
(34, 'Cleiane', '2000-05-01', 'Hugo Napoleao', '[\"Mesa de Cabiceira (x2)\"]', 2, 1200.00, '2024-11-27 16:49:07'),
(36, 'Teste', '2001-01-01', 'Teste final', '[\"Porta de Madeira (x1)\"]', 1, 1000.00, '2024-11-27 17:49:51'),
(40, 'Teste 2', '2000-01-01', 'Teste 2', '[\"Mesa de Cabiceira (x1)\"]', 1, 600.00, '2024-11-27 22:42:57'),
(41, 'Flavio', '2001-01-01', 'Porto', '[\"Mesa de Cabiceira (x1)\"]', 1, 600.00, '2024-11-27 22:45:25');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `quantidade` int NOT NULL,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `quantidade`, `preco`) VALUES
(1, 'Cadeira de Madeira', 12, 300.00),
(2, 'Mesa de Jantar', 0, 2220.00),
(3, 'Estante para Livros', 8, 1500.00),
(4, 'Escrivaninha', 11, 525.00),
(5, 'Banco de Jardim', 10, 420.00),
(6, 'Mesa de Cabiceira', 13, 600.00),
(7, 'Porta de Madeira', 13, 1000.00),
(8, 'Buffet de Madeira', 5, 1200.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id` int NOT NULL,
  `nome_usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id`, `nome_usuario`, `senha`) VALUES
(1, 'admin', '1234');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `detalhes_encomenda`
--
ALTER TABLE `detalhes_encomenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `encomenda_id` (`encomenda_id`);

--
-- Índices de tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_utilizador` (`nome_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `detalhes_encomenda`
--
ALTER TABLE `detalhes_encomenda`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `detalhes_encomenda`
--
ALTER TABLE `detalhes_encomenda`
  ADD CONSTRAINT `detalhes_encomenda_ibfk_1` FOREIGN KEY (`encomenda_id`) REFERENCES `encomendas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
