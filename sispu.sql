-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 11-Dez-2016 às 01:18
-- Versão do servidor: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.12-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sispu`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `apoiar`
--

CREATE TABLE `apoiar` (
  `codigo_demanda` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `icone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`codigo`, `nome`, `icone`) VALUES
(1, 'Categoria1', 'lixeira.png'),
(2, 'Categoria2', 'astahpng_489185714.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario`
--

CREATE TABLE `comentario` (
  `codigo` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `codigo_demanda` int(11) NOT NULL,
  `mensagem` text,
  `dataComentario` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `demanda`
--

CREATE TABLE `demanda` (
  `codigo` int(11) NOT NULL,
  `codigo_categoria` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `rua` varchar(50) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `descricao` text NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `dataDemanda` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `demanda`
--

INSERT INTO `demanda` (`codigo`, `codigo_categoria`, `codigo_usuario`, `rua`, `bairro`, `latitude`, `longitude`, `descricao`, `foto`, `dataDemanda`) VALUES
(1, 1, 1, 'Nome da rua', 'Centro, Quixadá - CE, Brasil', -4.968650745138457, -39.018287658855115, 'aQUI É RUIM', 'formulapng_1035661790.png', '03/12/2016'),
(2, 1, 1, 'Rua X', 'Planalto Renascer, Quixadá - CE, Brasil', -4.963862270955677, -39.029273986980115, 'Pq sim', 'astahpng_971276677.png', '09/12/2016');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nivel` int(11) DEFAULT NULL,
  `dataCadastro` varchar(10) DEFAULT NULL,
  `session_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codigo`, `nome`, `email`, `senha`, `nivel`, `dataCadastro`, `session_id`) VALUES
(1, 'Jordão', 'jordao05@hotmail.com', '$2a$08$ce1NsXJHTx9U47kJfok7m.UcJwUT7WYiD0ZvTVTE.2v135sk.TJ.O', 1, '03/12/2016', 'knau4ing5je6o6r2okgvdfm160');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apoiar`
--
ALTER TABLE `apoiar`
  ADD PRIMARY KEY (`codigo_demanda`,`codigo_usuario`),
  ADD KEY `apoiar_FK2` (`codigo_usuario`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `comentario_FK1` (`codigo_demanda`),
  ADD KEY `comentario_FK2` (`codigo_usuario`);

--
-- Indexes for table `demanda`
--
ALTER TABLE `demanda`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `demanda_FK1` (`codigo_categoria`),
  ADD KEY `demanda_FK2` (`codigo_usuario`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `comentario`
--
ALTER TABLE `comentario`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `demanda`
--
ALTER TABLE `demanda`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `apoiar`
--
ALTER TABLE `apoiar`
  ADD CONSTRAINT `apoiar_FK1` FOREIGN KEY (`codigo_demanda`) REFERENCES `demanda` (`codigo`),
  ADD CONSTRAINT `apoiar_FK2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`);

--
-- Limitadores para a tabela `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_FK1` FOREIGN KEY (`codigo_demanda`) REFERENCES `demanda` (`codigo`),
  ADD CONSTRAINT `comentario_FK2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`);

--
-- Limitadores para a tabela `demanda`
--
ALTER TABLE `demanda`
  ADD CONSTRAINT `demanda_FK1` FOREIGN KEY (`codigo_categoria`) REFERENCES `categoria` (`codigo`),
  ADD CONSTRAINT `demanda_FK2` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
