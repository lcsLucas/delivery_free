-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 10-Maio-2019 às 17:13
-- Versão do servidor: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ban_delivery`
--

--
-- Extraindo dados da tabela `acesso`
--

INSERT INTO `acesso` (`idacesso`, `ip`, `data_hora`) VALUES
(1, '::1', '2019-04-22 12:06:41'),
(2, '::1', '2019-05-07 08:15:21');

--
-- Extraindo dados da tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`idavaliacoes`, `idsaida`, `cli_id`, `data_criacao`, `classificacao`, `obs`, `data_resposta`, `resposta`, `idusuarios`) VALUES
(26, 10, 1, '2019-05-06 08:39:49', 5, 'Ótima comida e entrega rápida', '2019-05-07 13:54:51', 'obrigado pela avaliação!!!', 40),
(27, 9, 1, '2019-05-06 08:40:05', 4, 'Ótima comida', '2019-05-07 14:05:48', 'Obrigado pela avaliação', 40),
(28, 8, 1, '2019-05-06 08:40:16', 3, 'Entrega atrasada', '2019-05-07 14:06:34', 'Desculpe pelo incoveniente', 40),
(29, 12, 1, '2019-05-07 09:44:31', 4, 'ótima comida', '2019-05-07 14:07:31', 'obrigado!!!', 40),
(30, 11, 1, '2019-05-07 09:44:48', 3, 'entrega atrasada', '2019-05-07 14:07:47', 'Desculpa pela demora', 40),
(31, 7, 1, '2019-05-08 08:11:19', 5, 'ótima comida', '2019-05-08 08:58:50', 'obrigado!!!', 43),
(32, 6, 1, '2019-05-08 08:11:33', 5, 'comida muito boa e entrega na hora', NULL, NULL, NULL),
(33, 13, 10, '2019-05-08 08:59:10', 5, 'Ótima comida!!!', '2019-05-08 08:59:20', 'Obrigado!!!', 43);

--
-- Extraindo dados da tabela `baixa_uso`
--

INSERT INTO `baixa_uso` (`bai_id`, `bai_dtCad`, `bai_qtde`, `mot_id`, `ins_id`, `emp_id`) VALUES
(9, '2018-09-04', '66.25', 2, 1, 30),
(10, '2018-09-04', '10.00', 3, 1, 30);

--
-- Extraindo dados da tabela `carrinho`
--

INSERT INTO `carrinho` (`idcarrinho`, `data_criacao`, `sessao`, `emp_id`, `promocao_id`) VALUES
(1, '2019-04-22 12:23:13', '$2y$10$2KfmpHvZccbRSJDbFS84OOWC1Hix7Hu1yQ8U57wk/6MgeMEKhKCpu', 30, 6),
(2, '2019-04-22 12:27:01', '$2y$10$KetC22XMxFj/5rpN4bBry.armBcABSpauixzYoGwNwvA2yS3fb6CC', 33, NULL),
(3, '2019-04-22 18:00:23', '$2y$10$3gA/Sa7kJEufQ0Gj9Gz1Tu.Zydat3xPk8xchSx2Cs6WOsjk9C4QXa', 30, 6),
(4, '2019-04-23 12:43:29', '$2y$10$sr.XqHwECBCMQUZxcN5ZlO8D2JldKqG5EfabRpR0iP63.GU2/gCxC', 30, NULL),
(5, '2019-04-25 07:46:22', '$2y$10$FQPWKSxgfWFwVRupR6QwIOVv8WxVUI1CacxN2gg.nRplvUNhPbcJq', 30, NULL),
(6, '2019-04-25 07:47:30', '$2y$10$WG8Y7CgoxerdP4bvENIb3.F.M4hJ7Sv9eUjCuQ7ga6l7JpZuECk5a', 30, NULL),
(7, '2019-04-26 08:11:29', '$2y$10$7JVvTMQrhfEf2N.cr4gvZOrhRdXs3nBXS0taNOY7ypLirQ.26Q9r2', 30, 6),
(8, '2019-04-26 13:18:32', '$2y$10$ISUhbGcOIhBkgaFPnacBdOAQZqW5eaSC5AWe6zwS.DnYEG85Jhb5C', 33, NULL),
(9, '2019-04-26 13:18:47', '$2y$10$jy.6kKwrOqd588ueM8SmleOjYdakeyRxYwEocttiV.TLrupBOzRgS', 30, NULL),
(10, '2019-04-29 08:06:27', '$2y$10$hcXxHNfco17.hL.pCtg4zO71LT57dQ8Ly9OtbTZdtoRPuzu5vA6hO', 30, 6),
(11, '2019-04-29 14:27:08', '$2y$10$qH.TTaRIj5491.oqC/DmmOG.VG1WmFV047KnhrmM7bpMJK8BMsGdu', 30, NULL),
(12, '2019-05-07 08:30:00', '$2y$10$S5U9d870tEPEmJDMZrPK1eSIZ6ACNgiJJwUuzJ8ed7PQxxqGOd/Ly', 30, NULL),
(13, '2019-05-07 09:32:37', '$2y$10$3MinwILWW8xf5WzPx/DsY.1Ys3qozdLKz8SRn0UFXks1dk1PSHSeu', 30, 6),
(14, '2019-05-08 08:48:14', '$2y$10$xjzp4LrzUjxRsIUwLnkxSOAI2Eoi3DZVZytO9eeBeLwOgrgeIAVIi', 33, NULL),
(15, '2019-05-08 08:54:14', '$2y$10$pCFmzcj27TToUNIQyboWRO833EewL2GZDSISyJ9QQ4ePu7A6.XCVe', 33, 7);

--
-- Extraindo dados da tabela `carrinho_tem_produto`
--

INSERT INTO `carrinho_tem_produto` (`idcarrinho_produto`, `idcarrinho`, `pro_id`, `qtde`, `obs`) VALUES
(1, 1, 6, 1, ''),
(2, 1, 18, 1, ''),
(3, 1, 2, 1, ''),
(4, 2, 44, 3, ''),
(5, 2, 49, 1, ''),
(6, 3, 6, 1, ''),
(7, 3, 8, 1, 'cortado ao meio'),
(8, 3, 17, 1, ''),
(9, 4, 6, 1, 'cortado ao meio'),
(10, 4, 31, 1, 'sem açucar'),
(11, 5, 3, 1, ''),
(12, 6, 13, 1, ''),
(13, 6, 23, 6, ''),
(14, 6, 14, 1, ''),
(15, 7, 6, 1, 'cortado ao meio'),
(16, 7, 6, 1, ''),
(17, 7, 22, 1, ''),
(18, 8, 44, 1, ''),
(19, 9, 14, 2, ''),
(20, 10, 8, 2, ''),
(21, 10, 6, 1, ''),
(22, 10, 8, 1, ''),
(23, 11, 27, 3, ''),
(24, 12, 3, 1, ''),
(25, 12, 6, 2, ''),
(26, 12, 6, 1, ''),
(27, 13, 3, 5, ''),
(28, 13, 23, 3, ''),
(29, 13, 6, 1, 'cortado ao meio'),
(30, 13, 4, 1, ''),
(31, 14, 44, 1, ''),
(32, 14, 51, 1, ''),
(33, 15, 45, 2, ''),
(34, 15, 41, 1, '');

--
-- Extraindo dados da tabela `categoria_complementos`
--

INSERT INTO `categoria_complementos` (`catcom_id`, `catcom_nome`, `catcom_obrigatorio`, `catcom_qtdemin`, `catcom_qtdemax`, `emp_id`, `pro_id`, `cat_pro_id`) VALUES
(11, 'Escolha o sabor do refrigerante:', '1', 1, 1, 30, 4, NULL),
(29, 'Escolha porção adicional', '0', 0, 4, 30, NULL, 3);

--
-- Extraindo dados da tabela `categoria_cozinha`
--

INSERT INTO `categoria_cozinha` (`cat_id`, `cat_nome`, `cat_resumo`, `cat_descricao`, `cat_img`, `cat_status`) VALUES
(10, 'Comida Japonesa', 'Comida Japonesa', '&lt;p&gt;Comida Japonesa&lt;/p&gt;', '10_20190207080008.jpg', '1'),
(11, 'Cozinha Italiana', 'Cozinha Italiana', '&lt;p&gt;Cozinha Italiana&lt;/p&gt;', '11_20190207080028.jpg', '1'),
(12, 'Lanches', 'Lanches', '&lt;p&gt;Lanches&lt;/p&gt;', '12_20190213123420.jpg', '1'),
(13, 'Pizzas', 'Pizzas', '&lt;p&gt;Pizzas&lt;/p&gt;', '13_20190213123439.jpg', '1'),
(14, 'Cozinha Rápida', 'Cozinha Rápida', '&lt;p&gt;Cozinha R&amp;aacute;pida&lt;/p&gt;', '14_20190213135114.jpg', '1'),
(15, 'Salgados', 'Salgados', '&lt;p&gt;Salgados&lt;/p&gt;', '15_20190213135130.jpg', '1');

--
-- Extraindo dados da tabela `categoria_insumos`
--

INSERT INTO `categoria_insumos` (`cat_id`, `cat_nome`, `cat_descricao`, `cat_ativo`, `emp_id`) VALUES
(1, 'Insumos Pizza', '', '1', 30),
(2, 'Insumos Lanches', '', '1', 30),
(3, 'Insumos Esfirras', '', '1', 30);

--
-- Extraindo dados da tabela `categoria_produtos`
--

INSERT INTO `categoria_produtos` (`cat_id`, `cat_nome`, `cat_descricao`, `cat_ativo`, `emp_id`) VALUES
(3, 'Lanches', '', '1', 30),
(4, 'Esfirras', '', '1', 30),
(5, 'Refrigerantes', '', '1', 30),
(6, 'Cervejas', '', '1', 30),
(7, 'Sucos', '', '1', 30),
(8, 'Porções', '', '1', 30),
(9, 'Pastéis Salgados', '', '1', 33),
(10, 'Pastéis Doces', '', '1', 33),
(11, 'Porções', '', '1', 33),
(12, 'Terça Loka', '', '1', 33);

--
-- Extraindo dados da tabela `categoria_tem_complementos`
--

INSERT INTO `categoria_tem_complementos` (`cat_com_id`, `nome`, `descricao`, `preco`, `cat_id`, `catcom_id`) VALUES
(48, 'Cebola', '', '0.50', 3, 29),
(49, 'Bacon', '', '4.00', 3, 29),
(50, 'Batata Palha', '', '1.00', 3, 29),
(51, 'Calabresa', '', '4.00', 3, 29),
(52, 'Frango', '', '4.00', 3, 29),
(53, 'Cheddar', '', '2.50', 3, 29),
(54, 'Salsicha', '', '1.50', 3, 29),
(55, 'Queijo Mussarela', '', '1.50', 3, 29),
(56, 'Presunto', '', '1.50', 3, 29),
(57, 'Filé de Frango', '', '4.00', 3, 29),
(58, 'Hamburgue', '', '3.00', 3, 29),
(59, 'Catupiry', '', '2.50', 3, 29),
(60, 'Ovo', '', '1.00', 3, 29),
(61, 'Peito de Peru', '', '4.00', 3, 29);

--
-- Extraindo dados da tabela `categoria_tem_empresa`
--

INSERT INTO `categoria_tem_empresa` (`cat_id`, `emp_id`, `ordem`) VALUES
(12, 30, 1),
(13, 30, 2),
(13, 31, 1),
(14, 32, 1),
(14, 33, 1);

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`cid_id`, `cid_nome`, `est_sigla`) VALUES
(1, 'Presidente Prudente', 'sp'),
(2, 'Álvares Machado', 'sp');

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`cli_id`, `cli_dtCad`, `cli_nome`, `cli_email`, `cli_celular`, `cli_ativo`, `cli_telefone`, `cli_celular2`, `cli_obs`, `cli_usuario`, `cli_senha`, `cli_nascimento`, `emp_id`, `flag_delivery`, `end_id`) VALUES
(1, '2018-10-25', 'Lucas S. Rosa', 'lucas.tarta@hotmail.com', '(18) 99627-2553', '1', NULL, '(18) 99739-3744', NULL, 'lucas', '$2y$10$gUZFQvsS0LJnD2gfNCd6XefBcfucenmS47El.5lyM4hQHBNkGX5EK', '2015-12-01', NULL, '1', NULL),
(2, '2018-11-06', 'Lucas S. Rosa', 'lucas.tafrta@hotmail.com', '(18) 99999-9999', '1', NULL, '(18) 99999-9999', NULL, 'lcslucas', '$2y$10$ewykJgA95LbyEcuL/GqC.e8w6ehcdCjh5ODpJhAEasM4/oJ7wzS6u', '1995-02-05', NULL, '1', NULL),
(3, '2019-04-01', 'Teste', 'teste@teste.com', '(18) 99999-9999', '1', NULL, '', NULL, 'teste', '$2y$10$TpDV55oU2yP1yZbl5M7h3OxoF/d5HQOJEJibvqYgizvG1h.mDD8r2', NULL, NULL, '1', NULL),
(4, '2019-04-02', 'Básico', 'teste2@teste.com', '(99) 99999-9999', '1', NULL, '', NULL, 'teste2', '$2y$10$3dvT7VtgBRYSJtbYHXD79.Iuzv3Y4z.UOI13yvNVR3qKQYqZwFGqa', NULL, NULL, '1', NULL),
(5, '2019-04-02', 'Administrador', 'admin@admin.com', '(23) 43242-3423', '1', NULL, '', NULL, 'admin', '$2y$10$ymc1YlHGy.N5rs2UPxICeOnkuwbqltfHdiCcnBtbgbB/FfQqjEbam', NULL, NULL, '1', NULL),
(6, '2019-04-02', 'asdf', 'asdf@zfdf.asdf', '(23) 43242-3432', '1', NULL, '', NULL, 'adminsdf', '$2y$10$9075puldQnf61Uw9.zkjIuemlCVoCb210gwATBgQzUNlFXQsOJHLa', NULL, NULL, '1', NULL),
(7, '2019-04-21', 'cliente', 'cliente@cliente.com', '(18) 99627-2553', '1', NULL, '', NULL, 'cliente', '$2y$10$s.sobXcRsRENp83ucV.HhOIeeRjnvtwE.Ace4B.Mr3g3/QR2xW6O6', NULL, NULL, '1', NULL),
(8, '2019-04-21', 'aaa', 'aaa@aaa.com', '(54) 64644-6546', '1', NULL, '', NULL, 'aaa', '$2y$10$lbiNI2WkIq7fI5tVJrPIAuMtSFqacD4LbaZElDQiYsqbAy0lJUcfK', NULL, NULL, '1', NULL),
(9, '2019-05-08', 'Tarta', 'tarta@email.com', '(18) 99999-9999', '1', NULL, '', NULL, 'tarta', '$2y$10$3pd7u.sdauo7Tv3uBmMUnOWk4EiOdTQXQlOiLClGyCBE6iM.ebFva', NULL, NULL, '1', NULL),
(10, '2019-05-08', 'Tarta2', 'tarta2@email.com', '(18) 99999-9999', '1', NULL, '', NULL, 'tarta2', '$2y$10$L/iK1nqxoPDJTdFtMrZBz.eU/dalbxEEIu3W7kePE8gDqPa3z37k.', NULL, NULL, '1', NULL),
(12, '2019-05-09', 'fgsdfgsdfg', 'teste@sfgsdf.sdf', '(65) 65656-5656', '1', '', '', '', NULL, NULL, NULL, 30, NULL, 40);

--
-- Extraindo dados da tabela `cliente_tem_endereco`
--

INSERT INTO `cliente_tem_endereco` (`cli_id`, `end_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 5),
(2, 6),
(2, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 17),
(3, 18),
(3, 19),
(7, 20),
(7, 21),
(7, 22),
(7, 23),
(7, 24),
(7, 25),
(7, 26),
(7, 27),
(1, 28),
(1, 30),
(1, 31),
(10, 32);

--
-- Extraindo dados da tabela `complementos_itens_carrinho`
--

INSERT INTO `complementos_itens_carrinho` (`idcom_itens_car`, `catcom_id`, `tipo`, `qtde`, `pro_com_id`, `cat_com_id`, `idcarrinho_produto`, `idcarrinho`, `pro_id`) VALUES
(1, 29, '1', 1, NULL, 57, 1, 1, 6),
(2, 29, '1', 1, NULL, 59, 1, 1, 6),
(3, 29, '1', 1, NULL, 53, 6, 3, 6),
(4, 29, '1', 1, NULL, 57, 6, 3, 6),
(5, 29, '1', 1, NULL, 59, 6, 3, 6),
(6, 29, '1', 1, NULL, 60, 6, 3, 6),
(7, 29, '1', 1, NULL, 50, 9, 4, 6),
(8, 29, '1', 1, NULL, 59, 15, 7, 6),
(9, 29, '1', 1, NULL, 61, 15, 7, 6),
(10, 29, '1', 1, NULL, 57, 20, 10, 8),
(11, 29, '1', 1, NULL, 59, 20, 10, 8),
(12, 29, '1', 1, NULL, 60, 20, 10, 8),
(13, 29, '1', 1, NULL, 48, 25, 12, 6),
(14, 29, '1', 1, NULL, 49, 25, 12, 6),
(15, 29, '1', 1, NULL, 51, 25, 12, 6),
(16, 29, '1', 1, NULL, 49, 29, 13, 6),
(17, 29, '1', 1, NULL, 57, 29, 13, 6),
(18, 29, '1', 1, NULL, 59, 29, 13, 6),
(19, 29, '1', 1, NULL, 61, 29, 13, 6),
(20, 11, '1', 1, 52, NULL, 30, 13, 4);

--
-- Extraindo dados da tabela `complementos_itens_saida`
--

INSERT INTO `complementos_itens_saida` (`idcom_itens_saida`, `id_prod_saida`, `idsaida`, `nome`, `preco`) VALUES
(1, 1, 1, 'Filé de Frango', '4.00'),
(2, 1, 1, 'Catupiry', '2.50'),
(3, 6, 3, 'Cheddar', '2.50'),
(4, 6, 3, 'Filé de Frango', '4.00'),
(5, 6, 3, 'Catupiry', '2.50'),
(6, 6, 3, 'Ovo', '1.00'),
(7, 13, 6, 'Catupiry', '2.50'),
(8, 13, 6, 'Peito de Peru', '4.00'),
(9, 18, 9, 'Filé de Frango', '4.00'),
(10, 18, 9, 'Catupiry', '2.50'),
(11, 18, 9, 'Ovo', '1.00'),
(12, 23, 11, 'Cebola', '0.50'),
(13, 23, 11, 'Bacon', '4.00'),
(14, 23, 11, 'Calabresa', '4.00'),
(15, 27, 12, 'Bacon', '4.00'),
(16, 27, 12, 'Filé de Frango', '4.00'),
(17, 27, 12, 'Catupiry', '2.50'),
(18, 27, 12, 'Peito de Peru', '4.00'),
(19, 28, 12, 'Guaraná', '0.00');

--
-- Extraindo dados da tabela `contas_pagar`
--

INSERT INTO `contas_pagar` (`con_id`, `con_dtCad`, `con_numParcela`, `con_dtVencimento`, `con_dtPago`, `con_valor`, `con_valorPago`, `con_obs`, `ent_id`, `con_entrada`, `emp_id`) VALUES
(2, '2018-08-29', 1, '2018-08-29', '2018-08-31', '115.00', '100.00', NULL, 67, '1', 30),
(10, '2019-05-07', 1, '2019-06-06', NULL, '47.50', NULL, NULL, 70, '0', 30),
(11, '2019-05-07', 1, '2019-06-06', NULL, '152.00', NULL, NULL, 69, '0', 30),
(12, '2019-05-07', 2, '2019-07-06', NULL, '152.00', NULL, NULL, 69, '0', 30),
(13, '2019-05-07', 3, '2019-08-05', NULL, '152.00', NULL, NULL, 69, '0', 30),
(14, '2019-05-07', 4, '2019-09-04', NULL, '150.00', NULL, NULL, 69, '0', 30),
(15, '2019-05-07', 5, '2019-10-04', NULL, '152.00', NULL, NULL, 69, '0', 30);

--
-- Extraindo dados da tabela `contas_receber`
--

INSERT INTO `contas_receber` (`con_id`, `con_dtCad`, `con_numParcela`, `con_dtVencimento`, `con_dtPago`, `con_valor`, `con_valorPago`, `con_obs`, `con_ativo`, `idsaida`, `emp_id`) VALUES
(1, '2019-05-09', 1, '2019-06-09', '2018-05-09', '49.95', '49.95', NULL, '1', 1, 30),
(2, '2019-05-09', 1, '2019-05-09', '2019-05-09', '65.70', '65.70', NULL, '1', 3, 30),
(3, '2019-05-09', 1, '2019-06-09', '2018-05-09', '37.00', '37.00', NULL, '1', 5, 30),
(4, '2019-05-09', 1, '2019-06-09', '2019-05-09', '66.60', '66.60', NULL, '1', 6, 30),
(5, '2019-05-09', 1, '2019-05-09', '2019-05-09', '24.00', '24.00', NULL, '1', 8, 30),
(6, '2019-05-09', 1, '2019-05-09', '2019-05-09', '104.40', '104.40', NULL, '1', 9, 30),
(7, '2019-05-09', 1, '2019-05-09', '2019-05-09', '27.70', '27.70', NULL, '1', 10, 30),
(8, '2019-05-09', 1, '2019-05-09', '2019-05-09', '107.50', '107.50', NULL, '1', 11, 30);

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`emp_id`, `emp_dtCad`, `emp_nome`, `emp_razaoSocial`, `emp_cnpj`, `emp_descricao`, `emp_localizacao`, `emp_ativo`, `end_id`, `emp_tempo_entrega_1`, `emp_tempo_entrega_2`, `emp_logo`, `emp_favicon`, `emp_frete`, `emp_fone1`, `emp_fone2`) VALUES
(30, '2018-06-08', 'Habib&#39;s Presidente Prudente', 'Empresa', '12.345.678/9', 'O Habibs &eacute; a maior rede de restaurantes do mundo de comida &aacute;rabe. Del&iacute;cias como a exclusiva esfiha, kibe, beirute, pastel, pizzas, bolinho de bacalhau e sobremesas como sorvetes, pastel de bel&eacute;m, pudim e refrigerantes e sucos completam seu pedido', NULL, '1', 42, 45, 60, '30_20190213133201.png', '30_20190213124419.png', '10.00', '(18) 33333-3333', '(18) 99999-9999'),
(31, '2019-02-13', 'Bar e Restaurante Tempero Baiano', 'Tempero Baiano', '34.534.453/45', '', NULL, '1', NULL, 30, 45, '31_20190213133932.png', NULL, NULL, NULL, NULL),
(32, '2019-02-13', 'Lug&#39;s - Presidente Prudente', 'Lug&#39;s - Presidente Prudente', '11.111.111/', '', NULL, '1', NULL, 40, 70, '32_20190213135802.png', NULL, NULL, NULL, NULL),
(33, '2019-02-13', 'Pasteloko - Dr Gurgel', 'Pasteloko - Dr Gurgel', '11.111.111', '', NULL, '1', NULL, 60, 80, '33_20190213140253.png', NULL, '12.00', NULL, NULL);

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`end_id`, `end_rua`, `end_numero`, `end_cep`, `end_bairro`, `end_descricao`, `end_ativo`, `end_favorito`, `flag_principal`, `cid_id`) VALUES
(1, 'Rua Fernando Costa', 46, '19020-570', 'Vila Boa Vista', 'drtg', '0', NULL, NULL, 1),
(2, 'Rua Jacinto Poiato', 456, '19025-340', 'Parque São Matheus', 'erty', '0', NULL, NULL, 1),
(3, 'Rua Fernando Costa', 456, '19020-570', 'Vila Boa Vista', 'etfy', '0', NULL, NULL, 1),
(4, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casa', '0', NULL, NULL, 1),
(5, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casa', '0', NULL, NULL, 1),
(6, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casa', '1', NULL, NULL, 1),
(7, 'Rua Jacinto Poiato', 981, '19025-340', 'Parque São Matheus', 'trabalho', '1', '1', NULL, 1),
(8, 'Rua Jacinto Poiato', 777, '19025-340', 'Parque São Matheus', 'Casa', '0', NULL, NULL, 1),
(9, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Casa', '0', NULL, NULL, 1),
(10, 'Rua Jacinto Poiato', 13, '19025-340', 'Parque São Matheus', 'Casa 2', '0', NULL, NULL, 1),
(14, 'dfg', 345345, '34534-534', 'dfg', '', '1', NULL, NULL, 1),
(15, 'fgh', 45645, '45654-645', 'fgh', '', '1', NULL, NULL, 1),
(16, 'dfg', 345, '34534-534', 'dfg', '', '1', NULL, NULL, 1),
(17, 'Rua Fernando Costa', 111, '19020-570', 'Vila Boa Vista', 'Trabalho', '0', NULL, NULL, 1),
(18, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Casa', '1', '1', NULL, 1),
(19, 'Rua Jacinto Poiato', 281, '19025-340', 'Parque São Matheus', 'Casa antiga', '1', NULL, NULL, 1),
(20, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casa', '0', '1', NULL, 1),
(21, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casa', '0', '1', NULL, 1),
(22, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casa', '0', '1', NULL, 1),
(23, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casa', '0', '1', NULL, 1),
(24, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casa', '0', '1', NULL, 1),
(25, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'caasa', '0', '1', NULL, 1),
(26, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casas', '0', '1', NULL, 1),
(27, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casa', '1', '1', NULL, 1),
(28, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'casa', '0', NULL, NULL, 1),
(29, 'rtrt', 345, '345', '345', '', '1', NULL, NULL, 1),
(30, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Casa', '1', NULL, NULL, 1),
(31, 'Rua Jacinto Poiato', 111, '19025-340', 'Parque São Matheus', 'Trabalho', '1', '1', NULL, 1),
(32, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Casa', '1', '1', NULL, 1),
(33, 'Rua teste Forncedor', 111, '11111-111', 'Bairro Fornecedor', '', '1', NULL, NULL, 1),
(39, 'asdfasdf', 34534, '34353-453', 'sdfsdf', '', '1', NULL, NULL, 1),
(40, 'Fernando csta', 981, '19020-570', 'Vila boa vista', '', '1', NULL, NULL, 1),
(41, 'Rua teste', 111111, '99999-999', 'Teste', '', '1', NULL, NULL, 1),
(42, 'Rua teste Forncedor', 345, '43534-534', 'fsdg', '', '1', NULL, NULL, 1);

--
-- Extraindo dados da tabela `entrada`
--

INSERT INTO `entrada` (`ent_id`, `data_criacao`, `data`, `desconto`, `observacao`, `frete`, `outros_valores`, `ativo`, `pag_id`, `emp_id`, `codigo_nota`, `tipo`) VALUES
(67, '2019-05-07', '2018-08-27', '10.00', '', '30.00', '10.00', '1', 4, 30, 0, '0'),
(68, '2019-05-07', '2018-08-27', '0.00', '', '0.00', '0.00', '1', 4, 30, 0, '0'),
(69, '2019-05-07', '2018-08-31', '35.00', '', '15.00', '80.00', '1', 5, 30, 0, '1'),
(70, '2019-05-07', '2018-09-04', '0.00', '', '0.00', '0.00', '1', 3, 30, 0, '0'),
(71, '2018-09-06', '2018-09-06', '0.00', '', '0.00', '0.00', '1', 4, 30, 0, '1'),
(72, '2018-09-06', '2018-09-06', '0.00', '', '0.00', '0.00', '1', 4, 30, 0, '1');

--
-- Extraindo dados da tabela `entrada_insumos`
--

INSERT INTO `entrada_insumos` (`ins_id`, `ent_id`, `itens_qtde`, `itens_valor`) VALUES
(1, 67, '10.00', '10.00'),
(1, 68, '10.00', '4.59'),
(1, 70, '10.00', '4.75'),
(2, 68, '10.00', '7.45'),
(3, 67, '100.00', '1.00');

--
-- Extraindo dados da tabela `entrada_produtos`
--

INSERT INTO `entrada_produtos` (`ent_id`, `pro_id`, `itens_qtde`, `itens_valor`) VALUES
(69, 2, '100.00', '7.00'),
(71, 2, '100.00', '10.00'),
(72, 2, '10.00', '10000.00'),
(72, 3, '100.00', '10.00');

--
-- Extraindo dados da tabela `entrega`
--

INSERT INTO `entrega` (`ent_id`, `ent_dtCad`, `ent_status`, `entregador_id`, `emp_id`) VALUES
(1, '2019-04-24 09:52:18', '1', 1, 30),
(2, '2019-04-25 05:09:31', '1', 1, 30),
(3, '2019-04-26 09:36:17', '1', 1, 30),
(4, '2019-04-26 16:16:32', '1', 1, 30),
(5, '2019-04-29 13:56:42', '1', 2, 30),
(6, '2019-04-30 08:06:14', '1', 1, 30),
(7, '2019-05-07 09:40:40', '1', 1, 30),
(8, '2019-05-08 08:57:39', NULL, 3, 33);

--
-- Extraindo dados da tabela `entregador`
--

INSERT INTO `entregador` (`ent_id`, `ent_nome`, `ent_email`, `ent_telefone`, `ent_celular`, `ent_celular2`, `ent_ativo`, `ent_obs`, `emp_id`, `end_id`) VALUES
(1, 'Lucas', 'lucas.tarta@hotmail.com', '(34) 2342-3423', '(23) 423', '', '1', 'sdfdf', 30, 36),
(2, 'Teste', 'teste@teste.com', '(18) 3333-3333', '(08) 99999-9991', '', '1', '', 30, 29),
(3, 'Lucas', 'lucas.tarta@hotmail.com', '', '(18) 99999-9999', '', '1', '', 33, 33);

--
-- Extraindo dados da tabela `entrega_enderecos`
--

INSERT INTO `entrega_enderecos` (`identrega_enderecos`, `rua`, `numero`, `cep`, `bairro`, `cidade`, `estado`, `ent_id`) VALUES
(1, 'Rua Jacinto Poiato', 13, '19025-340', 'Parque São Matheus', 'Presidente Prudente', 'sp', 1),
(2, 'Rua Fernando Costa', 111, '19020-570', 'Vila Boa Vista', 'Presidente Prudente', 'sp', 1),
(3, 'Rua Jacinto Poiato', 13, '19025-340', 'Parque São Matheus', 'Presidente Prudente', 'sp', 2),
(4, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Presidente Prudente', 'sp', 3),
(5, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Presidente Prudente', 'sp', 4),
(6, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Presidente Prudente', 'sp', 5),
(7, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Presidente Prudente', 'sp', 6),
(8, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Presidente Prudente', 'sp', 7),
(9, 'Rua Fernando Costa', 111, '19020-570', 'Vila Boa Vista', 'Presidente Prudente', 'sp', 8),
(10, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Presidente Prudente', 'sp', 8),
(11, 'Rua Fernando Costa', 981, '19020-570', 'Vila Boa Vista', 'Presidente Prudente', 'sp', 8);

--
-- Extraindo dados da tabela `estado`
--

INSERT INTO `estado` (`est_sigla`, `est_nome`) VALUES
('sp', 'São Paulo');

--
-- Extraindo dados da tabela `forma_pagto`
--

INSERT INTO `forma_pagto` (`pag_id`, `pag_nome`, `pag_descricao`, `pag_numParcelas`, `pag_entrada`, `pag_ativo`, `emp_id`) VALUES
(1, 'À Vista', 'Pagamento &agrave; vista', 0, '0', '1', 30),
(3, '+30 dias', '', 1, '0', '1', 30),
(4, 'Entrada + 30 dias', '', 1, '1', '1', 30),
(5, '5 vezes', '', 5, '0', '1', 30);

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`for_id`, `for_nome`, `for_email`, `for_telefone`, `for_celular`, `for_celular2`, `for_ativo`, `for_obs`, `for_razao`, `for_cnpj`, `emp_id`, `end_id`) VALUES
(1, 'Fornecedor 1', 'cvb@cvb.cvb', '(34) 7865-784', '(34) 78584', '(78) 58374-5', '1', '', 'fgjgj', '', 30, 33),
(2, 'Fornecedor 2', 'for2@email.com', '', '(99) 99999-9999', '', '1', '', 'Forncedor 2', '11.111.111/1111-11', 30, 41);

--
-- Extraindo dados da tabela `insumo`
--

INSERT INTO `insumo` (`ins_id`, `ins_dtCad`, `ins_nome`, `ins_controle_estoque`, `ins_obs`, `ins_ativo`, `ins_estoque_minimo`, `ins_estoque_atual`, `uni_id`, `cat_id`, `for_id`, `emp_id`) VALUES
(1, '2018-08-23', 'Calabresa', '1', '', '1', NULL, '0.00', 1, 2, 1, 30),
(2, '2018-08-22', 'Mussarela', '0', '', '1', NULL, NULL, 1, 1, 1, 30),
(3, '2018-08-22', 'Molho de Tomate', '0', '', '1', NULL, NULL, 1, 1, 1, 30),
(4, '2018-08-22', 'Ovos', '0', '', '1', NULL, NULL, 2, 2, 1, 30);

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`idmenu`, `descricao_menu`, `url`, `status`, `icone`, `tipo`) VALUES
(4, 'Usuários', '', 1, 'fa-users', NULL),
(5, 'Cadastros', NULL, 1, NULL, NULL),
(6, 'Permissões', NULL, 1, NULL, NULL),
(9, 'Gerenciar Contas', '', 1, 'fa-money', NULL),
(10, 'Movimentação', '', 1, 'fa-shopping-cart', NULL),
(11, 'Restaurantes', '', 1, 'fa-home', NULL),
(12, 'Insumos', '', 1, 'fa-tags', '1'),
(13, 'Produtos', '', 1, 'fa-tags', '1'),
(14, 'Finanças', '', 1, 'fa-money', '1'),
(15, 'Complementos', '', 0, 'fa-list-alt', '1'),
(16, 'Cadastros', '', 1, 'fa-users', '1'),
(17, 'Movimentos', '', 1, 'fa-exchange', '1'),
(19, 'Permissões (Empresas)', '', 1, 'fa-key', NULL),
(20, 'Promoções', '', 1, 'fa-percent', '1'),
(21, 'Configurações', '', 1, 'fa-gears', '1');

--
-- Extraindo dados da tabela `menu_usuarios_empresa`
--

INSERT INTO `menu_usuarios_empresa` (`idusuarios`, `emp_id`, `idmenu`) VALUES
(40, 30, 12),
(41, 31, 12),
(42, 32, 12),
(43, 33, 12),
(40, 30, 13),
(41, 31, 13),
(42, 32, 13),
(43, 33, 13),
(40, 30, 14),
(41, 31, 14),
(42, 32, 14),
(43, 33, 14),
(40, 30, 15),
(41, 31, 15),
(42, 32, 15),
(43, 33, 15),
(40, 30, 16),
(41, 31, 16),
(42, 32, 16),
(43, 33, 16),
(40, 30, 17),
(41, 31, 17),
(42, 32, 17),
(43, 33, 17),
(40, 30, 20),
(41, 31, 20),
(42, 32, 20),
(43, 33, 20),
(40, 30, 21),
(41, 31, 21),
(42, 32, 21),
(43, 33, 21);

--
-- Extraindo dados da tabela `motivo_uso`
--

INSERT INTO `motivo_uso` (`mot_id`, `mot_nome`, `emp_id`) VALUES
(1, 'Insumo Estragado', 30),
(2, 'Insumo Vencido', 30),
(3, 'Insumo Consumido', 30),
(4, 'Insumo Disperdiçado', 30);

--
-- Extraindo dados da tabela `permissoes`
--

INSERT INTO `permissoes` (`idpermissoes`, `visualizar`, `inserir`, `alterar`, `excluir`) VALUES
(13, 1, 1, 1, 1),
(14, 1, 1, 1, 1),
(16, 1, 1, 1, 1),
(18, 1, 1, 1, 1),
(19, 1, 1, 1, 1),
(20, 1, 1, 1, 1),
(21, 1, 1, 1, 1),
(22, 1, 1, 1, 1),
(26, 1, 1, 1, 1),
(27, 1, 1, 1, 1),
(30, 1, 1, 1, 1),
(31, 1, 1, 1, 1),
(33, 1, 1, 1, 1),
(34, 1, 1, 1, 1),
(35, 1, 1, 1, 1),
(36, 1, 1, 1, 1),
(37, 1, 1, 1, 1),
(38, 1, 1, 1, 1),
(39, 1, 1, 1, 1),
(41, 1, 1, 1, 1);

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`pro_id`, `pro_dtCad`, `pro_nome`, `pro_descricao`, `pro_custo`, `pro_valor`, `pro_ativo`, `pro_controle_estoque`, `pro_foto`, `pro_estoque_minimo`, `pro_estoque_atual`, `uni_id`, `for_id`, `emp_id`, `cat_id`) VALUES
(2, '2019-04-03', 'Coca-Cola 2LT', 'Refrigerante Coca-Cola 2 litros', '4.00', '6.00', '1', '1', '2_20190220125714.png', NULL, '210.00', 2, 1, 30, 5),
(3, '2019-04-03', 'Cerveja Skol Lata', 'Cerveja Skol Lata 350 ml', '3.00', '5.50', '1', '0', '3_20190220125809.jpg', NULL, NULL, 2, 1, 30, 6),
(4, '2019-02-22', 'Funada 2L', 'Refrigerante Funada 2 litros, escolha o sabor', '2.00', '5.00', '1', '0', '4_20190221081239.jpg', NULL, NULL, 2, NULL, 30, 5),
(6, '2019-04-03', 'X-Tudo', 'Pão, hambúrguer, filé, calabresa, bacon, coração, frango desfiado, presunto, mussarela, ovo, tomate, alface e milho', '13.00', '25.00', '1', '0', '6_20190222140925.jpg', NULL, NULL, 2, NULL, 30, 3),
(7, '2019-04-03', 'X- Salada', 'Pão hambúrguer, hambúrguer, queijo, alface, maionese, tomate', '15.00', '20.00', '1', '0', '7_20190403121334.jpg', NULL, NULL, 2, NULL, 30, 3),
(8, '2019-04-03', 'X - Bacon', 'Pão hambúrguer, hambúrguer, queijo, bacon, alface, maionese', '15.00', '22.00', '1', '0', '8_20190403121608.jpg', NULL, NULL, 2, NULL, 30, 3),
(9, '2019-04-03', 'Especial', 'Pão hambúrguer, 2 hamburguers, queijo, tomate, alface, maionese', '12.00', '16.50', '1', '0', '9_20190403121743.png', NULL, NULL, 2, NULL, 30, 3),
(10, '2019-04-03', 'Misto Quente', 'Pão francês, presunto, queijo', '9.50', '14.50', '1', '0', '10_20190403121952.png', NULL, NULL, 2, NULL, 30, 3),
(11, '2019-04-03', 'Americano', 'Pão de forma, presunto, queijo, tomate, alface, ovo', '12.50', '16.50', '1', '0', '11_20190403122105.jpg', NULL, NULL, 2, NULL, 30, 3),
(13, '2019-04-03', 'Cerveja Brahma Lata', 'Cerveja Brahma Lata 350 ml', '3.00', '5.00', '1', '0', '13_20190403122909.png', NULL, NULL, 2, NULL, 30, 6),
(14, '2019-04-03', 'Cerveja Brahma Garrafa', 'Cerveja Brahma garrafa 600ml', '4.00', '7.00', '1', '0', '14_20190403123330.jpg', NULL, NULL, 2, NULL, 30, 6),
(15, '2019-04-03', 'Cerveja Skol Garrafa', 'Cerveja Skol Garrafa 600ml', '4.50', '7.50', '1', '0', '15_20190403123514.jpg', NULL, NULL, 2, NULL, 30, 6),
(16, '2019-04-03', 'Fanta 2L', 'Refrigerante Fanta 2 litros', '4.00', '5.50', '1', '0', '16_20190403124101.jpg', NULL, NULL, 2, NULL, 30, 5),
(17, '2019-04-03', 'Guaraná Antarctica', 'Refrigerante guaraná antarctica 2 litros', '4.00', '6.00', '1', '0', '17_20190403124246.png', NULL, NULL, 2, NULL, 30, 5),
(18, '2019-04-03', 'Croquete / Bolinho de queijo', '50 unidades de croquete e 50 unidades de bolinha de queijo', '5.00', '8.00', '1', '0', '18_20190403133441.jpg', NULL, NULL, 2, NULL, 30, 8),
(19, '2019-04-03', 'Bolinho de Bacalhau', '50 unidades de bolinhos de bacalhau', '5.00', '9.50', '1', '0', '19_20190403133549.jpg', NULL, NULL, 2, NULL, 30, 8),
(22, '2019-04-03', 'Kibe', '50 unidades de kibes', '4.00', '7.50', '1', '0', '22_20190403134431.jpg', NULL, NULL, 2, NULL, 30, 8),
(23, '2019-04-03', 'Esfirra de Carne', 'A clássica e deliciosa esfiha aberta de carne, feita com todo cuidado e carinho para você.', '1.00', '2.50', '1', '0', '23_20190403140117.png', NULL, NULL, 2, NULL, 30, 4),
(24, '2019-04-03', 'Esfirra de Frango', 'Olha que delícia essa esfiha aberta com recheio especial de frango. Vai resistir?', '1.00', '2.50', '1', '0', '24_20190403140201.png', NULL, NULL, 2, NULL, 30, 4),
(25, '2019-04-03', 'esfirra de Calabresa e mussarela', 'Olha que delícia essa esfiha aberta com recheio especial de calabresa e mussarela. Vai resistir?', '1.00', '2.50', '1', '0', '25_20190403140400.jpg', NULL, NULL, 2, NULL, 30, 4),
(26, '2019-04-03', 'Esfirra de Queijo', 'A deliciosa esfiha aberta com queijo minas derretido. O recheio é fresquinho e a qualidade é incrível', '1.00', '2.70', '1', '0', '26_20190403140536.png', NULL, NULL, 2, NULL, 30, 4),
(27, '2019-04-03', 'Esfirra de Chocolate', 'As deliciosas esfihas feitas na hora com recheio irresistível de chocolate.', '2.50', '5.90', '1', '0', '27_20190403140649.jpg', NULL, NULL, 2, NULL, 30, 4),
(28, '2019-04-03', 'Coca-Cola Lata 350ml', 'Refrigerante Coca-Cola Lata 350ml', '3.00', '4.50', '1', '0', '28_20190403141204.png', NULL, NULL, 2, NULL, 30, 5),
(29, '2019-04-03', 'Fanta Lata 350ML', 'Refrigerante Fanta Lata 350ml', '3.00', '4.50', '1', '0', '29_20190403141343.png', NULL, NULL, 1, NULL, 30, 5),
(30, '2019-04-03', 'Guaraná Antarctica Lata 350ml', 'Refrigerante Guaraná Antarctica Lata 350ml', '3.00', '4.50', '1', '0', '30_20190403141500.jpg', NULL, NULL, 2, NULL, 30, 5),
(31, '2019-04-03', 'Suco de Açaí 500ml', 'Copo de Suco de Açaí 500ml', '3.00', '6.00', '1', '0', '31_20190403141920.jpg', NULL, NULL, 2, NULL, 30, 7),
(32, '2019-04-03', 'Suco de Manga 500ml', 'Copo de Suco de Manga 500ml', '3.00', '6.00', '1', '0', '32_20190403142101.jpg', NULL, NULL, 2, NULL, 30, 7),
(33, '2019-04-03', 'Suco de Limão 500ml', 'Suco de Limão 500ml', '3.00', '6.00', '1', '0', '33_20190403142154.jpg', NULL, NULL, 2, NULL, 30, 7),
(34, '2019-04-03', 'Suco de Uva 500ml', 'Copo de Suco de Uva 500ml', '3.00', '6.00', '1', '0', '34_20190403142409.jpg', NULL, NULL, 2, NULL, 30, 7),
(35, '2019-04-03', 'Suco de Maracujá 500ml', 'Copo de Suco de Maracujá 500ml', '3.00', '6.00', '1', '0', '35_20190403142522.jpg', NULL, NULL, 2, NULL, 30, 7),
(36, '2019-04-03', 'Suco de Abacaxi 500ml', 'Copo de Suco de Abacaxi 500ml', '3.00', '6.00', '1', '0', '36_20190403142613.jpg', NULL, NULL, 2, NULL, 30, 7),
(37, '2019-04-03', 'Suco de Morango 500ml', 'Copo de Suco de Morango 500ml', '3.00', '6.00', '1', '0', '37_20190403142711.jpg', NULL, NULL, 2, NULL, 30, 7),
(38, '2019-04-03', 'Suco de Laranja 500ml', 'Copo de Suco de Laranja 500ml', '3.00', '6.00', '1', '0', '38_20190403142843.png', NULL, NULL, 2, NULL, 30, 7),
(39, '2019-04-03', 'Suco de Goiaba 500ml', 'Copo de Suco de Goiaba 500ml', '3.00', '6.00', '1', '0', '39_20190403142917.jpg', NULL, NULL, 2, NULL, 30, 7),
(40, '2019-04-18', 'Brócolis com palmito', '(Brócolis refogado com palmito)', '5.00', '9.50', '1', '0', '40_20190418081342.jpg', NULL, NULL, 2, NULL, 33, 9),
(41, '2019-04-18', 'Strogonoff carne com queijo', '(Creme strogonoff com pedaços de carne com mazarela)', '8.00', '11.00', '1', '0', '41_20190418081412.jpg', NULL, NULL, 2, NULL, 33, 9),
(42, '2019-04-18', 'Strogonoff carne', '(Creme strogonoff com pedaços de carne)', '6.00', '9.90', '1', '0', '42_20190418081435.jpg', NULL, NULL, 2, NULL, 33, 9),
(43, '2019-04-18', 'Pizza com calabresa', '(mozarela, presunto, tomate, orégano e calabresa fatiada)', '5.00', '9.50', '1', '0', '43_20190418081455.jpg', NULL, NULL, 2, NULL, 33, 9),
(44, '2019-04-18', 'Chocobom com banana', '(um bombom sonho de valsa e banana fatiada)', '5.00', '8.25', '1', '0', '44_20190418082022.jpg', NULL, NULL, 2, NULL, 33, 10),
(45, '2019-04-18', 'Nutella', '(Creme de avelã)', '5.00', '10.90', '1', '0', '45_20190418082044.jpg', NULL, NULL, 2, NULL, 33, 10),
(46, '2019-04-18', 'Banana com leite condensado', '(Banana fatiada com leite condensado)', '5.00', '8.25', '1', '0', '46_20190418081954.jpg', NULL, NULL, 2, NULL, 33, 10),
(47, '2019-04-18', 'Doce de leite com chocobom', '(Doce de leite cremoso e um sonho de valsa)', '5.00', '8.25', '1', '0', '47_20190418082035.jpg', NULL, NULL, 2, NULL, 33, 10),
(48, '2019-04-18', 'Brigadeiro', '(Brigadeiro Cremoso)', '5.00', '8.25', '1', '0', '48_20190418082002.jpg', NULL, NULL, 2, NULL, 33, 10),
(49, '2019-04-18', '14 Unidades (Bacalhau ou camarão)', '(Bacalhau ou camarão)', '15.00', '29.50', '1', '0', '49_20190418082223.jpg', NULL, NULL, 2, NULL, 33, 11),
(50, '2019-04-18', '14 Unidades (Palmito ou carne seca)', '(Palmito ou carne seca)', '15.00', '23.00', '1', '0', '50_20190418082314.jpg', NULL, NULL, 2, NULL, 33, 11),
(51, '2019-04-18', '7 unidades (Palmito ou carne-seca)', '(Palmito ou carne-seca)', '5.50', '14.50', '1', '0', '51_20190418082403.jpg', NULL, NULL, 2, NULL, 33, 11);

--
-- Extraindo dados da tabela `produto_tem_complementos`
--

INSERT INTO `produto_tem_complementos` (`pro_com_id`, `nome`, `descricao`, `preco`, `catcom_id`, `pro_id`) VALUES
(51, 'Refricola', '', '0.00', 11, 4),
(52, 'Guaraná', '', '0.00', 11, 4),
(53, 'Soda', '', '0.00', 11, 4),
(54, 'Mican', '', '0.00', 11, 4);

--
-- Extraindo dados da tabela `promocao`
--

INSERT INTO `promocao` (`pro_id`, `pro_nome`, `pro_tipo`, `pro_dtInicio`, `pro_dtFinal`, `pro_cupom`, `pro_ativo`, `pro_desc_valor`, `pro_desc_porc`, `emp_id`, `pro_tipo_desconto`) VALUES
(5, 'Desconto de R$ 10,00', '0', '2018-09-12', '2020-04-01', 'desconto10', '1', '10.00', '0.00', 30, '2'),
(6, 'Promoção do Dia', '0', '2018-09-12', '2020-04-01', 'promocaododia', '1', '0.00', '10.00', 30, '1'),
(7, 'Promoção Pastel loko', '0', '2019-04-19', '2019-05-08', 'promocaoloko', '1', '0.00', '10.00', 33, '1'),
(8, 'Desconto Lanches', '1', '2019-05-10', '2019-06-14', NULL, '1', '0.00', '0.00', 30, ''),
(9, 'Desconto Sucos', '1', '2019-05-10', '2019-05-17', NULL, '1', '0.00', '0.00', 30, '');

--
-- Extraindo dados da tabela `promocao_tem_produtos`
--

INSERT INTO `promocao_tem_produtos` (`produto_id`, `promocao_id`, `desc_porcentagem`, `desc_valor`, `tipo_desconto`) VALUES
(6, 8, '10.00', NULL, '1'),
(7, 8, '10.00', NULL, '1'),
(8, 8, '10.00', NULL, '1'),
(11, 8, '10.00', NULL, '1'),
(31, 9, NULL, '2.00', '2'),
(32, 9, NULL, '2.00', '2'),
(33, 9, NULL, '2.00', '2'),
(35, 9, NULL, '2.00', '2'),
(38, 9, NULL, '2.00', '2'),
(39, 9, NULL, '2.00', '2');

--
-- Extraindo dados da tabela `responsavel_empresa`
--

INSERT INTO `responsavel_empresa` (`resp_id`, `emp_id`, `resp_nome`, `resp_obs`, `resp_email`, `resp_fone`, `end_id`, `usu_adm`) VALUES
(8, 30, 'Lucas', 'O Habib?s é a maior rede de restaurantes do mundo de comida árabe. Delícias como a exclusiva esfiha, kibe, beirute, pastel, pizzas, bolinho de bacalhau e sobremesas como sorvetes, pastel de belém, pudim e refrigerantes e sucos completam seu pedido', 'lucas.tarta.empresa@hotmail.com', '(18) 9999-9', 30, 40),
(9, 31, 'Tempero Baiano', 'edrtggf', 'teste@teste.com', '(18) 9999-9999', 14, 41),
(10, 32, 'Lug&#39;s - Presidente Prudente', '', 'lugs@teste.com', '(18) 9999-9999', 15, 42),
(11, 33, 'Pasteloko - Dr Gurgel', '', 'lugs@teste.com3', '(18) 3333-3333', 16, 43);

--
-- Extraindo dados da tabela `saida`
--

INSERT INTO `saida` (`idsaida`, `data_criacao`, `total_geral`, `total_itens`, `taxa_entrega`, `promocao_nome`, `promocao_cupom`, `promocao_tipo_desconto`, `promocao_valor`, `cartao_ultimos_digitos`, `troco`, `status`, `tipo_pagamento`, `emp_id`, `cli_id`, `idcarrinho`, `endereco_id`, `entrega_id`) VALUES
(1, '2019-04-22 12:26:04', '49.95', '45.50', '10.00', 'Promoção do Dia', 'promocaododia', '1', '10.00', '0993', NULL, '1', '2', 30, 1, 1, 10, 1),
(2, '2019-04-22 12:27:35', '66.25', '54.25', '12.00', NULL, NULL, NULL, NULL, NULL, '100.00', '1', '1', 33, 1, 2, 17, 8),
(3, '2019-04-22 18:02:19', '65.70', '63.00', '10.00', 'Promoção do Dia', 'promocaododia', '1', '10.00', NULL, NULL, '1', '1', 30, 1, 3, 17, 1),
(4, '2019-04-25 07:46:43', '15.50', '5.50', '10.00', NULL, NULL, NULL, NULL, NULL, NULL, '2', '1', 30, 1, 5, 17, NULL),
(5, '2019-04-25 07:51:14', '37.00', '27.00', '10.00', NULL, NULL, NULL, NULL, '8376', NULL, '1', '2', 30, 1, 6, 10, 2),
(6, '2019-04-26 08:16:23', '66.60', '64.00', '10.00', 'Promoção do Dia', 'promocaododia', '1', '10.00', '3605', NULL, '1', '2', 30, 1, 7, 28, 3),
(7, '2019-04-26 13:18:38', '20.25', '8.25', '12.00', NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', 33, 1, 8, 28, 8),
(8, '2019-04-26 13:18:56', '24.00', '14.00', '10.00', NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', 30, 1, 9, 28, 4),
(9, '2019-04-29 08:08:57', '104.40', '106.00', '10.00', 'Promoção do Dia', 'promocaododia', '1', '10.00', NULL, '100.00', '1', '1', 30, 1, 10, 28, 5),
(10, '2019-04-29 14:27:15', '27.70', '17.70', '10.00', NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', 30, 1, 11, 28, 6),
(11, '2019-05-07 08:30:32', '107.50', '97.50', '10.00', NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', 30, 1, 12, 28, 7),
(12, '2019-05-07 09:37:37', '80.55', '79.50', '10.00', 'Promoção do Dia', 'promocaododia', '1', '10.00', NULL, '100.00', '2', '1', 30, 1, 13, 31, NULL),
(13, '2019-05-08 08:56:11', '40.32', '32.80', '12.00', 'Promoção Pastel loko', 'promocaoloko', '1', '10.00', NULL, '100.00', '1', '1', 33, 10, 15, 32, 8);

--
-- Extraindo dados da tabela `saida_produtos`
--

INSERT INTO `saida_produtos` (`id_prod_saida`, `idsaida`, `qtde`, `preco`, `nome`, `obs`, `carrinho_pro_id`) VALUES
(1, 1, 1, '25.00', 'X-Tudo', '', 6),
(2, 1, 1, '8.00', 'Croquete / Bolinho de queijo', '', 18),
(3, 1, 1, '6.00', 'Coca-Cola 2LT', '', 2),
(4, 2, 3, '8.25', 'Chocobom com banana', '', 44),
(5, 2, 1, '29.50', '14 Unidades (Bacalhau ou camarão)', '', 49),
(6, 3, 1, '25.00', 'X-Tudo', '', 6),
(7, 3, 1, '22.00', 'X - Bacon', 'cortado ao meio', 8),
(8, 3, 1, '6.00', 'Guaraná Antarctica', '', 17),
(9, 4, 1, '5.50', 'Cerveja Skol Lata', '', 3),
(10, 5, 1, '5.00', 'Cerveja Brahma Lata', '', 13),
(11, 5, 6, '2.50', 'Esfirra de Carne', '', 23),
(12, 5, 1, '7.00', 'Cerveja Brahma Garrafa', '', 14),
(13, 6, 1, '25.00', 'X-Tudo', 'cortado ao meio', 6),
(14, 6, 1, '25.00', 'X-Tudo', '', 6),
(15, 6, 1, '7.50', 'Kibe', '', 22),
(16, 7, 1, '8.25', 'Chocobom com banana', '', 44),
(17, 8, 2, '7.00', 'Cerveja Brahma Garrafa', '', 14),
(18, 9, 2, '22.00', 'X - Bacon', '', 8),
(19, 9, 1, '25.00', 'X-Tudo', '', 6),
(20, 9, 1, '22.00', 'X - Bacon', '', 8),
(21, 10, 3, '5.90', 'Esfirra de Chocolate', '', 27),
(22, 11, 1, '5.50', 'Cerveja Skol Lata', '', 3),
(23, 11, 2, '25.00', 'X-Tudo', '', 6),
(24, 11, 1, '25.00', 'X-Tudo', '', 6),
(25, 12, 5, '5.50', 'Cerveja Skol Lata', '', 3),
(26, 12, 3, '2.50', 'Esfirra de Carne', '', 23),
(27, 12, 1, '25.00', 'X-Tudo', 'cortado ao meio', 6),
(28, 12, 1, '5.00', 'Funada 2L', '', 4),
(29, 13, 2, '10.90', 'Nutella', '', 45),
(30, 13, 1, '11.00', 'Strogonoff carne com queijo', '', 41);

--
-- Extraindo dados da tabela `submenu`
--

INSERT INTO `submenu` (`idsubmenu`, `descricao_submenu`, `url`, `status`, `menu_idmenu`, `tipo`) VALUES
(2, 'Menus', 'cad-menu.php', 1, 6, NULL),
(3, 'Submenus', 'cad-submenu.php', 1, 6, NULL),
(4, 'Gerenciar usuários', 'cad-usuarios.php', 1, 4, NULL),
(5, 'Tipo usuários', 'cad-tipousuarios.php', 1, 4, NULL),
(6, 'Tipo itens', 'cad-tipoitens.php', 1, 5, NULL),
(7, 'Gerenciar Clientes', 'gerenciar-clientes.php', 1, 5, NULL),
(8, 'Contas a Pagar', 'gerenciar-contas-pagar.php', 1, 9, NULL),
(9, 'Contas a Receber', 'gerenciar-contas-receber.php', 1, 9, NULL),
(10, 'Entradas de Insumos', 'gerenciar-entrada-insumos.php', 1, 10, NULL),
(11, 'Saídas de Produtos', 'gerenciar-saidas-produtos.php', 1, 10, NULL),
(12, 'Gerenciar Empresas', 'gerenciar-empresa.php', 1, 11, NULL),
(13, 'Cadastros de Menu', 'cad-menu-empresa.php', 1, 19, NULL),
(14, 'Cadastro de SubMenu', 'cad-submenu-empresa.php', 1, 19, NULL),
(15, 'Acesso dos Menus', 'permissao-menu-adm.php', 1, 19, NULL),
(16, 'Acesso dos SubMenus', 'permissao-submenu-adm.php', 1, 19, NULL),
(18, 'Categorias de Insumos', 'gerenciar-categorias-insumos.php', 1, 12, '1'),
(19, 'Gerenciar Insumos', 'gerenciar-insumos.php', 1, 12, '1'),
(20, 'Categorias de Produtos', 'gerenciar-categorias-produtos.php', 1, 13, '1'),
(21, 'Formas de Pagamento', 'gerenciar-formas-pagamento.php', 1, 16, '1'),
(22, 'Grupo de Complementos', 'gerenciar-categoria-caracteristicas.php', 1, 15, '1'),
(23, 'Gerenciar Complementos', 'gerenciar-caracteristicas-produtos.php', 1, 15, '1'),
(24, 'Gerenciar Produtos', 'gerenciar-produtos.php', 1, 13, '1'),
(25, 'Entrada de Insumos', 'gerenciar-entrada-insumos.php', 1, 17, '1'),
(27, 'Contas a Pagar', 'gerenciar-contas-pagar.php', 1, 14, '1'),
(28, 'Contas Receber', 'gerenciar-contas-receber.php', 1, 14, '1'),
(29, 'Gerenciar Entregadores', 'gerenciar-entregadores.php', 1, 16, '1'),
(31, 'Entrada de Produtos', 'gerenciar-entrada-produtos.php', 1, 10, NULL),
(32, 'Entrada de Produtos', 'gerenciar-entrada-produtos.php', 1, 17, '1'),
(33, 'Baixa do uso', 'gerenciar-baixa-uso.php', 1, 12, '1'),
(34, 'Gerenciar Clientes', 'gerenciar-clientes.php', 1, 16, '1'),
(35, 'Gerenciar Fornecedores', 'gerenciar-fornecedores.php', 1, 16, '1'),
(36, 'Gerenciar Promoções de Produtos', 'gerenciar-promocao.php', 1, 20, '1'),
(37, 'Gerenciar Cupons Promocionais', 'gerenciar-cupons-promocionais.php', 1, 20, '1'),
(38, 'Categorias de Cozinhas', 'gerenciar-categorias-cozinha.php', 1, 11, NULL),
(39, 'Categorias da Cozinha', 'gerenciar-cozinhas.php', 1, 21, '1'),
(40, 'Informações', 'gerenciar-informacoes.php', 1, 21, '1'),
(41, 'Gerenciar Imagens', 'gerenciar-imagens.php', 1, 21, '1'),
(43, 'Pedidos Realizados', 'pedidos-realizados.php', 1, 17, '1'),
(44, 'Avaliações de Pedidos', 'gerenciar-avaliacoes-pedidos.php', 1, 17, '1');

--
-- Extraindo dados da tabela `submenu_usuarios_empresa`
--

INSERT INTO `submenu_usuarios_empresa` (`idusuarios`, `emp_id`, `idsubmenu`) VALUES
(40, 30, 18),
(41, 31, 18),
(42, 32, 18),
(43, 33, 18),
(40, 30, 19),
(41, 31, 19),
(42, 32, 19),
(43, 33, 19),
(40, 30, 20),
(41, 31, 20),
(42, 32, 20),
(43, 33, 20),
(40, 30, 21),
(41, 31, 21),
(42, 32, 21),
(43, 33, 21),
(40, 30, 22),
(41, 31, 22),
(42, 32, 22),
(43, 33, 22),
(40, 30, 23),
(41, 31, 23),
(42, 32, 23),
(43, 33, 23),
(40, 30, 24),
(41, 31, 24),
(42, 32, 24),
(43, 33, 24),
(40, 30, 25),
(41, 31, 25),
(42, 32, 25),
(43, 33, 25),
(40, 30, 27),
(41, 31, 27),
(42, 32, 27),
(43, 33, 27),
(40, 30, 28),
(41, 31, 28),
(42, 32, 28),
(43, 33, 28),
(40, 30, 29),
(41, 31, 29),
(42, 32, 29),
(43, 33, 29),
(40, 30, 32),
(41, 31, 32),
(42, 32, 32),
(43, 33, 32),
(40, 30, 33),
(41, 31, 33),
(42, 32, 33),
(43, 33, 33),
(40, 30, 34),
(41, 31, 34),
(42, 32, 34),
(43, 33, 34),
(40, 30, 35),
(41, 31, 35),
(42, 32, 35),
(43, 33, 35),
(40, 30, 36),
(41, 31, 36),
(42, 32, 36),
(43, 33, 36),
(40, 30, 37),
(41, 31, 37),
(42, 32, 37),
(43, 33, 37),
(40, 30, 39),
(41, 31, 39),
(42, 32, 39),
(43, 33, 39),
(40, 30, 40),
(41, 31, 40),
(42, 32, 40),
(43, 33, 40),
(40, 30, 41),
(41, 31, 41),
(42, 32, 41),
(43, 33, 41),
(40, 30, 43),
(41, 31, 43),
(42, 32, 43),
(43, 33, 43),
(40, 30, 44),
(41, 31, 44),
(42, 32, 44),
(43, 33, 44);

--
-- Extraindo dados da tabela `tipousuarios`
--

INSERT INTO `tipousuarios` (`idusuariotipo`, `nome_tipo`) VALUES
(1, 'WebMaster'),
(2, 'Comum');

--
-- Extraindo dados da tabela `tipousuarios_has_menu`
--

INSERT INTO `tipousuarios_has_menu` (`tipousuarios_idusuariotipo`, `menu_idmenu`, `permissoes_idpermissoes`) VALUES
(1, 4, 16),
(2, 5, 20),
(1, 6, 13),
(1, 11, 33),
(1, 19, 39);

--
-- Extraindo dados da tabela `tipousuarios_has_submenu`
--

INSERT INTO `tipousuarios_has_submenu` (`tipousuarios_idusuariotipo`, `submenu_idsubmenu`, `permissoes_idpermissoes`) VALUES
(1, 2, 13),
(1, 3, 14),
(1, 4, 18),
(1, 5, 19),
(1, 6, 21),
(1, 7, 22),
(1, 8, 26),
(1, 9, 27),
(1, 10, 30),
(1, 11, 31),
(1, 12, 34),
(1, 13, 35),
(1, 14, 36),
(1, 15, 37),
(1, 16, 38),
(1, 38, 41);

--
-- Extraindo dados da tabela `unidade_medida`
--

INSERT INTO `unidade_medida` (`uni_id`, `uni_nome`, `uni_formula`, `uni_sigla`) VALUES
(1, 'Kilograma', '1 x 1 KG', 'KG'),
(2, 'Unidade', '1 x 1 UN', 'UN'),
(3, 'Litro', '1 x 1 LT', 'LT');

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idusuarios`, `usuario`, `senha`, `email`, `nome`, `status`, `tipo_empresa`) VALUES
(19, 'admin', '$2y$10$IQFHFQ3hKrxkYLo8rNbyNudRnD6HICs5nZOJJQz5Wed4BosfM8TEa', 'admin@admin.com', 'Administrador do Sitema', 1, NULL),
(29, 'adminssds', '$2y$10$QSO73.HYfGMjQKabNp8VpebPRZ/S3Pu.MpsEe58NKyrith2XuPQcy', 'admfgfin@admin.com', NULL, 0, '1'),
(30, 'aa', '$2y$10$2keGXzUnodKeYURtgH673eDSCBQ2iNwCOe1eNdMt6o.3YxcdQu6UO', 'aaa@sdf.sdf', NULL, 0, '1'),
(34, 'lucas', '$2y$10$BDOEsUnRnsLOUVH2cxCU2utYmB9nqL9YhDPdF7bnOeX1asRUaPncO', 'lucas.tarta@hotmail.com', '', 0, '1'),
(36, 'dgh', '$2y$10$TzKxo8xWWFYxt3ajoCV1BeLY6UOBds3vQRvSalXYXY5FNQSJ8NEue', 'lucas.tartghjka3@hotmail.com', '', 0, '1'),
(37, 'ghjghj', '$2y$10$gP8WNGmzy7nhOqboNjxuuO4dzkmBYfXDbDOMxzpChrUqDkTAAviJC', 'hf@sdf.sdf', '', 1, '1'),
(38, 'aaaa', '$2y$10$FRbzVYR30oaP3MNLrsiO/eHbulaYmS2OwdnSGVESAd2zW6HMjmIR6', 'aaaaaaaaaa@aaa.com', '', 1, '1'),
(40, 'lucas_empresa', '$2y$10$AScVkwnSD5ZhrLh7rMKUseXz2ZFyAP3VrjZgImSfaZ2XGnSDMMQem', 'lucas.tarta.empresa@hotmail.com', '', 1, '1'),
(41, 'teste', '$2y$10$yzUftSLZu4D5jLeVMVF4zOAwFR2pib5Y6RF1RVB.Nt54fJ5108gu2', 'teste@teste.com', '', 1, '1'),
(42, 'lugs', '$2y$10$YuZalJjLttq4lB55ZpBUJu/WEpjhVKwvYVKSirFfbf19JUoTZxiny', 'lugs@teste.com', '', 1, '1'),
(43, 'pasteloko', '$2y$10$sOVgwmghJ0BYJrFUO85OseYc2GePgkggpiHdOWTRWtTN1EYNbNfxG', 'lugs@teste.com3', '', 1, '1');

--
-- Extraindo dados da tabela `usuarios_has_empresa`
--

INSERT INTO `usuarios_has_empresa` (`idusuarios`, `emp_id`) VALUES
(40, 30),
(41, 31),
(42, 32),
(43, 33);

--
-- Extraindo dados da tabela `usuarios_has_tipousuarios`
--

INSERT INTO `usuarios_has_tipousuarios` (`usuarios_idusuarios`, `tipousuarios_idusuariotipo`) VALUES
(19, 1);

--
-- Extraindo dados da tabela `usuario_logs`
--

INSERT INTO `usuario_logs` (`idusuario_logs`, `data_hora`, `usuarios_idusuarios`) VALUES
(1, '2018-06-06 15:27:11', 19),
(2, '2018-06-06 15:29:25', 19),
(3, '2018-06-06 15:35:35', 19),
(4, '2018-06-08 11:07:42', 40),
(5, '2018-06-08 11:09:15', 19),
(6, '2018-06-08 11:27:17', 40),
(7, '2018-06-08 11:40:31', 19),
(8, '2018-06-08 11:42:19', 40),
(9, '2018-06-08 11:47:15', 19),
(10, '2018-06-08 11:47:32', 40),
(11, '2018-06-08 11:53:47', 19),
(12, '2018-06-08 14:03:24', 40),
(13, '2018-06-08 15:00:46', 19),
(14, '2018-06-11 08:32:54', 19),
(15, '2018-06-11 08:47:45', 40),
(16, '2018-06-28 11:37:19', 19),
(17, '2018-06-28 11:37:29', 40),
(18, '2018-07-30 15:40:26', 19),
(19, '2018-08-08 12:02:16', 40),
(20, '2018-08-08 12:07:57', 40),
(21, '2018-08-08 12:51:03', 19),
(22, '2018-08-08 18:03:03', 40),
(23, '2018-08-09 09:01:55', 40),
(24, '2018-08-09 09:40:24', 40),
(25, '2018-08-09 09:46:18', 19),
(26, '2018-08-09 11:56:31', 40),
(27, '2018-08-09 17:48:56', 40),
(28, '2018-08-10 08:28:05', 40),
(29, '2018-08-10 10:08:42', 40),
(30, '2018-08-10 14:11:32', 40),
(31, '2018-08-10 14:40:00', 40),
(32, '2018-08-10 14:56:56', 19),
(33, '2018-08-10 15:03:49', 40),
(34, '2018-08-10 15:06:18', 40),
(35, '2018-08-10 16:39:46', 40),
(36, '2018-08-10 18:05:18', 40),
(37, '2018-08-13 13:00:09', 40),
(38, '2018-08-13 13:18:36', 40),
(39, '2018-08-13 13:39:20', 40),
(40, '2018-08-14 08:03:51', 40),
(41, '2018-08-15 12:50:32', 40),
(42, '2018-08-20 12:49:32', 40),
(43, '2018-08-20 13:24:45', 19),
(44, '2018-08-20 17:57:10', 40),
(45, '2018-08-21 13:00:45', 40),
(46, '2018-08-21 17:59:53', 40),
(47, '2018-08-22 18:00:08', 40),
(48, '2018-08-23 12:48:34', 40),
(49, '2018-08-24 12:54:19', 40),
(50, '2018-08-27 12:48:54', 40),
(51, '2018-08-27 18:00:06', 40),
(52, '2018-08-28 13:08:52', 40),
(53, '2018-08-29 12:07:41', 40),
(54, '2018-08-30 12:06:06', 40),
(55, '2018-08-31 12:47:03', 40),
(56, '2018-08-31 12:51:08', 19),
(57, '2018-08-31 12:54:40', 40),
(58, '2018-09-03 12:46:32', 40),
(59, '2018-09-03 18:17:35', 40),
(60, '2018-09-03 18:31:57', 40),
(61, '2018-09-04 12:42:17', 40),
(62, '2018-09-06 12:50:23', 40),
(63, '2018-09-06 12:51:16', 19),
(64, '2018-09-06 12:52:42', 40),
(65, '2018-09-06 12:52:56', 19),
(66, '2018-09-06 12:54:20', 40),
(67, '2018-09-06 12:54:32', 19),
(68, '2018-09-06 12:54:52', 40),
(69, '2018-09-10 12:02:41', 40),
(70, '2018-09-10 12:03:42', 40),
(71, '2018-09-10 12:03:52', 19),
(72, '2018-09-11 12:42:53', 40),
(73, '2018-09-11 12:47:29', 19),
(74, '2018-09-11 12:59:04', 19),
(75, '2018-09-11 18:14:03', 40),
(76, '2018-09-11 18:20:02', 19),
(77, '2018-09-12 12:09:58', 40),
(78, '2018-09-12 17:56:31', 40),
(79, '2018-09-13 12:02:44', 40),
(80, '2018-09-18 11:55:39', 40),
(81, '2018-09-18 12:02:14', 19),
(82, '2018-10-09 08:39:10', 40),
(83, '2018-10-17 12:06:46', 40),
(84, '2018-10-25 14:54:11', 40),
(85, '2018-11-07 12:47:54', 40),
(86, '2018-11-07 12:49:04', 19),
(87, '2018-11-07 17:57:47', 19),
(88, '2018-12-14 13:21:01', 19),
(89, '2019-01-08 17:19:41', 19),
(90, '2019-01-08 17:20:28', 40),
(91, '2019-02-01 11:14:49', 40),
(92, '2019-02-06 08:07:29', 40),
(93, '2019-02-06 08:17:25', 19),
(94, '2019-02-06 08:39:33', 19),
(95, '2019-02-06 08:39:42', 40),
(102, '2019-02-07 07:59:25', 19),
(103, '2019-02-07 08:01:11', 40),
(104, '2019-02-07 12:09:49', 19),
(105, '2019-02-07 12:20:09', 40),
(106, '2019-02-07 12:21:31', 40),
(107, '2019-02-08 08:04:27', 40),
(108, '2019-02-08 12:03:12', 40),
(109, '2019-02-08 12:08:50', 19),
(110, '2019-02-08 12:37:51', 40),
(111, '2019-02-08 12:39:34', 19),
(112, '2019-02-08 12:39:55', 19),
(113, '2019-02-08 12:40:31', 40),
(114, '2019-02-08 13:53:31', 19),
(115, '2019-02-11 08:06:50', 40),
(116, '2019-02-11 08:08:37', 19),
(117, '2019-02-11 11:59:20', 40),
(118, '2019-02-12 08:05:30', 40),
(119, '2019-02-12 12:01:34', 40),
(120, '2019-02-13 12:12:59', 40),
(121, '2019-02-13 12:22:41', 19),
(122, '2019-02-13 12:22:53', 40),
(123, '2019-02-13 13:37:03', 41),
(124, '2019-02-13 13:37:13', 19),
(125, '2019-02-13 13:38:21', 41),
(126, '2019-02-13 13:49:59', 19),
(127, '2019-02-13 13:50:28', 19),
(128, '2019-02-13 13:51:37', 19),
(129, '2019-02-13 13:52:41', 19),
(130, '2019-02-13 13:52:58', 42),
(131, '2019-02-13 13:53:25', 19),
(132, '2019-02-13 13:54:29', 42),
(133, '2019-02-13 13:54:46', 19),
(134, '2019-02-13 13:55:02', 42),
(135, '2019-02-13 13:58:53', 19),
(136, '2019-02-13 14:00:47', 43),
(137, '2019-02-13 14:03:07', 19),
(138, '2019-02-14 07:52:23', 40),
(139, '2019-02-14 07:54:08', 19),
(140, '2019-02-14 07:55:45', 40),
(141, '2019-02-14 08:41:46', 42),
(142, '2019-02-18 13:44:53', 41),
(143, '2019-02-20 12:00:09', 41),
(144, '2019-02-20 12:28:49', 40),
(145, '2019-02-21 08:10:22', 40),
(146, '2019-02-21 12:18:38', 40),
(147, '2019-02-21 17:57:29', 40),
(148, '2019-02-22 08:02:17', 40),
(149, '2019-02-22 08:15:48', 19),
(150, '2019-02-22 12:07:26', 40),
(151, '2019-02-25 12:05:14', 40),
(152, '2019-02-26 18:45:42', 40),
(153, '2019-02-27 08:12:29', 40),
(154, '2019-02-27 08:12:39', 19),
(155, '2019-02-27 17:52:01', 40),
(156, '2019-02-28 12:34:04', 40),
(157, '2019-03-06 12:29:09', 40),
(158, '2019-03-07 07:46:08', 40),
(159, '2019-03-07 16:08:12', 19),
(160, '2019-03-12 10:12:04', 41),
(161, '2019-03-19 12:21:36', 40),
(162, '2019-03-23 13:32:04', 40),
(163, '2019-03-23 13:42:54', 40),
(164, '2019-03-26 08:05:42', 40),
(165, '2019-03-29 12:46:27', 40),
(166, '2019-04-01 08:12:40', 40),
(167, '2019-04-01 12:17:34', 40),
(168, '2019-04-02 12:43:42', 40),
(169, '2019-04-02 14:55:25', 40),
(170, '2019-04-03 08:09:17', 40),
(171, '2019-04-03 12:05:09', 40),
(172, '2019-04-03 13:30:30', 40),
(173, '2019-04-03 14:31:24', 40),
(174, '2019-04-04 07:44:27', 40),
(175, '2019-04-04 08:28:21', 40),
(176, '2019-04-05 08:30:37', 40),
(177, '2019-04-08 13:54:13', 40),
(178, '2019-04-09 08:05:40', 40),
(179, '2019-04-09 12:12:21', 40),
(180, '2019-04-14 12:07:12', 40),
(181, '2019-04-14 18:40:31', 40),
(182, '2019-04-14 18:41:12', 19),
(183, '2019-04-18 08:09:23', 19),
(184, '2019-04-18 08:09:46', 43),
(185, '2019-04-19 13:50:14', 40),
(186, '2019-04-19 13:55:46', 19),
(187, '2019-04-19 13:56:08', 43),
(188, '2019-04-19 14:09:47', 19),
(189, '2019-04-19 14:10:09', 43),
(190, '2019-04-20 12:52:14', 40),
(191, '2019-04-20 13:27:54', 40),
(192, '2019-04-20 13:28:38', 19),
(193, '2019-04-21 12:38:37', 40),
(194, '2019-04-21 12:46:45', 43),
(195, '2019-04-22 08:10:30', 40),
(196, '2019-04-22 12:06:20', 41),
(197, '2019-04-22 12:06:44', 41),
(198, '2019-04-22 12:07:22', 40),
(199, '2019-04-22 12:28:11', 40),
(200, '2019-04-22 13:34:41', 40),
(201, '2019-04-22 13:55:13', 43),
(202, '2019-04-22 14:02:34', 19),
(203, '2019-04-22 17:59:08', 40),
(204, '2019-04-23 08:03:56', 40),
(205, '2019-04-23 12:10:40', 40),
(206, '2019-04-24 08:04:42', 40),
(207, '2019-04-24 12:11:32', 40),
(208, '2019-04-24 12:11:32', 40),
(209, '2019-04-25 07:47:03', 40),
(210, '2019-04-25 13:33:01', 40),
(211, '2019-04-26 08:08:51', 41),
(212, '2019-04-26 08:09:00', 40),
(213, '2019-04-26 12:07:53', 40),
(214, '2019-04-29 08:09:47', 40),
(215, '2019-04-29 12:06:18', 40),
(216, '2019-04-30 08:03:12', 40),
(217, '2019-05-06 12:07:04', 40),
(218, '2019-05-06 12:09:26', 40),
(219, '2019-05-06 12:09:33', 19),
(220, '2019-05-07 08:15:27', 40),
(221, '2019-05-07 08:23:32', 40),
(222, '2019-05-07 09:17:35', 19),
(223, '2019-05-07 09:18:52', 40),
(224, '2019-05-07 09:18:59', 19),
(225, '2019-05-07 09:19:22', 40),
(226, '2019-05-07 09:57:46', 40),
(227, '2019-05-07 12:34:32', 40),
(228, '2019-05-08 08:03:21', 40),
(229, '2019-05-08 08:50:25', 43),
(230, '2019-05-08 12:10:19', 43),
(231, '2019-05-08 12:10:27', 40),
(232, '2019-05-08 12:16:55', 40),
(233, '2019-05-09 08:07:50', 40),
(234, '2019-05-09 12:04:50', 40),
(235, '2019-05-10 08:11:07', 40),
(236, '2019-05-10 08:11:07', 40),
(237, '2019-05-10 12:07:02', 40),
(238, '2019-05-10 12:15:37', 19);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
