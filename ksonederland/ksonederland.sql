-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2024 at 01:37 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ksonederland`
--

-- --------------------------------------------------------

--
-- Table structure for table `antworden`
--

CREATE TABLE `antworden` (
  `Gebruiker_id` int(11) NOT NULL,
  `Vraag_id` int(11) NOT NULL,
  `Mogelijke_Antworden_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `categorie_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`categorie_id`, `naam`) VALUES
(1, 'Nieuwbouw '),
(2, 'Verbouw'),
(3, 'Personeelsbeleid');

-- --------------------------------------------------------

--
-- Table structure for table `gebruiker`
--

CREATE TABLE `gebruiker` (
  `Gebruiker_id` int(11) NOT NULL,
  `Bedrijfsnaam` varchar(255) NOT NULL,
  `Voornaam` varchar(255) NOT NULL,
  `Achternaam` varchar(255) NOT NULL,
  `telefoon` varchar(255) NOT NULL,
  `Emailadres` varchar(255) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL,
  `sector` varchar(255) NOT NULL,
  `categorie` int(11) DEFAULT NULL,
  `IsAdmin` int(11) NOT NULL,
  `activated` int(11) NOT NULL,
  `form_submitted` int(11) NOT NULL,
  `extra_vragen` int(11) NOT NULL,
  `activation_date` datetime DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gebruiker`
--

INSERT INTO `gebruiker` (`Gebruiker_id`, `Bedrijfsnaam`, `Voornaam`, `Achternaam`, `telefoon`, `Emailadres`, `Wachtwoord`, `sector`, `categorie`, `IsAdmin`, `activated`, `form_submitted`, `extra_vragen`, `activation_date`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'Baghadai', 'Abdul', 'baghdadi', '0612345678', 'Baghdadi@gmail.com', '$2y$10$Dr3HeFrBUdFsrQq2.MrqzuEgq09zItM7xYexCMOModNOnBog3256.', '0116', 2, 0, 1, 0, 1, '2024-07-11 11:19:51', NULL, NULL),
(2, '', '', '', '', 'admin@gamil.com', '$2y$10$im0gL.MjaHW88yI6o3yq/eZNHNCi6wYtqJ7xBE5K6GJEkCS7ko0Uq', '', NULL, 1, 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mogelijkeantworden`
--

CREATE TABLE `mogelijkeantworden` (
  `Mogelijke_Antworden_id` int(11) NOT NULL,
  `vraag_id` int(11) NOT NULL,
  `Mogelijke_Antworden_tekst` varchar(255) NOT NULL,
  `Mogelijke_Antworden_procent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mogelijkeantworden`
--

INSERT INTO `mogelijkeantworden` (`Mogelijke_Antworden_id`, `vraag_id`, `Mogelijke_Antworden_tekst`, `Mogelijke_Antworden_procent`) VALUES
(1, 1, 'Nee', 0),
(2, 1, 'besproken is in het managementteam', 10),
(3, 1, 'besproken is met belanghebbende afdelingen', 15),
(4, 1, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(5, 1, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(6, 1, 'gedeeld met de stakeholders', 75),
(7, 1, 'besproken en gedeeld in de keten', 85),
(8, 1, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(9, 1, 'besproken en gedeeld met afnemers ( de keten)', 100),
(10, 2, 'Nee', 0),
(11, 2, 'besproken is in het managementteam', 10),
(12, 2, 'besproken is met belanghebbende afdelingen', 15),
(13, 2, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(14, 2, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(15, 2, 'gedeeld met de stakeholders', 75),
(16, 2, 'besproken en gedeeld in de keten', 85),
(17, 2, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(18, 2, 'besproken en gedeeld met afnemers ( de keten)', 100),
(46, 10, 'Nee', 0),
(47, 10, 'besproken is in het managementteam', 10),
(48, 10, 'besproken is met belanghebbende afdelingen', 15),
(49, 10, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(50, 10, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(51, 10, 'gedeeld met de stakeholders', 75),
(52, 10, 'besproken en gedeeld in de keten', 85),
(53, 10, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(54, 10, 'besproken en gedeeld met afnemers ( de keten)', 100),
(64, 14, 'Nee', 0),
(65, 14, 'besproken is in het managementteam', 10),
(66, 14, 'besproken is met belanghebbende afdelingen', 15),
(67, 14, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(68, 14, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(69, 14, 'gedeeld met de stakeholders', 75),
(70, 14, 'besproken en gedeeld in de keten', 85),
(71, 14, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(72, 14, 'besproken en gedeeld met afnemers ( de keten)', 100),
(73, 15, 'Nee', 0),
(74, 15, 'besproken is in het managementteam', 10),
(75, 15, 'besproken is met belanghebbende afdelingen', 15),
(76, 15, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(77, 15, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(78, 15, 'gedeeld met de stakeholders', 75),
(79, 15, 'besproken en gedeeld in de keten', 85),
(80, 15, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(81, 15, 'besproken en gedeeld met afnemers ( de keten)', 100),
(82, 16, 'Nee', 0),
(83, 16, 'besproken is in het managementteam', 10),
(84, 16, 'besproken is met belanghebbende afdelingen', 15),
(85, 16, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(86, 16, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(87, 16, 'gedeeld met de stakeholders', 75),
(88, 16, 'besproken en gedeeld in de keten', 85),
(89, 16, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(90, 16, 'besproken en gedeeld met afnemers ( de keten)', 100),
(91, 17, 'Nee', 0),
(92, 17, 'besproken is in het managementteam', 10),
(93, 17, 'besproken is met belanghebbende afdelingen', 15),
(94, 17, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(95, 17, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(96, 17, 'gedeeld met de stakeholders', 75),
(97, 17, 'besproken en gedeeld in de keten', 85),
(98, 17, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(99, 17, 'besproken en gedeeld met afnemers ( de keten)', 100),
(100, 18, 'Nee', 0),
(101, 18, 'besproken is in het managementteam', 10),
(102, 18, 'besproken is met belanghebbende afdelingen', 15),
(103, 18, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(104, 18, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(105, 18, 'gedeeld met de stakeholders', 75),
(106, 18, 'besproken en gedeeld in de keten', 85),
(107, 18, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(108, 18, 'besproken en gedeeld met afnemers ( de keten)', 100),
(109, 19, 'Nee', 0),
(110, 19, 'besproken is in het managementteam', 10),
(111, 19, 'besproken is met belanghebbende afdelingen', 15),
(112, 19, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(113, 19, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(114, 19, 'gedeeld met de stakeholders', 75),
(115, 19, 'besproken en gedeeld in de keten', 85),
(116, 19, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(117, 19, 'besproken en gedeeld met afnemers ( de keten)', 100),
(118, 20, 'Nee', 0),
(119, 20, 'besproken is in het managementteam', 10),
(120, 20, 'besproken is met belanghebbende afdelingen', 15),
(121, 20, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(122, 20, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(123, 20, 'gedeeld met de stakeholders', 75),
(124, 20, 'besproken en gedeeld in de keten', 85),
(125, 20, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(126, 20, 'besproken en gedeeld met afnemers ( de keten)', 100),
(127, 21, 'Nee', 0),
(128, 21, 'besproken is in het managementteam', 10),
(129, 21, 'besproken is met belanghebbende afdelingen', 15),
(130, 21, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(131, 21, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(132, 21, 'gedeeld met de stakeholders', 75),
(133, 21, 'besproken en gedeeld in de keten', 85),
(134, 21, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(135, 21, 'besproken en gedeeld met afnemers ( de keten)', 100),
(136, 22, 'Nee', 0),
(137, 22, 'besproken is in het managementteam', 10),
(138, 22, 'besproken is met belanghebbende afdelingen', 15),
(139, 22, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(140, 22, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(141, 22, 'gedeeld met de stakeholders', 75),
(142, 22, 'besproken en gedeeld in de keten', 85),
(143, 22, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(144, 22, 'besproken en gedeeld met afnemers ( de keten)', 100),
(145, 23, 'Nee', 0),
(146, 23, 'besproken is in het managementteam', 10),
(147, 23, 'besproken is met belanghebbende afdelingen', 15),
(148, 23, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(149, 23, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(150, 23, 'gedeeld met de stakeholders', 75),
(151, 23, 'besproken en gedeeld in de keten', 85),
(152, 23, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(153, 23, 'besproken en gedeeld met afnemers ( de keten)', 100),
(154, 24, 'Nee', 0),
(155, 24, 'besproken is in het managementteam', 10),
(156, 24, 'besproken is met belanghebbende afdelingen', 15),
(157, 24, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(158, 24, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(159, 24, 'gedeeld met de stakeholders', 75),
(160, 24, 'besproken en gedeeld in de keten', 85),
(161, 24, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(162, 24, 'besproken en gedeeld met afnemers ( de keten)', 100),
(163, 25, 'Nee', 0),
(164, 25, 'besproken is in het managementteam', 10),
(165, 25, 'besproken is met belanghebbende afdelingen', 15),
(166, 25, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(167, 25, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(168, 25, 'gedeeld met de stakeholders', 75),
(169, 25, 'besproken en gedeeld in de keten', 85),
(170, 25, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(171, 25, 'besproken en gedeeld met afnemers ( de keten)', 100),
(172, 26, 'Nee', 0),
(173, 26, 'besproken is in het managementteam', 10),
(174, 26, 'besproken is met belanghebbende afdelingen', 15),
(175, 26, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(176, 26, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(177, 26, 'gedeeld met de stakeholders', 75),
(178, 26, 'besproken en gedeeld in de keten', 85),
(179, 26, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(180, 26, 'besproken en gedeeld met afnemers ( de keten)', 100),
(181, 27, 'Nee', 0),
(182, 27, 'besproken is in het managementteam', 10),
(183, 27, 'besproken is met belanghebbende afdelingen', 15),
(184, 27, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(185, 27, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(186, 27, 'gedeeld met de stakeholders', 75),
(187, 27, 'besproken en gedeeld in de keten', 85),
(188, 27, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(189, 27, 'besproken en gedeeld met afnemers ( de keten)', 100),
(190, 28, 'Nee', 0),
(191, 28, 'besproken is in het managementteam', 10),
(192, 28, 'besproken is met belanghebbende afdelingen', 15),
(193, 28, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(194, 28, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(195, 28, 'gedeeld met de stakeholders', 75),
(196, 28, 'besproken en gedeeld in de keten', 85),
(197, 28, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(198, 28, 'besproken en gedeeld met afnemers ( de keten)', 100),
(199, 29, 'Nee', 0),
(200, 29, 'besproken is in het managementteam', 10),
(201, 29, 'besproken is met belanghebbende afdelingen', 15),
(202, 29, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(203, 29, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(204, 29, 'gedeeld met de stakeholders', 75),
(205, 29, 'besproken en gedeeld in de keten', 85),
(206, 29, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(207, 29, 'besproken en gedeeld met afnemers ( de keten)', 100),
(208, 30, 'Nee', 0),
(209, 30, 'besproken is in het managementteam', 10),
(210, 30, 'besproken is met belanghebbende afdelingen', 15),
(211, 30, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(212, 30, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(213, 30, 'gedeeld met de stakeholders', 75),
(214, 30, 'besproken en gedeeld in de keten', 85),
(215, 30, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(216, 30, 'besproken en gedeeld met afnemers ( de keten)', 100),
(217, 31, 'Nee', 0),
(218, 31, 'besproken is in het managementteam', 10),
(219, 31, 'besproken is met belanghebbende afdelingen', 15),
(220, 31, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(221, 31, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(222, 31, 'gedeeld met de stakeholders', 75),
(223, 31, 'besproken en gedeeld in de keten', 85),
(224, 31, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(225, 31, 'besproken en gedeeld met afnemers ( de keten)', 100),
(226, 32, 'Nee', 0),
(227, 32, 'besproken is in het managementteam', 10),
(228, 32, 'besproken is met belanghebbende afdelingen', 15),
(229, 32, 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', 25),
(230, 32, 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', 50),
(231, 32, 'gedeeld met de stakeholders', 75),
(232, 32, 'besproken en gedeeld in de keten', 85),
(233, 32, 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', 99),
(234, 32, 'besproken en gedeeld met afnemers ( de keten)', 100);

-- --------------------------------------------------------

--
-- Table structure for table `pijlers`
--

CREATE TABLE `pijlers` (
  `pijlers_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pijlers`
--

INSERT INTO `pijlers` (`pijlers_id`, `naam`) VALUES
(1, 'Mens en Arbeidsmarkt'),
(2, 'Mens en Maatschappij'),
(3, 'Mens en Wereld'),
(4, 'extra_vragen');

-- --------------------------------------------------------

--
-- Table structure for table `pijlers_categories`
--

CREATE TABLE `pijlers_categories` (
  `pijlers_categorie_id` int(11) NOT NULL,
  `pijlers_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pijlers_categories`
--

INSERT INTO `pijlers_categories` (`pijlers_categorie_id`, `pijlers_id`, `naam`) VALUES
(1, 1, 'Behoud vakmanschap en\r\narbeidsplaatsen '),
(2, 1, 'Inclusieve\r\narbeidsmarkt beleid\r\n'),
(3, 1, 'Veiligheid op de werkvloer'),
(5, 1, 'Duurzame inzetbaarheid '),
(6, 1, 'Onderwijs eigen personeel '),
(7, 1, 'Balans privé – werk '),
(8, 1, 'Fysieke gesteldheid '),
(9, 1, 'Sociaal netwerk '),
(10, 1, 'ARBO '),
(11, 1, 'Ongewenst gedrag '),
(12, 1, 'Gelijke beloning man – vrouw '),
(16, 4, 'extra vragen gemeente'),
(108, 2, 'Werknemersvrijwilligerswerk/ -beleid '),
(109, 2, 'Mantelzorg  '),
(110, 2, 'Sponsoring in geld of middelen of inzet medewerkers '),
(111, 2, 'Ondersteuning organisaties/activiteiten '),
(112, 2, 'Samenwerking onderwijsinstellingen '),
(113, 2, 'Stageplaatsen beschikbaar stellen '),
(114, 2, 'Aantoonbare betrokkenheid samenleving '),
(115, 3, 'Ketenverantwoordelijkheid '),
(116, 3, 'Circulaire economie '),
(117, 3, 'Milieuvervuiling '),
(118, 3, 'Brandstof en energieverbruik   ');

-- --------------------------------------------------------

--
-- Table structure for table `sbi_code`
--

CREATE TABLE `sbi_code` (
  `id` int(11) NOT NULL,
  `code_id` varchar(255) NOT NULL,
  `omschrijving` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sbi_code`
--

INSERT INTO `sbi_code` (`id`, `code_id`, `omschrijving`) VALUES
(1, '011', 'Teelt van eenjarige gewassen'),
(2, '012', 'Teelt van meerjarige gewassen'),
(3, '013', 'Teelt van sierplanten en –bomen en bloembollen'),
(4, '014', 'Fokken en houden van dieren'),
(5, '015', 'Akker- en/of tuinbouw in combinatie met het fokken en houden van dieren'),
(6, '016', 'Dienstverlening voor de landbouw; behandeling van gewassen na de oogst'),
(7, '017', 'Jacht'),
(8, '021', 'Bosbouw'),
(9, '022', 'Exploitatie van bossen'),
(10, '024', 'Dienstverlening voor de bosbouw'),
(11, '031', 'Visserij'),
(12, '032', 'Kweken van vis en schaaldieren'),
(13, '061', 'Winning van aardolie'),
(14, '062', 'Winning van aardgas'),
(15, '081', 'Winning van zand, grind en klei'),
(16, '089', 'Winning van overige delfstoffen'),
(17, '091', 'Dienstverlening voor de winning van aardolie- en aardgas'),
(18, '099', 'Dienstverlening voor de winning van delfstoffen (geen olie en gas)'),
(19, '101', 'Slachterijen en vleesverwerking'),
(20, '102', 'Visverwerking'),
(21, '103', 'Verwerking van aardappels, groente en fruit'),
(22, '104', 'Vervaardiging van plantaardige en dierlijke oliën en vetten'),
(23, '105', 'Vervaardiging van zuivelproducten'),
(24, '106', 'Vervaardiging van meel'),
(25, '107', 'Vervaardiging van brood, vers banketbakkerswerk en deegwaren'),
(26, '108', 'Vervaardiging van overige voedingsmiddelen'),
(27, '109', 'Vervaardiging van diervoeders'),
(28, '110', 'Vervaardiging van dranken'),
(29, '120', 'Vervaardiging van tabaksproducten'),
(30, '131', 'Bewerken en spinnen van textielvezels'),
(31, '132', 'Weven van textiel'),
(32, '133', 'Textielveredeling'),
(33, '139', 'Vervaardiging van overige textielproducten'),
(34, '141', 'Vervaardiging van kleding (geen bontkleding)'),
(35, '142', 'Vervaardiging van artikelen van bont'),
(36, '143', 'Vervaardiging van gebreide en gehaakte kleding'),
(37, '151', 'Looien en bewerken van leer; vervaardiging van koffers, tassen, zadel- en tuigmakerswerk; bereiden en verven van bont'),
(38, '152', 'Vervaardiging van schoenen'),
(39, '161', 'Primaire houtbewerking en verduurzamen van hout'),
(40, '162', 'Vervaardiging van artikelen van hout, kurk, riet en vlechtwerk (geen meubels)'),
(41, '171', 'Vervaardiging van papierpulp, papier en karton'),
(42, '172', 'Vervaardiging van papier- en kartonwaren'),
(43, '181', 'Drukkerijen en dienstverlening voor drukkerijen'),
(44, '182', 'Reproductie van opgenomen media'),
(45, '191', 'Vervaardiging van cokesovenproducten'),
(46, '192', 'Aardolieverwerking'),
(47, '201', 'Vervaardiging van chemische basisproducten, kunstmeststoffen en stikstofverbindingen en van kunststof en synthetische rubber in primaire vorm'),
(48, '202', 'Vervaardiging van verdelgingsmiddelen en overige landbouwchemicaliën'),
(49, '203', 'Vervaardiging van verf, vernis e.d., drukinkt en mastiek'),
(50, '204', 'Vervaardiging van zeep, wasmiddelen, poets- en reinigingsmiddelen, parfums en cosmetica'),
(51, '205', 'Vervaardiging van overige chemische producten'),
(52, '206', 'Vervaardiging van synthetische en kunstmatige vezels'),
(53, '211', 'Vervaardiging van farmaceutische grondstoffen'),
(54, '212', 'Vervaardiging van farmaceutische producten (geen grondstoffen)'),
(55, '221', 'Vervaardiging van producten van rubber'),
(56, '222', 'Vervaardiging van producten van kunststof'),
(57, '231', 'Vervaardiging van glas en glaswerk'),
(58, '232', 'Vervaardiging van vuurvaste keramische producten'),
(59, '233', 'Vervaardiging van producten van klei voor de bouw'),
(60, '234', 'Vervaardiging van overige keramische producten'),
(61, '235', 'Vervaardiging van cement, kalk en gips'),
(62, '236', 'Vervaardiging van producten van beton, gips en cement'),
(63, '237', 'Natuursteenbewerking'),
(64, '239', 'Vervaardiging van overige niet-metaalhoudende minerale producten'),
(65, '241', 'Vervaardiging van ijzer en staal en van ferrolegeringen'),
(66, '242', 'Vervaardiging van stalen buizen, pijpen, holle profielen en fittings daarvoor'),
(67, '243', 'Overige eerste verwerking van staal'),
(68, '244', 'Vervaardiging van edelmetalen en overige non-ferrometalen'),
(69, '245', 'Gieten van metalen'),
(70, '251', 'Vervaardiging van metalen producten voor de bouw'),
(71, '252', 'Vervaardiging van reservoirs van metaal en van ketels en radiatoren voor centrale verwarming'),
(72, '253', 'Vervaardiging van stoomketels (geen ketels voor centrale verwarming)'),
(73, '254', 'Vervaardiging van wapens en munitie'),
(74, '255', 'Smeden, persen, stampen en profielwalsen van metaal; poedermetallurgie'),
(75, '256', 'Oppervlaktebehandeling en bekleding van metaal; algemene metaalbewerking'),
(76, '257', 'Vervaardiging van scharen, messen en bestek, hang- en sluitwerk en gereedschap'),
(77, '259', 'Vervaardiging van overige producten van metaal'),
(78, '261', 'Vervaardiging van elektronische componenten en printplaten'),
(79, '262', 'Vervaardiging van computers en randapparatuur'),
(80, '263', 'Vervaardiging van communicatieapparatuur'),
(81, '264', 'Vervaardiging van consumentenelektronica'),
(82, '265', 'Vervaardiging van meet-, regel-, navigatie- en controleapparatuur en van uurwerken'),
(83, '266', 'Vervaardiging van bestralingsapparatuur en van elektromedische en elektrotherapeutische apparatuur'),
(84, '267', 'Vervaardiging van optische instrumenten en apparatuur'),
(85, '268', 'Vervaardiging van informatiedragers'),
(86, '271', 'Vervaardiging van elektromotoren, elektrische generatoren en transformatoren en van schakel- en verdeelinrichtingen'),
(87, '272', 'Vervaardiging van batterijen en accumulatoren'),
(88, '273', 'Vervaardiging van elektrische en elektronische kabels en van schakelaars, stekkers, stopcontacten e.d.'),
(89, '274', 'Vervaardiging van elektrische lampen en verlichtingsapparaten'),
(90, '275', 'Vervaardiging van huishoudapparaten'),
(91, '279', 'Vervaardiging van overige elektrische apparatuur'),
(92, '281', 'Vervaardiging van motoren, turbines, pompen, compressoren, appendages en drijfwerkelementen'),
(93, '282', 'Vervaardiging van overige machines en apparaten voor algemeen gebruik'),
(94, '283', 'Vervaardiging van machines en werktuigen voor de land- en bosbouw'),
(95, '284', 'Vervaardiging van gereedschapswerktuigen'),
(96, '289', 'Vervaardiging van overige machines, apparaten en werktuigen voor specifieke doeleinden'),
(97, '291', 'Vervaardiging van auto\'s'),
(98, '292', 'Carrosseriebouw; vervaardiging van aanhangwagens en opleggers'),
(99, '293', 'Vervaardiging van onderdelen en toebehoren voor auto\'s'),
(100, '301', 'Scheepsbouw'),
(101, '302', 'Vervaardiging van rollend spoor- en tramwegmaterieel'),
(102, '303', 'Vervaardiging van vliegtuigen en onderdelen daarvoor'),
(103, '304', 'Vervaardiging van militaire gevechtsvoertuigen'),
(104, '309', 'Vervaardiging van transportmiddelen (rest)'),
(105, '310', 'Vervaardiging van meubels'),
(106, '321', 'Slaan van munten; bewerken van edelstenen en vervaardiging van sieraden'),
(107, '322', 'Vervaardiging van muziekinstrumenten'),
(108, '323', 'Vervaardiging van sportartikelen'),
(109, '324', 'Vervaardiging van spellen en speelgoed'),
(110, '325', 'Vervaardiging van medische instrumenten en hulpmiddelen'),
(111, '329', 'Vervaardiging van overige goederen'),
(112, '331', 'Reparatie van producten van metaal, machines en apparatuur'),
(113, '332', 'Installatie van industriële machines en apparatuur'),
(114, '351', 'Productie van elektriciteit, transmissie en distributie van elektriciteit en aardgas'),
(115, '352', 'Productie van gas'),
(116, '353', 'Productie en distributie van stoom, warm water en gekoelde lucht'),
(117, '360', 'Winning en distributie van water'),
(118, '370', 'Afvalwaterinzameling en -behandeling'),
(119, '381', 'Inzameling van afval'),
(120, '382', 'Behandeling van afval'),
(121, '383', 'Voorbereiding tot recycling'),
(122, '390', 'Sanering en overig afvalbeheer'),
(123, '411', 'Projectontwikkeling'),
(124, '412', 'Algemene burgerlijke en utiliteitsbouw'),
(125, '421', 'Bouw van wegen en spoorwegen'),
(126, '422', 'Bouw van leidingen, telecommunicatie- en elektriciteitsleidingen'),
(127, '429', 'Bouw van overige civieltechnische werken'),
(128, '431', 'Slopen van bouwwerken; voorbereiding van bouwterreinen'),
(129, '432', 'Installatie van bouwbeslag, warm water, verwarming en airconditioning en elektrische installaties'),
(130, '433', 'Afwerking van gebouwen'),
(131, '439', 'Gespecialiseerde werkzaamheden in de bouw'),
(132, '451', 'Handel in en reparatie van auto\'s'),
(133, '452', 'Reparatie en onderhoud van auto\'s (geen reparatie van carrosserieën)'),
(134, '453', 'Handel in en reparatie van auto-onderdelen en -accessoires'),
(135, '454', 'Handel in en reparatie van motorfietsen en onderdelen daarvan'),
(136, '461', 'Commissieveilingen en groothandel (geen auto\'s en motorfietsen)'),
(137, '462', 'Groothandel in landbouwproducten, levend vee, grondstoffen en halffabrikaten'),
(138, '463', 'Groothandel in voedingsmiddelen, dranken en tabak'),
(139, '464', 'Groothandel in consumentenartikelen (geen voedingsmiddelen, dranken en tabak)'),
(140, '465', 'Groothandel in informatie- en communicatietechnologie'),
(141, '466', 'Groothandel in machines, apparaten en toebehoren voor de industrie'),
(142, '467', 'Groothandel in brandstoffen, ertsen, metalen en chemische producten'),
(143, '469', 'Gespecialiseerde groothandel in overige goederen (rest)'),
(144, '471', 'Winkels in non-food artikelen'),
(145, '472', 'Winkels in voedingsmiddelen, dranken en tabak'),
(146, '473', 'Tankstations'),
(147, '474', 'Winkels in informatie- en communicatietechnologie'),
(148, '475', 'Winkels in overige consumentenartikelen (rest)'),
(149, '476', 'Markthandel in non-food artikelen'),
(150, '477', 'Markthandel in voedingsmiddelen, dranken en tabak'),
(151, '478', 'Winkels in consumentenartikelen via internet'),
(152, '479', 'Markthandel in consumentenartikelen'),
(153, '491', 'Personenvervoer per spoor'),
(154, '492', 'Vervoer per trein over lange afstand en overige passagiersvervoer per spoor'),
(155, '493', 'Goederenvervoer per spoor'),
(156, '494', 'Vervoer per bus'),
(157, '495', 'Overig personenvervoer over de weg'),
(158, '496', 'Goederenvervoer over de weg'),
(159, '497', 'Taxivervoer'),
(160, '501', 'Passagiersvaart'),
(161, '502', 'Vervoer over zee en kustvaart'),
(162, '503', 'Binnenvaart'),
(163, '504', 'Goederenvervoer over water'),
(164, '511', 'Luchtvaart'),
(165, '512', 'Luchtvracht'),
(166, '521', 'Opslag'),
(167, '522', 'Dienstverlening voor vervoer over land'),
(168, '523', 'Dienstverlening voor vervoer over water'),
(169, '524', 'Dienstverlening voor vervoer door de lucht'),
(170, '531', 'Postverzorging door universele dienstverlener'),
(171, '532', 'Koeriers'),
(172, '551', 'Hotels, pensions en conferentieoorden'),
(173, '552', 'Jeugdherbergen, recreatiecentra en vakantiebungalows'),
(174, '553', 'Kampeerterreinen'),
(175, '559', 'Overige logiesverstrekking'),
(176, '561', 'Restaurants'),
(177, '562', 'Catering en overige maaltijdverzorging'),
(178, '563', 'Cafés en bars'),
(179, '581', 'Uitgeverijen'),
(180, '582', 'Vervaardiging van computersoftware'),
(181, '591', 'Filmproductie'),
(182, '592', 'Geluidsopnamestudio\'s en uitgeverijen van muziekwerken'),
(183, '601', 'Radio-omroep'),
(184, '602', 'Televisie-omroep'),
(185, '611', 'Diensten in verband met de telecommunicatie'),
(186, '612', 'Telecommunicatiediensten'),
(187, '613', 'Telecombedrijven'),
(188, '619', 'Telecommunicatie'),
(189, '621', 'Praktijken van huisartsen en verloskundigen'),
(190, '622', 'Tandartsen'),
(191, '623', 'Alternatieve geneeswijzen'),
(192, '624', 'Paramedische praktijken en alternatieve genezers'),
(193, '631', 'Dataverwerking, webhosting en aanverwante activiteiten'),
(194, '639', 'Overige informatievoorziening'),
(195, '641', 'Monetaire instellingen'),
(196, '642', 'Beleggingsinstellingen en vennootschappen'),
(197, '643', 'Beleggingsinstellingen en beheermaatschappijen'),
(198, '649', 'Overige kredietverstrekking'),
(199, '651', 'Verzekeringen'),
(200, '652', 'Herverzekeringen'),
(201, '653', 'Pensioenfondsen'),
(202, '661', 'Diensten voor de financiële bemiddeling'),
(203, '662', 'Diensten in verband met verzekeringen en pensioenfondsen; schade-experts en experts in schadebeperking'),
(204, '663', 'Beheer van pensioenfondsen'),
(205, '681', 'Verhuur van onroerend goed'),
(206, '682', 'Verhuur van woonruimte'),
(207, '683', 'Makelaarskantoren in onroerend goed'),
(208, '691', 'Rechtskundige diensten'),
(209, '692', 'Belastingadvies en accountantskantoren'),
(210, '701', 'Holdingbedrijven'),
(211, '702', 'Adviesbureaus voor bedrijfsvoering en public relations'),
(212, '711', 'Architecten- en ingenieursbureaus; technische onderzoek en adviesbureaus'),
(213, '712', 'Ingenieursbureaus'),
(214, '721', 'Onderzoek en ontwikkeling op het gebied van de natuurwetenschappen en techniek'),
(215, '722', 'Onderzoek en ontwikkeling op het gebied van de maatschappelijke en geesteswetenschappen'),
(216, '731', 'Reclamebureaus en markt- en opinieonderzoekbureaus'),
(217, '732', 'Markt- en opinieonderzoekbureaus'),
(218, '741', 'Specialistische ontwerpactiviteiten'),
(219, '742', 'Fotografie'),
(220, '743', 'Vertalers, tolken en overige specialistische dienstverlening'),
(221, '749', 'Overige zakelijke dienstverlening (rest)'),
(222, '751', 'Openbaar bestuur'),
(223, '752', 'Rechtspraak en wetgeving'),
(224, '753', 'Defensie'),
(225, '754', 'Overheidsadministratie en overheidsdiensten'),
(226, '755', 'Openbaar bestuur en overheidsdiensten'),
(227, '771', 'Verhuur van auto\'s en lichte bedrijfswagens'),
(228, '772', 'Verhuur van overige consumentenartikelen'),
(229, '773', 'Verhuur van overige machines en werktuigen en van overige goederen'),
(230, '774', 'Leasing van niet-financiële goederen'),
(231, '781', 'Uitzendbureaus'),
(232, '782', 'Bemiddeling bij arbeidsmarktvraagstukken'),
(233, '783', 'Overige arbeidsbemiddeling'),
(234, '791', 'Reisorganisatie en reisbureaus'),
(235, '799', 'Overige reisorganisatie'),
(236, '801', 'Beveiliging'),
(237, '802', 'Privédetective- en recherchebureaus'),
(238, '803', 'Verkeerscontrole en beveiliging'),
(239, '811', 'Dienstverlening voor gebouwen'),
(240, '812', 'Schoonmaakbedrijven'),
(241, '813', 'Landschapsverzorging'),
(242, '821', 'Administratiekantoren'),
(243, '822', 'Incassobureaus en kredietinformatie'),
(244, '823', 'Markt- en opinieonderzoek'),
(245, '829', 'Overige zakelijke dienstverlening'),
(246, '841', 'Openbaar bestuur'),
(247, '842', 'Internationale organisaties en extraterritoriale instituties'),
(248, '851', 'Onderwijs'),
(249, '852', 'Primair onderwijs'),
(250, '853', 'Voortgezet onderwijs'),
(251, '854', 'Middelbaar beroepsonderwijs'),
(252, '855', 'Volwassenen- en ander onderwijs'),
(253, '861', 'Ziekenhuizen'),
(254, '862', 'Praktijken van medisch specialisten en verloskundigen'),
(255, '863', 'Verpleging, verzorging en thuiszorg'),
(256, '871', 'Verzorgingshuizen'),
(257, '872', 'Verpleeghuizen'),
(258, '873', 'Geestelijke gezondheidszorg en verslavingszorg met overnachting'),
(259, '879', 'Overige (intramurale) maatschappelijke dienstverlening n.e.g.'),
(260, '881', 'Maatschappelijk werk voor ouderen en gehandicapten'),
(261, '889', 'Overige maatschappelijke dienstverlening'),
(262, '900', 'Creatieve, kunstzinnige en culturele activiteiten'),
(263, '910', 'Openbaar bestuur'),
(264, '920', 'Gokken en wedden'),
(265, '931', 'Sportactiviteiten'),
(266, '932', 'Overige recreatie'),
(267, '941', 'Activiteiten van ledengroepen en verenigingen'),
(268, '949', 'Overige ledengroepen en verenigingen'),
(269, '951', 'Reparatie van computers en consumentenartikelen'),
(270, '952', 'Reparatie van huishoudelijke artikelen'),
(271, '960', 'Overige persoonlijke dienstverlening'),
(272, '970', 'Huishoudens als werkgever van huishoudelijk personeel'),
(273, '981', 'Extaraterritoriale organisaties en instellingen'),
(274, '990', 'Internationale organisaties en organen');

-- --------------------------------------------------------

--
-- Table structure for table `vraag_sbi_code_id`
--

CREATE TABLE `vraag_sbi_code_id` (
  `_id` int(11) NOT NULL,
  `Vraag_id` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `pijlers_categorie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vraag_sbi_code_id`
--

INSERT INTO `vraag_sbi_code_id` (`_id`, `Vraag_id`, `id`, `categorie_id`, `pijlers_categorie_id`) VALUES
(1, 1, NULL, NULL, 1),
(2, 2, NULL, NULL, 2),
(6, 10, NULL, NULL, 3),
(9, 14, NULL, NULL, 6),
(10, 15, NULL, NULL, 5),
(11, 16, NULL, NULL, 7),
(12, 17, NULL, NULL, 8),
(13, 18, NULL, NULL, 9),
(14, 19, NULL, NULL, 10),
(15, 20, NULL, NULL, 11),
(16, 21, NULL, NULL, 12),
(17, 22, NULL, NULL, 108),
(18, 23, NULL, NULL, 109),
(19, 24, NULL, NULL, 110),
(20, 25, NULL, NULL, 111),
(21, 26, NULL, NULL, 112),
(24, 27, NULL, NULL, 113),
(25, 28, NULL, NULL, 114),
(26, 29, NULL, NULL, 115),
(27, 30, NULL, NULL, 116),
(28, 31, NULL, NULL, 117),
(29, 32, NULL, NULL, 118);

-- --------------------------------------------------------

--
-- Table structure for table `vragen`
--

CREATE TABLE `vragen` (
  `Vraag_id` int(11) NOT NULL,
  `Vraag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vragen`
--

INSERT INTO `vragen` (`Vraag_id`, `Vraag`) VALUES
(1, 'Het bedrijf zet zich aantoonbaar in voor behoud van vakmanschap en arbeidsplaatsen voor bestaande en toekomstige medewerkers.'),
(2, 'Kansen bieden aan / in dienst nemen van mensen met een afstand tot de arbeidsmarkt, jobcarving, diversiteit, jobcreating ...'),
(10, 'Het bedrijf neemt aantoonbare maatregelen om de veiligheid op de werkvloer te vergroten, en kan over een periode van een jaar aantonen dat de veiligheid is verbeterd.'),
(14, 'Het bedrijf biedt een gedocumenteerd en gemonitord opleidingstraject aan voor alle werknemers in het bedrijf. '),
(15, 'Het bedrijf heeft naast een opleidingstraject een carrièreplanning met heldere doelstellingen voor iedere werknemer. '),
(16, 'Het bedrijf heeft een gedocumenteerd beleid op een gezonde balans tussen werk en privé. dit kan door duidelijke grenzen aan overwerk (zijnde strenger dan de industriële norm), of door ingebouwde flexibiliteit in de werkuren. '),
(17, 'Het bedrijf stimuleert de werknemers om gezond te eten, en aan voldoende beweging te komen. '),
(18, 'Het bedrijf heeft een beleid dat stimuleert dat collega\'s elkaar kunnen ontmoeten om de betrokkenheid bij elkaar, het werk en de organisatie te bevorderen'),
(19, 'Het bedrijf heeft een beleid dat stimuleert dat collega\'s elkaar kunnen ontmoeten om de betrokkenheid bij elkaar, het werk en de organisatie te bevorderen'),
(20, 'Binnen het bedrijf is vastgelegd wat ongewenst gedrag is (bv: pesten, seksuele intimidatie, discriminatie, etc.), en:   dit ongewenste gedrag wordt tegengegaan ;   en de effectiviteit van dit beleid wordt geëvalueerd '),
(21, 'Aantoonbaar (bijv. in cao) afgesproken gelijke behandeling en beloning van mannen en vrouw'),
(22, 'Het betreft hier werkzaamheden/projecten die door de werkgever worden geïnitieerd/ondersteund met uren of middelen en er sprake is van toegevoegde waarde voor de samenleving. '),
(23, 'Oog hebben voor:   a) de belasting van mantelzorg op de inzetbaarheid van werknemers   b) het in kaart brengen van de gevolgen van de inzetbaarheid op de organisatie '),
(24, 'a) Het ondersteunen met financiële middelen  b) vergroten van de maatschappelijke waarde. '),
(25, 'Het om niet beschikbaar stellen van de kennis, kunde en evt. middelen om een maatschappelijk rendement te bewerkstelligen. '),
(26, 'De mensen en middelen van het bedrijf inzetten binnen een onderwijsinstelling teneinde het onderwijs af te stemmen op de behoefte  van het bedrijfsleven. '),
(27, 'Bieden van de mogelijkheid voor studenten om specifieke werkervaring op te doen binnen het bedrijf. '),
(28, 'Structurele betrokkenheid bij/op de maatschappij is een integraal onderdeel van de bedrijfsvoering/strategische planning. '),
(29, 'Het bedrijf legt een beleid vast t.a.v. duurzame inkoopprocessen. Dit beleid moet objectieve meetmiddelen en doelstellingen hebben. \r\n\r\n   Inkoopproces koppelen aan inkoop uit 26000 \r\n\r\n \r\n\r\nHet bedrijf legt een beleid vast t.a.v. duurzame inkoopprocessen'),
(30, 'Het bedrijf moet aantoonbaar zich ingespannen hebben om grondstoffen zo duurzaam mogelijk in te zetten door te kijken naar recycling van afvalstoffen - zowel binnen het bedrijf als bij leveranciers  '),
(31, ' Het bedrijf ontwikkelt targets voor zichzelf om milieuvervuiling te verminderen. Dit beleidsstuk is  \r\n\r\n   SMART opgezet. '),
(32, 'Het bedrijf heeft meetbare en herleidbare targets voor het terugdringen van brandstof- en energieverbruik.  ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antworden`
--
ALTER TABLE `antworden`
  ADD KEY `Gebruiker_id` (`Gebruiker_id`),
  ADD KEY `Mogelijke_Antworden_id` (`Mogelijke_Antworden_id`),
  ADD KEY `Vraag_id` (`Vraag_id`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorie_id`);

--
-- Indexes for table `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`Gebruiker_id`),
  ADD KEY `categorie` (`categorie`);

--
-- Indexes for table `mogelijkeantworden`
--
ALTER TABLE `mogelijkeantworden`
  ADD PRIMARY KEY (`Mogelijke_Antworden_id`),
  ADD KEY `vraag_id` (`vraag_id`);

--
-- Indexes for table `pijlers`
--
ALTER TABLE `pijlers`
  ADD PRIMARY KEY (`pijlers_id`);

--
-- Indexes for table `pijlers_categories`
--
ALTER TABLE `pijlers_categories`
  ADD PRIMARY KEY (`pijlers_categorie_id`),
  ADD KEY `pijlers_id` (`pijlers_id`);

--
-- Indexes for table `sbi_code`
--
ALTER TABLE `sbi_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vraag_sbi_code_id`
--
ALTER TABLE `vraag_sbi_code_id`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `Vraag_id` (`Vraag_id`),
  ADD KEY `id` (`id`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `pijlers_categorie_id` (`pijlers_categorie_id`);

--
-- Indexes for table `vragen`
--
ALTER TABLE `vragen`
  ADD PRIMARY KEY (`Vraag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `Gebruiker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mogelijkeantworden`
--
ALTER TABLE `mogelijkeantworden`
  MODIFY `Mogelijke_Antworden_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `pijlers`
--
ALTER TABLE `pijlers`
  MODIFY `pijlers_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pijlers_categories`
--
ALTER TABLE `pijlers_categories`
  MODIFY `pijlers_categorie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `sbi_code`
--
ALTER TABLE `sbi_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT for table `vraag_sbi_code_id`
--
ALTER TABLE `vraag_sbi_code_id`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `vragen`
--
ALTER TABLE `vragen`
  MODIFY `Vraag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antworden`
--
ALTER TABLE `antworden`
  ADD CONSTRAINT `antworden_ibfk_1` FOREIGN KEY (`Gebruiker_id`) REFERENCES `gebruiker` (`Gebruiker_id`),
  ADD CONSTRAINT `antworden_ibfk_2` FOREIGN KEY (`Mogelijke_Antworden_id`) REFERENCES `mogelijkeantworden` (`Mogelijke_Antworden_id`),
  ADD CONSTRAINT `antworden_ibfk_3` FOREIGN KEY (`Vraag_id`) REFERENCES `vragen` (`Vraag_id`);

--
-- Constraints for table `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD CONSTRAINT `gebruiker_ibfk_1` FOREIGN KEY (`categorie`) REFERENCES `categorie` (`categorie_id`);

--
-- Constraints for table `mogelijkeantworden`
--
ALTER TABLE `mogelijkeantworden`
  ADD CONSTRAINT `mogelijkeantworden_ibfk_1` FOREIGN KEY (`vraag_id`) REFERENCES `vragen` (`Vraag_id`);

--
-- Constraints for table `pijlers_categories`
--
ALTER TABLE `pijlers_categories`
  ADD CONSTRAINT `pijlers_categories_ibfk_1` FOREIGN KEY (`pijlers_id`) REFERENCES `pijlers` (`pijlers_id`);

--
-- Constraints for table `vraag_sbi_code_id`
--
ALTER TABLE `vraag_sbi_code_id`
  ADD CONSTRAINT `vraag_sbi_code_id_ibfk_1` FOREIGN KEY (`Vraag_id`) REFERENCES `vragen` (`Vraag_id`),
  ADD CONSTRAINT `vraag_sbi_code_id_ibfk_2` FOREIGN KEY (`id`) REFERENCES `sbi_code` (`id`),
  ADD CONSTRAINT `vraag_sbi_code_id_ibfk_3` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`categorie_id`),
  ADD CONSTRAINT `vraag_sbi_code_id_ibfk_4` FOREIGN KEY (`pijlers_categorie_id`) REFERENCES `pijlers_categories` (`pijlers_categorie_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
