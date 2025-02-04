-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/02/2025 às 00:27
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
-- Banco de dados: `db_academia2`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `aluno_cod` int(11) NOT NULL,
  `aluno_nome` varchar(250) NOT NULL,
  `aluno_cpf` varchar(250) NOT NULL,
  `aluno_endereco` varchar(250) NOT NULL,
  `aluno_telefone` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `aula`
--

CREATE TABLE `aula` (
  `aula_cod` int(11) NOT NULL,
  `aula_tipo` enum('boxe','natacao','musculacao','yoga','crossfit','aerobico','pilates') NOT NULL,
  `aula_data` date NOT NULL,
  `aula_horario` time(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `instrutores`
--

CREATE TABLE `instrutores` (
  `instrutor_cod` int(11) NOT NULL,
  `instrutor_nome` varchar(250) NOT NULL,
  `instrutor_especialidade` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_cod` int(11) NOT NULL,
  `usuario_nome` varchar(100) NOT NULL,
  `usuario_senha` varchar(255) NOT NULL,
  `usuario_tipo` enum('aluno','instrutor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`aluno_cod`);

--
-- Índices de tabela `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`aula_cod`);

--
-- Índices de tabela `instrutores`
--
ALTER TABLE `instrutores`
  ADD PRIMARY KEY (`instrutor_cod`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_cod`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_cod` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
