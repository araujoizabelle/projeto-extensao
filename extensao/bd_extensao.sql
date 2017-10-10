-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2017 at 04:52 AM
-- Server version: 5.6.35
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bd_evento`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_evento`
--

CREATE TABLE `tb_evento` (
  `id` int(11) NOT NULL,
  `nome` varchar(180) NOT NULL,
  `data_inscricao` datetime DEFAULT NULL,
  `tipo_evento_id` int(11) NOT NULL,
  `autor` varchar(300) DEFAULT NULL,
  `descricao` text,
  `foto` varchar(300) DEFAULT NULL,
  `autor_bio` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_evento`
--

INSERT INTO `tb_evento` (`id`, `nome`, `data_inscricao`, `tipo_evento_id`, `autor`, `descricao`, `foto`, `autor_bio`) VALUES
(1, 'Empreendendo com Química e Arte', NULL, 1, NULL, NULL, NULL, NULL),
(2, 'Considerações sobre a carreira de Engenheira Eletrônica', NULL, 1, NULL, NULL, NULL, NULL),
(3, 'Introdução à GNU/Linux', NULL, 2, NULL, NULL, NULL, NULL),
(4, 'Modelagem de Processos de Negócio Utilizando o Bizagi', NULL, 2, NULL, NULL, NULL, NULL),
(5, 'Oratória: Comunicação e Técnicas de Apresentação de Trabalhos Acadêmicos', NULL, 2, NULL, NULL, NULL, NULL),
(6, 'Oficina de reciclagem de papel', NULL, 4, NULL, NULL, NULL, NULL),
(7, 'Qualidade de Energia Elétrica em Sistemas de Distribuição', NULL, 1, NULL, NULL, NULL, NULL),
(8, 'CURSO BÁSICO DE ARDUÍNO', NULL, 2, NULL, NULL, NULL, NULL),
(9, 'Modelagem de Processos de Negócio Utilizando o Bizagi', NULL, 2, NULL, NULL, NULL, NULL),
(10, 'Cinema e sociedade em diálogo: a matemática em nossas vidas', NULL, 4, NULL, NULL, NULL, NULL),
(11, 'Intercâmbio Estudantil pelo CEFET/RJ campus Nova Friburgo: relatos e experiências', NULL, 1, NULL, NULL, NULL, NULL),
(12, 'O Programa de Extensão CELi (Centro de Educação e Linguagens) do CEFET/RJ Nova Friburgo:\r\n    avaliações de alunos concluintes sobre o curso de língua inglesa', NULL, 1, NULL, NULL, NULL, NULL),
(13, 'Pilotando com a Bússola Acadêmica: desenho de um protótipo funcional premilinar', NULL, 1, NULL, NULL, NULL, NULL),
(14, 'Oficina de leitura e escrita literária', NULL, 4, NULL, NULL, NULL, NULL),
(15, 'Pensando a pontuação na produção de textos', NULL, 2, NULL, NULL, NULL, NULL),
(16, 'A tecnologia da Célula Combustível a hidrogênio e a aprendizagem no nível técnico', NULL, 1, NULL, NULL, NULL, NULL),
(17, 'Clean Technology Soluções Sustentáveis', NULL, 1, NULL, NULL, NULL, NULL),
(18, 'Ramo Estudantil IEEE UFRJ', NULL, 1, NULL, NULL, NULL, NULL),
(19, 'Gestão de Projetos com o MS-PROJECT', NULL, 2, NULL, NULL, NULL, NULL),
(20, 'Mostra Audiovisual 2017 - Tecnologia e Relações de Sociabilidade Contemporâneas [Sessão 1]', NULL, 3, NULL, NULL, NULL, NULL),
(21, 'O que é Matemática?', NULL, 1, NULL, NULL, NULL, NULL),
(22, 'Shell Script: descobrindo o poder da linha de comando', NULL, 2, NULL, NULL, NULL, NULL),
(23, 'Padrões de Análise: reuso de modelos no desenvolvimento de software orientado a objetos', NULL, 1, NULL, NULL, NULL, NULL),
(24, 'Operações topológicas: uma maneira de explorar curvas e superfícies no ensino básico', NULL, 5, NULL, NULL, NULL, NULL),
(25, 'Robótica Educacional', NULL, 5, NULL, NULL, NULL, NULL),
(26, 'Acessibilidade Autônoma no CEFET-RJ Campus Nova Friburgo', NULL, 5, NULL, NULL, NULL, NULL),
(27, 'Ponto de carregamento solar no CEFET-RJ Campus Nova Friburgo', NULL, 5, NULL, NULL, NULL, NULL),
(28, 'Portal dos Estagiários: Sistema de gestão do estágio interno no CEFET-RJ/NF', NULL, 6, NULL, NULL, NULL, NULL),
(29, 'Macrophage: um jogo sério para o ensino de imunologia', NULL, 6, NULL, NULL, NULL, NULL),
(30, 'DESENVOLVIMENTO DE ANIMAÇÃO PARA O ENSINO SOBRE TEORIAS EVOLUTIVAS', NULL, 6, NULL, NULL, NULL, NULL),
(31, 'TEORIAS EVOLUTIVAS: O FILME', NULL, 6, NULL, NULL, NULL, NULL),
(32, 'DESENVOLVIMENTO DE FILME CURTA-METRAGEM SOBRE DST`S E MÉTODOS CONTRACEPTIVOS', NULL, 6, NULL, NULL, NULL, NULL),
(33, 'Áreas Classificadas e Atmosferas Explosivas', NULL, 1, NULL, NULL, NULL, NULL),
(34, 'Montagem e configuração aplicado na pesquisa de veículos autônomos', NULL, 2, NULL, NULL, NULL, NULL),
(35, 'Transformar para-brisa obsoleto em material cerâmico', NULL, 1, NULL, NULL, NULL, NULL),
(36, 'Ferramentas de Qualidade: Aplicação prática para melhorias de gestão', NULL, 2, NULL, NULL, NULL, NULL),
(37, 'Mostra Audiovisual 2017 - Tecnologia e Relações de Sociabilidade Contemporâneas [Sessão 2]', NULL, 3, NULL, NULL, NULL, NULL),
(38, 'HUET', NULL, 1, NULL, NULL, NULL, NULL),
(39, 'Tipos de Plataformas para Exploração de Petróleo', NULL, 1, NULL, NULL, NULL, NULL),
(40, 'A importância de uma instituição financeira cooperativa para o desenvolvimento local e regional', NULL, 1, NULL, NULL, NULL, NULL),
(41, 'Montagem e configuração de um quadricóptero aplicado na pesquisa de veículos autônomos', NULL, 2, NULL, NULL, NULL, NULL),
(42, 'Ferramentas de Qualidade: Aplicação prática para melhorias de gestão', NULL, 4, NULL, NULL, NULL, NULL),
(43, 'INVESTINDO OS RECURSOS POUPADOS PARA REALIZAÇÃO DOS PROJETOS DE VIDA', NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_horarioEvento`
--

CREATE TABLE `tb_horarioEvento` (
  `id` int(11) NOT NULL,
  `data_inicio` datetime NOT NULL,
  `data_termino` datetime NOT NULL,
  `evento_id` int(11) NOT NULL,
  `sala` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_horarioEvento`
--

INSERT INTO `tb_horarioEvento` (`id`, `data_inicio`, `data_termino`, `evento_id`, `sala`) VALUES
(1, '2017-10-16 09:00:00', '2017-10-16 10:00:00', 1, NULL),
(2, '2017-10-16 10:30:00', '2017-10-16 11:30:00', 2, NULL),
(3, '2017-10-16 13:00:00', '2017-10-16 17:00:00', 3, NULL),
(4, '2017-10-16 13:00:00', '2017-10-16 17:00:00', 4, NULL),
(5, '2017-10-16 13:00:00', '2017-10-16 17:00:00', 5, NULL),
(6, '2017-10-16 14:00:00', '2017-10-16 16:00:00', 6, NULL),
(7, '2017-10-16 16:00:00', '2017-10-16 17:00:00', 7, NULL),
(8, '2017-10-16 18:00:00', '2017-10-16 22:00:00', 8, NULL),
(9, '2017-10-16 18:00:00', '2017-10-16 22:00:00', 9, NULL),
(10, '2017-10-16 18:00:00', '2017-10-16 21:00:00', 10, NULL),
(11, '2017-10-16 19:00:00', '2017-10-16 20:00:00', 11, NULL),
(12, '2017-10-16 20:00:00', '2017-10-16 21:00:00', 12, NULL),
(13, '2017-10-16 21:00:00', '2017-10-16 21:30:00', 13, NULL),
(14, '2017-10-17 08:00:00', '2017-10-17 12:00:00', 14, NULL),
(15, '2017-10-17 09:00:00', '2017-10-17 11:00:00', 15, NULL),
(16, '2017-10-17 09:00:00', '2017-10-17 10:00:00', 16, NULL),
(17, '2017-10-17 10:30:00', '2017-10-17 11:30:00', 17, NULL),
(18, '2017-10-17 13:00:00', '2017-10-17 14:00:00', 18, NULL),
(19, '2017-10-17 13:00:00', '2017-10-17 17:00:00', 8, NULL),
(20, '2017-10-17 13:00:00', '2017-10-17 17:00:00', 19, NULL),
(21, '2017-10-17 13:00:00', '2017-10-17 17:00:00', 5, NULL),
(22, '2017-10-17 14:00:00', '2017-10-17 16:00:00', 20, NULL),
(23, '2017-10-17 16:00:00', '2017-10-17 17:00:00', 21, NULL),
(24, '2017-10-17 18:00:00', '2017-10-17 22:00:00', 19, NULL),
(25, '2017-10-17 18:00:00', '2017-10-17 22:00:00', 22, NULL),
(26, '2017-10-17 19:00:00', '2017-10-17 20:00:00', 23, NULL),
(27, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 24, NULL),
(28, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 25, NULL),
(29, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 26, NULL),
(30, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 27, NULL),
(31, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 28, NULL),
(32, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 29, NULL),
(33, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 30, NULL),
(34, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 31, NULL),
(35, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 32, NULL),
(36, '2017-10-18 13:00:00', '2017-10-18 14:00:00', 33, NULL),
(37, '2017-10-18 13:00:00', '2017-10-18 17:00:00', 34, NULL),
(38, '2017-10-18 14:00:00', '2017-10-18 15:00:00', 35, NULL),
(39, '2017-10-18 14:00:00', '2017-10-18 17:00:00', 36, NULL),
(40, '2017-10-18 14:00:00', '2017-10-18 16:00:00', 37, NULL),
(41, '2017-10-18 15:00:00', '2017-10-18 16:00:00', 38, NULL),
(42, '2017-10-18 16:00:00', '2017-10-18 17:00:00', 39, NULL),
(43, '2017-10-18 18:00:00', '2017-10-18 20:00:00', 40, NULL),
(44, '2017-10-18 18:00:00', '2017-10-18 22:00:00', 41, NULL),
(45, '2017-10-18 18:00:00', '2017-10-18 21:00:00', 42, NULL),
(46, '2017-10-18 19:00:00', '2017-10-18 21:00:00', 43, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_inscricao`
--

CREATE TABLE `tb_inscricao` (
  `usuario_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tipoEvento`
--

CREATE TABLE `tb_tipoEvento` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_tipoEvento`
--

INSERT INTO `tb_tipoEvento` (`id`, `nome`) VALUES
(1, 'Palestras'),
(2, 'Minicursos'),
(3, 'Mesa Redondas'),
(4, 'Outra atividades'),
(5, 'EXPOSUP'),
(6, 'EXPOTEC');

-- --------------------------------------------------------

--
-- Table structure for table `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `email` varchar(300) NOT NULL,
  `senha` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_usuario`
--

INSERT INTO `tb_usuario` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Rafael Escalfoni', 'rafaelescalfoni@gmail.com', 'a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_evento`
--
ALTER TABLE `tb_evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_evento_tipo_evento_idx` (`tipo_evento_id`);

--
-- Indexes for table `tb_horarioEvento`
--
ALTER TABLE `tb_horarioEvento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_evento_horario_evento1_idx` (`evento_id`);

--
-- Indexes for table `tb_inscricao`
--
ALTER TABLE `tb_inscricao`
  ADD PRIMARY KEY (`usuario_id`,`evento_id`),
  ADD KEY `fk_participante_has_evento_evento1_idx` (`evento_id`),
  ADD KEY `fk_participante_has_evento_participante1_idx` (`usuario_id`);

--
-- Indexes for table `tb_tipoEvento`
--
ALTER TABLE `tb_tipoEvento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_evento`
--
ALTER TABLE `tb_evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `tb_tipoEvento`
--
ALTER TABLE `tb_tipoEvento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_evento`
--
ALTER TABLE `tb_evento`
  ADD CONSTRAINT `fk_evento_tipo_evento` FOREIGN KEY (`tipo_evento_id`) REFERENCES `tb_tipoEvento` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `tb_horarioEvento`
--
ALTER TABLE `tb_horarioEvento`
  ADD CONSTRAINT `fk_evento_horario_evento1` FOREIGN KEY (`evento_id`) REFERENCES `tb_evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_inscricao`
--
ALTER TABLE `tb_inscricao`
  ADD CONSTRAINT `fk_participante_has_evento_evento1` FOREIGN KEY (`evento_id`) REFERENCES `tb_evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_participante_has_evento_participante1` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
