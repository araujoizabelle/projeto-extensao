-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 12, 2017 at 08:54 PM
-- Server version: 5.6.35
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bd_evento`
--

-- --------------------------------------------------------

--
-- Table structure for table `autor_tem_evento`
--

CREATE TABLE `autor_tem_evento` (
  `tb_autor_id` int(11) NOT NULL,
  `tb_evento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_autor`
--

CREATE TABLE `tb_autor` (
  `id` int(11) NOT NULL,
  `nome` varchar(300) NOT NULL,
  `foto` varchar(400) DEFAULT NULL,
  `bio` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_evento`
--

CREATE TABLE `tb_evento` (
  `id` int(11) NOT NULL,
  `nome` varchar(180) NOT NULL,
  `data_inscricao` datetime DEFAULT NULL,
  `tipo_evento_id` int(11) NOT NULL,
  `descricao` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_evento`
--

INSERT INTO `tb_evento` (`id`, `nome`, `data_inscricao`, `tipo_evento_id`, `descricao`) VALUES
(1, 'Empreendendo com Química e Arte', NULL, 1, NULL),
(2, 'Considerações sobre a carreira de Engenheira Eletrônica', NULL, 1, NULL),
(3, 'Introdução à GNU/Linux', NULL, 2, NULL),
(4, 'Modelagem de Processos de Negócio Utilizando o Bizagi', NULL, 2, NULL),
(5, 'Oratória: Comunicação e Técnicas de Apresentação de Trabalhos Acadêmicos', NULL, 2, NULL),
(6, 'Oficina de reciclagem de papel', NULL, 4, NULL),
(7, 'Qualidade de Energia Elétrica em Sistemas de Distribuição', NULL, 1, NULL),
(8, 'CURSO BÁSICO DE ARDUÍNO', NULL, 2, NULL),
(9, 'Modelagem de Processos de Negócio Utilizando o Bizagi', NULL, 2, NULL),
(10, 'Cinema e sociedade em diálogo: a matemática em nossas vidas', NULL, 4, NULL),
(11, 'Intercâmbio Estudantil pelo CEFET/RJ campus Nova Friburgo: relatos e experiências', NULL, 1, NULL),
(12, 'O Programa de Extensão CELi (Centro de Educação e Linguagens) do CEFET/RJ Nova Friburgo:\r\n    avaliações de alunos concluintes sobre o curso de língua inglesa', NULL, 1, NULL),
(13, 'Pilotando com a Bússola Acadêmica: desenho de um protótipo funcional premilinar', NULL, 1, NULL),
(14, 'Oficina de leitura e escrita literária', NULL, 4, NULL),
(15, 'Pensando a pontuação na produção de textos', NULL, 2, NULL),
(16, 'A tecnologia da Célula Combustível a hidrogênio e a aprendizagem no nível técnico', NULL, 1, NULL),
(17, 'Clean Technology Soluções Sustentáveis', NULL, 1, NULL),
(18, 'Ramo Estudantil IEEE UFRJ', NULL, 1, NULL),
(19, 'Gestão de Projetos com o MS-PROJECT', NULL, 2, NULL),
(20, 'Mostra Audiovisual 2017 - Tecnologia e Relações de Sociabilidade Contemporâneas [Sessão 1]', NULL, 3, NULL),
(21, 'O que é Matemática?', NULL, 1, NULL),
(22, 'Shell Script: descobrindo o poder da linha de comando', NULL, 2, NULL),
(23, 'Padrões de Análise: reuso de modelos no desenvolvimento de software orientado a objetos', NULL, 1, NULL),
(24, 'Operações topológicas: uma maneira de explorar curvas e superfícies no ensino básico', NULL, 5, NULL),
(25, 'Robótica Educacional', NULL, 5, NULL),
(26, 'Acessibilidade Autônoma no CEFET-RJ Campus Nova Friburgo', NULL, 5, NULL),
(27, 'Ponto de carregamento solar no CEFET-RJ Campus Nova Friburgo', NULL, 5, NULL),
(28, 'Portal dos Estagiários: Sistema de gestão do estágio interno no CEFET-RJ/NF', NULL, 6, NULL),
(29, 'Macrophage: um jogo sério para o ensino de imunologia', NULL, 6, NULL),
(30, 'DESENVOLVIMENTO DE ANIMAÇÃO PARA O ENSINO SOBRE TEORIAS EVOLUTIVAS', NULL, 6, NULL),
(31, 'TEORIAS EVOLUTIVAS: O FILME', NULL, 6, NULL),
(32, 'DESENVOLVIMENTO DE FILME CURTA-METRAGEM SOBRE DST`S E MÉTODOS CONTRACEPTIVOS', NULL, 6, NULL),
(33, 'Áreas Classificadas e Atmosferas Explosivas', NULL, 1, NULL),
(34, 'Montagem e configuração aplicado na pesquisa de veículos autônomos', NULL, 2, NULL),
(35, 'Transformar para-brisa obsoleto em material cerâmico', NULL, 1, NULL),
(36, 'Ferramentas de Qualidade: Aplicação prática para melhorias de gestão', NULL, 2, NULL),
(37, 'Mostra Audiovisual 2017 - Tecnologia e Relações de Sociabilidade Contemporâneas [Sessão 2]', NULL, 3, NULL),
(38, 'HUET', NULL, 1, NULL),
(39, 'Tipos de Plataformas para Exploração de Petróleo', NULL, 1, NULL),
(40, 'A importância de uma instituição financeira cooperativa para o desenvolvimento local e regional', NULL, 1, NULL),
(41, 'Montagem e configuração de um quadricóptero aplicado na pesquisa de veículos autônomos', NULL, 2, NULL),
(42, 'Ferramentas de Qualidade: Aplicação prática para melhorias de gestão', NULL, 4, NULL),
(43, 'INVESTINDO OS RECURSOS POUPADOS PARA REALIZAÇÃO DOS PROJETOS DE VIDA', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_horarioEvento`
--

CREATE TABLE `tb_horarioEvento` (
  `id` int(11) NOT NULL,
  `data_inicio` datetime NOT NULL,
  `data_termino` datetime NOT NULL,
  `evento_id` int(11) NOT NULL,
  `sala_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_horarioEvento`
--

INSERT INTO `tb_horarioEvento` (`id`, `data_inicio`, `data_termino`, `evento_id`, `sala_id`) VALUES
(1, '2017-10-16 09:00:00', '2017-10-16 10:00:00', 1, 6),
(2, '2017-10-16 10:30:00', '2017-10-16 11:30:00', 2, 1),
(3, '2017-10-16 13:00:00', '2017-10-16 17:00:00', 3, 1),
(4, '2017-10-16 13:00:00', '2017-10-16 17:00:00', 4, 1),
(5, '2017-10-16 13:00:00', '2017-10-16 17:00:00', 5, 1),
(6, '2017-10-16 14:00:00', '2017-10-16 16:00:00', 6, 1),
(7, '2017-10-16 16:00:00', '2017-10-16 17:00:00', 7, 1),
(8, '2017-10-16 18:00:00', '2017-10-16 22:00:00', 8, 1),
(9, '2017-10-16 18:00:00', '2017-10-16 22:00:00', 9, 1),
(10, '2017-10-16 18:00:00', '2017-10-16 21:00:00', 10, 1),
(11, '2017-10-16 19:00:00', '2017-10-16 20:00:00', 11, 1),
(12, '2017-10-16 20:00:00', '2017-10-16 21:00:00', 12, 1),
(13, '2017-10-16 21:00:00', '2017-10-16 21:30:00', 13, 1),
(14, '2017-10-17 08:00:00', '2017-10-17 12:00:00', 14, 1),
(15, '2017-10-17 09:00:00', '2017-10-17 11:00:00', 15, 1),
(16, '2017-10-17 09:00:00', '2017-10-17 10:00:00', 16, 1),
(17, '2017-10-17 10:30:00', '2017-10-17 11:30:00', 17, 1),
(18, '2017-10-17 13:00:00', '2017-10-17 14:00:00', 18, 1),
(19, '2017-10-17 13:00:00', '2017-10-17 17:00:00', 8, 1),
(20, '2017-10-17 13:00:00', '2017-10-17 17:00:00', 19, 1),
(21, '2017-10-17 13:00:00', '2017-10-17 17:00:00', 5, 1),
(22, '2017-10-17 14:00:00', '2017-10-17 16:00:00', 20, 1),
(23, '2017-10-17 16:00:00', '2017-10-17 17:00:00', 21, 1),
(24, '2017-10-17 18:00:00', '2017-10-17 22:00:00', 19, 1),
(25, '2017-10-17 18:00:00', '2017-10-17 22:00:00', 22, 1),
(26, '2017-10-17 19:00:00', '2017-10-17 20:00:00', 23, 1),
(27, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 24, 1),
(28, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 25, 1),
(29, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 26, 1),
(30, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 27, 1),
(31, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 28, 1),
(32, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 29, 1),
(33, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 30, 1),
(34, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 31, 1),
(35, '2017-10-18 08:00:00', '2017-10-18 12:00:00', 32, 1),
(36, '2017-10-18 13:00:00', '2017-10-18 14:00:00', 33, 1),
(37, '2017-10-18 13:00:00', '2017-10-18 17:00:00', 34, 1),
(38, '2017-10-18 14:00:00', '2017-10-18 15:00:00', 35, 1),
(39, '2017-10-18 14:00:00', '2017-10-18 17:00:00', 36, 1),
(40, '2017-10-18 14:00:00', '2017-10-18 16:00:00', 37, 1),
(41, '2017-10-18 15:00:00', '2017-10-18 16:00:00', 38, 1),
(42, '2017-10-18 16:00:00', '2017-10-18 17:00:00', 39, 1),
(43, '2017-10-18 18:00:00', '2017-10-18 20:00:00', 40, 1),
(44, '2017-10-18 18:00:00', '2017-10-18 22:00:00', 41, 1),
(45, '2017-10-18 18:00:00', '2017-10-18 21:00:00', 42, 1),
(46, '2017-10-18 19:00:00', '2017-10-18 21:00:00', 43, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_inscricao`
--

CREATE TABLE `tb_inscricao` (
  `usuario_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_inscricao`
--

INSERT INTO `tb_inscricao` (`usuario_id`, `evento_id`) VALUES
(1, 2),
(1, 3),
(1, 6),
(1, 7),
(1, 8),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 24),
(1, 33),
(1, 40);

-- --------------------------------------------------------

--
-- Table structure for table `tb_sala`
--

CREATE TABLE `tb_sala` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tb_sala`
--

INSERT INTO `tb_sala` (`id`, `nome`) VALUES
(1, 'Lab Info 1'),
(2, 'Lab Info 2'),
(3, 'Lab Info 3'),
(4, 'Lab Info 4'),
(5, 'Lab Info 5'),
(6, 'Sala 14'),
(7, 'Sala 20'),
(8, 'Sala 1B');

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
(1, 'Rafael Escalfoni', 'rafaelescalfoni@gmail.com', 'a'),
(2, 'a', 'a@a', 'a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autor_tem_evento`
--
ALTER TABLE `autor_tem_evento`
  ADD PRIMARY KEY (`tb_autor_id`,`tb_evento_id`),
  ADD KEY `fk_tb_autor_has_tb_evento_tb_evento1_idx` (`tb_evento_id`),
  ADD KEY `fk_tb_autor_has_tb_evento_tb_autor1_idx` (`tb_autor_id`);

--
-- Indexes for table `tb_autor`
--
ALTER TABLE `tb_autor`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `fk_evento_horario_evento1_idx` (`evento_id`),
  ADD KEY `fk_sala` (`sala_id`);

--
-- Indexes for table `tb_inscricao`
--
ALTER TABLE `tb_inscricao`
  ADD PRIMARY KEY (`usuario_id`,`evento_id`),
  ADD KEY `fk_participante_has_evento_evento1_idx` (`evento_id`),
  ADD KEY `fk_participante_has_evento_participante1_idx` (`usuario_id`);

--
-- Indexes for table `tb_sala`
--
ALTER TABLE `tb_sala`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `tb_autor`
--
ALTER TABLE `tb_autor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tb_evento`
--
ALTER TABLE `tb_evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `tb_sala`
--
ALTER TABLE `tb_sala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tb_tipoEvento`
--
ALTER TABLE `tb_tipoEvento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `autor_tem_evento`
--
ALTER TABLE `autor_tem_evento`
  ADD CONSTRAINT `fk_tb_autor_has_tb_evento_tb_autor1` FOREIGN KEY (`tb_autor_id`) REFERENCES `tb_autor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_autor_has_tb_evento_tb_evento1` FOREIGN KEY (`tb_evento_id`) REFERENCES `tb_evento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_evento`
--
ALTER TABLE `tb_evento`
  ADD CONSTRAINT `fk_evento_tipo_evento` FOREIGN KEY (`tipo_evento_id`) REFERENCES `tb_tipoEvento` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `tb_horarioEvento`
--
ALTER TABLE `tb_horarioEvento`
  ADD CONSTRAINT `fk_evento_horario_evento1` FOREIGN KEY (`evento_id`) REFERENCES `tb_evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sala` FOREIGN KEY (`sala_id`) REFERENCES `tb_sala` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_inscricao`
--
ALTER TABLE `tb_inscricao`
  ADD CONSTRAINT `fk_participante_has_evento_evento1` FOREIGN KEY (`evento_id`) REFERENCES `tb_evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_participante_has_evento_participante1` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
