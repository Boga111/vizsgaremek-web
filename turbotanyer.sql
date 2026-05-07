-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Ápr 13. 22:26
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `turbotanyer`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `alkalm_felhasz`
--

CREATE TABLE `alkalm_felhasz` (
  `felhaszn_id` int(11) NOT NULL,
  `asztalszam` varchar(2) DEFAULT NULL,
  `felhasznalok` enum('pincer','konyha','helyfoglalas') NOT NULL,
  `pin` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `alkalm_felhasz`
--

INSERT INTO `alkalm_felhasz` (`felhaszn_id`, `asztalszam`, `felhasznalok`, `pin`) VALUES
(1, NULL, 'pincer', 2266),
(2, NULL, 'konyha', 3399),
(3, NULL, 'helyfoglalas', 1155);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `asztalok`
--

CREATE TABLE `asztalok` (
  `asztalszam` varchar(2) NOT NULL,
  `fo_db` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `asztalok`
--

INSERT INTO `asztalok` (`asztalszam`, `fo_db`) VALUES
('A1', 2),
('A2', 2),
('A3', 2),
('A4', 2),
('A5', 2),
('B1', 4),
('B2', 4),
('B3', 4),
('B4', 4),
('B5', 4),
('C1', 6),
('C2', 6),
('C3', 6),
('C4', 6),
('C5', 6),
('D1', 8),
('D2', 8),
('D3', 8),
('D4', 8),
('D5', 8),
('E1', 10),
('E2', 10),
('E3', 10),
('E4', 10),
('E5', 10);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `etlap`
--

CREATE TABLE `etlap` (
  `termek_nev` varchar(50) NOT NULL,
  `tipus` varchar(20) NOT NULL,
  `netto_egyseg_ar` int(11) NOT NULL,
  `afa_kulcs` int(11) NOT NULL,
  `akcio_szazalek` int(11) DEFAULT 0,
  `mennyisegi_egyseg` varchar(20) NOT NULL,
  `kep` varchar(100) DEFAULT NULL,
  `leiras` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `etlap`
--

INSERT INTO `etlap` (`termek_nev`, `tipus`, `netto_egyseg_ar`, `afa_kulcs`, `akcio_szazalek`, `mennyisegi_egyseg`, `kep`, `leiras`) VALUES
('Almalé', 'Ital', 850, 27, 0, '0.3l', NULL, '100%-os almalé.'),
('Almapaprika', 'Savanyúság', 700, 27, 0, 'adag', NULL, 'Savanyított almapaprika.'),
('Aranygaluska', 'Desszert', 1700, 27, 0, 'adag', NULL, 'Diós aranygaluska vaníliasodóval.'),
('Ásványvíz', 'Ital', 500, 27, 0, '0.5l', NULL, 'Szénsavas vagy szénsavmentes ásványvíz.'),
('Barackpálinka', 'Szeszes ital', 1200, 27, 0, '4cl', NULL, 'Érett barackból készült pálinka.'),
('BBQ oldalas', 'Főétel', 4300, 27, 0, 'adag', NULL, 'Füstös BBQ szósszal sült sertés oldalas.'),
('Bécsi szelet', 'Főétel', 3500, 27, 0, 'adag', NULL, 'Hagyományos bécsi szelet citrommal és körettel.'),
('Brassói aprópecsenye', 'Főétel', 3400, 27, 0, 'adag', NULL, 'Fokhagymás sertéshús sült burgonyával.'),
('Brownie', 'Desszert', 1800, 27, 0, 'adag', NULL, 'Csokoládés brownie vaníliafagylalttal.'),
('Bruschetta', 'Előétel', 1800, 27, 0, 'adag', NULL, 'Pirított kenyér paradicsomos-fokhagymás feltéttel és olívaolajjal.'),
('Caprese saláta', 'Előétel', 2300, 27, 0, 'adag', NULL, 'Friss mozzarella, paradicsom és bazsalikom olívaolajjal.'),
('Cheesecake', 'Desszert', 1900, 27, 0, 'szelet', NULL, 'Krémes sajttorta gyümölcsöntettel.'),
('Coca-Cola', 'Ital', 700, 27, 0, '0.33l', NULL, 'Szénsavas üdítőital.'),
('Csalamádé', 'Savanyúság', 700, 27, 0, 'adag', NULL, 'Vegyes káposztás savanyúság.'),
('Csapolt sör', 'Szeszes ital', 800, 27, 0, '0.5l', NULL, 'Friss csapolt világos sör.'),
('Csemege uborka', 'Savanyúság', 700, 27, 0, 'adag', NULL, 'Édeskés savanyított uborka.'),
('Csirkepaprikás', 'Főétel', 3200, 27, 0, 'adag', NULL, 'Tejfölös csirkepaprikás friss galuskával tálalva.'),
('Csülök pékné módra', 'Magyar különlegesség', 4200, 27, 0, 'adag', NULL, 'Ropogós csülök sült burgonyával és hagymával.'),
('Dödölle', 'Magyar különlegesség', 1800, 27, 0, 'adag', NULL, 'Zalai burgonyás dödölle pirított hagymával.'),
('Dreher', 'Szeszes ital', 750, 27, 0, '0.5l', NULL, 'Dreher világos sör.'),
('Ecetes paprika', 'Savanyúság', 700, 27, 0, 'adag', NULL, 'Savanyított paprika.'),
('Egri Bikavér', 'Szeszes ital', 1100, 27, 0, '0.1l', NULL, 'Híres magyar vörösbor.'),
('Fagylaltkehely', 'Desszert', 1600, 27, 0, 'adag', NULL, 'Gyümölcsös fagylaltkehely tejszínhabbal.'),
('Fanta', 'Ital', 700, 27, 0, '0.33l', NULL, 'Narancs ízű szénsavas üdítőital.'),
('Galuska', 'Köret', 800, 27, 0, 'adag', NULL, 'Házi készítésű galuska.'),
('Gin', 'Szeszes ital', 1300, 27, 0, '4cl', NULL, 'Borókás ízű prémium gin.'),
('Grillezett csirkemell', 'Főétel', 3300, 27, 0, 'adag', NULL, 'Fűszeres grillezett csirkemell körettel.'),
('Grillezett lazac', 'Főétel', 4600, 27, 0, 'adag', NULL, 'Frissen grillezett lazac párolt zöldségekkel.'),
('Grillezett zöldség', 'Köret', 1200, 27, 0, 'adag', NULL, 'Frissen grillezett vegyes zöldségek.'),
('Guinness', 'Szeszes ital', 1200, 27, 0, '0.5l', NULL, 'Ír barna sör krémes habbal.'),
('Gulyásleves', 'Leves', 1800, 27, 0, 'adag', NULL, 'Hagyományos magyar gulyásleves marhahússal és csipetkével.'),
('Gyros tál', 'Főétel', 2800, 27, 0, 'adag', NULL, 'Fűszeres gyros hús hasábburgonyával és salátával.'),
('Halászlé', 'Leves', 3500, 27, 0, 'adag', NULL, 'Pontyból készült csípős magyar halászlé.'),
('Hamburger', 'Főétel', 2500, 27, 0, 'db', NULL, 'Friss zsemlében tálalt marhahúsos hamburger zöldségekkel.'),
('Harcsapaprikás', 'Magyar különlegesség', 4200, 27, 0, 'adag', NULL, 'Harcsából készült paprikás túrós csuszával.'),
('Hasábburgonya', 'Köret', 900, 27, 0, 'adag', NULL, 'Ropogósra sült hasábburgonya.'),
('Hideg vegyes tál', 'Előétel', 2600, 27, 0, 'adag', NULL, 'Különböző sajtokból és felvágottakból álló hideg előétel tál.'),
('Hot-dog', 'Főétel', 1500, 27, 0, 'db', NULL, 'Friss kifliben sült virsli mustárral és szósszal.'),
('Húsleves', 'Leves', 1500, 27, 0, 'adag', NULL, 'Gazdag húsleves zöldségekkel és cérnametélttel.'),
('Jeges tea', 'Ital', 900, 27, 0, '0.4l', NULL, 'Barack ízű jeges tea.'),
('Jókai bableves', 'Leves', 1900, 27, 0, 'adag', NULL, 'Gazdag bableves füstölt hússal és kolbásszal.'),
('Káposztasaláta', 'Savanyúság', 700, 27, 0, 'adag', NULL, 'Ecetes káposztasaláta.'),
('Kolozsvári káposzta', 'Magyar különlegesség', 3000, 27, 0, 'adag', NULL, 'Rétegezett káposztás-húsos egytálétel szalonnával.'),
('Korhelyleves', 'Leves', 1750, 27, 0, 'adag', NULL, 'Savanykás káposztaleves kolbásszal és tejföllel.'),
('Körömpörkölt', 'Magyar különlegesség', 3500, 27, 0, 'adag', NULL, 'Fűszeres sertéskörömből készült pörkölt.'),
('Kovászos uborka', 'Savanyúság', 700, 27, 0, 'adag', NULL, 'Házi kovászos uborka friss kaporral.'),
('Lecsós sertésszelet', 'Magyar különlegesség', 3400, 27, 0, 'adag', NULL, 'Sertésszelet lecsós szósszal és tarhonyával.'),
('Libacomb párolt káposztával', 'Magyar különlegesség', 4800, 27, 0, 'adag', NULL, 'Ropogós libacomb párolt lilakáposztával.'),
('Libamájpástétom', 'Előétel', 2200, 27, 0, 'adag', NULL, 'Friss libamájpástétom ropogós pirított kenyérrel tálalva.'),
('Limonádé', 'Ital', 1000, 27, 0, '0.4l', NULL, 'Friss citromos limonádé.'),
('Mákos guba', 'Desszert', 1500, 27, 0, 'adag', NULL, 'Mákos guba vaníliasodóval.'),
('Marhapörkölt galuskával', 'Főétel', 3600, 27, 0, 'adag', NULL, 'Hagyományos magyar marhapörkölt házi galuskával.'),
('Narancslé', 'Ital', 900, 27, 0, '0.3l', NULL, 'Frissen facsart narancslé.'),
('Olaszrizling', 'Szeszes ital', 900, 27, 0, '0.1l', NULL, 'Száraz fehérbor.'),
('Palacsinta', 'Desszert', 1200, 27, 0, 'adag', NULL, 'Töltött palacsinta lekvárral vagy kakaóval.'),
('Palócleves', 'Leves', 1700, 27, 0, 'adag', NULL, 'Tejfölös bárányhúsos leves zöldbabbal.'),
('Paradicsomleves', 'Leves', 1300, 27, 0, 'adag', NULL, 'Klasszikus paradicsomleves betűtésztával.'),
('Párolt rizs', 'Köret', 800, 27, 0, 'adag', NULL, 'Könnyű párolt fehér rizs.'),
('Petrezselymes burgonya', 'Köret', 900, 27, 0, 'adag', NULL, 'Főtt burgonya friss petrezselyemmel.'),
('Rakott krumpli', 'Magyar különlegesség', 2900, 27, 0, 'adag', NULL, 'Krumpliból, tojásból és kolbászból készült rakott étel.'),
('Rántott gomba', 'Előétel', 1800, 27, 0, 'adag', NULL, 'Aranybarnára sült rántott gomba tartármártással tálalva.'),
('Rántott sajt', 'Előétel', 2100, 27, 0, 'adag', NULL, 'Panírozott és sült sajt hasábburgonyával és tartárral.'),
('Rántott sertéskaraj', 'Főétel', 3400, 27, 0, 'adag', NULL, 'Panírozott sertéskaraj hasábburgonyával és citrommal.'),
('Rétes', 'Desszert', 1500, 27, 0, 'adag', NULL, 'Hagyományos almás rétes.'),
('Sajtburger', 'Főétel', 2700, 27, 0, 'db', NULL, 'Hamburger cheddar sajttal és friss zöldségegekkel.'),
('Sajtleves', 'Leves', 1600, 27, 0, 'adag', NULL, 'Krémes sajtból készült leves pirított kenyérkockákkal.'),
('Sajtválogatás', 'Előétel', 2700, 27, 0, 'adag', NULL, 'Többféle hazai és nemzetközi sajtból összeállított tál.'),
('Somlói galuska', 'Desszert', 1600, 27, 0, 'adag', NULL, 'Csokoládés öntettel és tejszínhabbal tálalt somlói galuska.'),
('Sonkatál', 'Előétel', 2400, 27, 0, 'adag', NULL, 'Válogatott sonkákból álló hideg előétel friss zöldségekkel.'),
('Soproni', 'Szeszes ital', 750, 27, 0, '0.5l', NULL, 'Soproni világos sör.'),
('Sprite', 'Ital', 700, 27, 0, '0.33l', NULL, 'Citrom-lime ízű szénsavas üdítőital.'),
('Steak', 'Főétel', 5200, 27, 0, 'adag', NULL, 'Közepesen átsütött marhasteak körettel.'),
('Steak burgonya', 'Köret', 1000, 27, 0, 'adag', NULL, 'Fűszeres steak burgonya ropogósra sütve.'),
('Székelykáposzta', 'Magyar különlegesség', 3100, 27, 0, 'adag', NULL, 'Savanyú káposztás sertéshúsos egytálétel tejföllel.'),
('Szilvapálinka', 'Szeszes ital', 1200, 27, 0, '4cl', NULL, 'Hagyományos magyar szilvapálinka.'),
('Tarhonya', 'Köret', 850, 27, 0, 'adag', NULL, 'Puhára főzött pirított tarhonya.'),
('Tatár beefsteak', 'Előétel', 3200, 27, 0, 'adag', NULL, 'Friss marhahúsból készült tatár beefsteak pirítóssal és fűszerekkel.'),
('Tepertőkrém', 'Előétel', 1500, 27, 0, 'adag', NULL, 'Házi készítésű tepertőkrém friss kenyérrel és lilahagymával.'),
('Tiramisu', 'Desszert', 1900, 27, 0, 'adag', NULL, 'Klasszikus olasz tiramisu mascarponéval.'),
('Tokaji aszú', 'Szeszes ital', 2800, 27, 0, '0.1l', NULL, 'Világhírű édes tokaji bor.'),
('Töltött káposzta', 'Magyar különlegesség', 3300, 27, 0, 'adag', NULL, 'Hagyományos töltött káposzta tejföllel tálalva.'),
('Túrós csusza szalonnával', 'Főétel', 3000, 27, 0, 'adag', NULL, 'Túrós csusza ropogós sült szalonnával.'),
('Újházi tyúkleves', 'Leves', 1600, 27, 0, 'adag', NULL, 'Hagyományos tyúkhúsleves sok zöldséggel és metélttel.'),
('Vegyes savanyúság', 'Savanyúság', 750, 27, 0, 'adag', NULL, 'Különböző savanyított zöldségek keveréke.'),
('Vodka', 'Szeszes ital', 1100, 27, 0, '4cl', NULL, 'Tiszta ízű gabona vodka.'),
('Whisky', 'Szeszes ital', 1500, 27, 0, '4cl', NULL, 'Skót whisky gazdag aromával.'),
('Zöldségleves', 'Leves', 1400, 27, 0, 'adag', NULL, 'Friss zöldségekből készült könnyű leves.'),
('Zsemlegombóc', 'Köret', 900, 27, 0, 'adag', NULL, 'Puha zsemlegombóc mártásokhoz.');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `email` varchar(50) NOT NULL,
  `nev` varchar(50) NOT NULL,
  `jelszo` varchar(255) NOT NULL,
  `jogosultsag` enum('felhasználó','futár','admin') DEFAULT 'felhasználó',
  `futar_jelentkezes` tinyint(1) DEFAULT 0,
  `futar_elfogadva` tinyint(1) DEFAULT 0,
  `tel_szam` varchar(20) NOT NULL,
  `profil_kep` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `helyfoglalas`
--

CREATE TABLE `helyfoglalas` (
  `foglalas_id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `asztalszam` varchar(2) NOT NULL,
  `idopont` datetime NOT NULL,
  `fo_db` int(11) NOT NULL,
  `nev` varchar(50) NOT NULL,
  `allapot` enum('megjött','törölve','folyamatban') DEFAULT 'folyamatban'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `helyfoglalas`
--

INSERT INTO `helyfoglalas` (`foglalas_id`, `email`, `asztalszam`, `idopont`, `fo_db`, `nev`, `allapot`) VALUES
(1, NULL, 'A1', '2026-04-13 18:00:00', 2, 'példa anna', 'megjött'),
(2, NULL, 'A1', '2026-04-13 21:00:00', 2, 'uj ida', 'törölve'),
(3, NULL, 'A2', '2026-04-14 17:50:20', 2, 'gizi néni', 'folyamatban'),
(4, NULL, 'E1', '2026-04-14 12:00:00', 10, 'Uj Ida', 'folyamatban'),
(5, NULL, 'E1', '2026-04-13 18:01:19', 10, 'aegfewag', 'folyamatban'),
(7, NULL, 'B1', '2026-04-13 19:00:00', 3, 'sfdgsg', 'folyamatban'),
(8, NULL, 'B1', '2026-04-13 19:00:00', 3, 'béla bácsi', 'folyamatban');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kosar`
--

CREATE TABLE `kosar` (
  `kosar_id` int(11) NOT NULL,
  `rendeles_id` int(11) NOT NULL,
  `termek_nev` varchar(50) NOT NULL,
  `term_db_szam` int(11) NOT NULL,
  `netto_egyseg_ar` int(11) NOT NULL,
  `afa_kulcs` int(11) DEFAULT 27,
  `kedvezmeny_szazalek` int(11) DEFAULT 0,
  `netto_osszeg` decimal(10,2) GENERATED ALWAYS AS (`netto_egyseg_ar` * `term_db_szam`) STORED,
  `brutto_osszeg` decimal(10,2) GENERATED ALWAYS AS (`netto_osszeg` * (1 + `afa_kulcs` / 100.0)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `kosar`
--

INSERT INTO `kosar` (`kosar_id`, `rendeles_id`, `termek_nev`, `term_db_szam`, `netto_egyseg_ar`, `afa_kulcs`, `kedvezmeny_szazalek`) VALUES
(1, 1, 'Almalé', 2, 850, 27, 0),
(2, 2, 'Brassói aprópecsenye', 1, 3400, 27, 0),
(3, 3, 'Grillezett csirkemell', 2, 3300, 27, 0),
(4, 4, 'Palacsinta', 5, 1200, 27, 0),
(5, 5, 'Almapaprika', 2, 700, 27, 0),
(6, 6, 'Kovászos uborka', 2, 700, 27, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rendeles`
--

CREATE TABLE `rendeles` (
  `rendeles_id` int(11) NOT NULL,
  `rendeles_tipus` enum('WEB','APP') NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `futar_email` varchar(50) DEFAULT NULL,
  `asztalszam` varchar(2) DEFAULT NULL,
  `cim_id` int(11) DEFAULT NULL,
  `rendeles_ido` datetime DEFAULT current_timestamp(),
  `atveteli_ido` datetime DEFAULT NULL,
  `fiz_mod` enum('kezpenz','bankkartya') NOT NULL,
  `allapot` enum('készítés alatt','kész','kiadva','lezárva','uton','kiszallitva') DEFAULT 'készítés alatt',
  `vegosszeg` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `rendeles`
--

INSERT INTO `rendeles` (`rendeles_id`, `rendeles_tipus`, `email`, `futar_email`, `asztalszam`, `cim_id`, `rendeles_ido`, `atveteli_ido`, `fiz_mod`, `allapot`, `vegosszeg`) VALUES
(1, 'APP', NULL, NULL, 'A1', NULL, '2026-04-13 18:19:17', NULL, 'kezpenz', 'lezárva', 1700),
(2, 'APP', NULL, NULL, 'A1', NULL, '2026-04-13 18:19:29', '2026-04-13 19:40:22', 'kezpenz', 'lezárva', 3400),
(3, 'APP', NULL, NULL, 'A1', NULL, '2026-04-13 18:19:37', '2026-04-13 18:41:11', 'kezpenz', 'lezárva', 6600),
(4, 'APP', NULL, NULL, 'A1', NULL, '2026-04-13 18:20:12', '2026-04-13 19:40:37', 'kezpenz', 'lezárva', 6000),
(5, 'APP', NULL, NULL, 'A1', NULL, '2026-04-13 18:34:06', '2026-04-13 18:41:20', 'kezpenz', 'lezárva', 1400),
(6, 'APP', NULL, NULL, 'A1', NULL, '2026-04-13 18:34:30', NULL, 'kezpenz', 'lezárva', 1400);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szallitasi_cim`
--

CREATE TABLE `szallitasi_cim` (
  `cim_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cim` varchar(100) NOT NULL,
  `megjegyzes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szamla`
--

CREATE TABLE `szamla` (
  `szamla_id` int(11) NOT NULL,
  `rendeles_id` int(11) NOT NULL,
  `nev` varchar(100) NOT NULL,
  `cim` varchar(150) NOT NULL,
  `tipus` enum('magan','ceg') NOT NULL,
  `kibocsatas_datuma` datetime DEFAULT current_timestamp(),
  `teljesites_datuma` date DEFAULT curdate(),
  `fiz_mod` enum('kezpenz','kartya') NOT NULL,
  `szla_nev` varchar(3) NOT NULL DEFAULT 'TUT',
  `szla_evszam` int(4) NOT NULL DEFAULT year(curdate()),
  `szla_sorszam` int(6) NOT NULL,
  `szla_teljsorszam` varchar(15) NOT NULL,
  `vegosszeg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `szamla`
--

INSERT INTO `szamla` (`szamla_id`, `rendeles_id`, `nev`, `cim`, `tipus`, `kibocsatas_datuma`, `teljesites_datuma`, `fiz_mod`, `szla_nev`, `szla_evszam`, `szla_sorszam`, `szla_teljsorszam`, `vegosszeg`) VALUES
(1, 2, 'példa anna', '2012, pomáz, boglárka utca, 67', 'magan', '2026-04-13 19:42:58', '2026-04-13', 'kezpenz', 'TUT', 2026, 1, 'TUT/2026/000001', 22968),
(2, 2, 'VoltKatások KFT', '2098, Pilisszentkereszt, Fő út, 76', 'ceg', '2026-04-13 20:05:04', '2026-04-13', 'kartya', 'TUT', 2026, 2, 'TUT/2026/000002', 27060);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `alkalm_felhasz`
--
ALTER TABLE `alkalm_felhasz`
  ADD UNIQUE KEY `felhaszn_id` (`felhaszn_id`),
  ADD UNIQUE KEY `pin` (`pin`),
  ADD KEY `asztalszam` (`asztalszam`);

--
-- A tábla indexei `asztalok`
--
ALTER TABLE `asztalok`
  ADD PRIMARY KEY (`asztalszam`);

--
-- A tábla indexei `etlap`
--
ALTER TABLE `etlap`
  ADD PRIMARY KEY (`termek_nev`);

--
-- A tábla indexei `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`email`);

--
-- A tábla indexei `helyfoglalas`
--
ALTER TABLE `helyfoglalas`
  ADD UNIQUE KEY `foglalas_id` (`foglalas_id`),
  ADD KEY `email` (`email`),
  ADD KEY `asztalszam` (`asztalszam`);

--
-- A tábla indexei `kosar`
--
ALTER TABLE `kosar`
  ADD UNIQUE KEY `kosar_id` (`kosar_id`),
  ADD KEY `rendeles_id` (`rendeles_id`),
  ADD KEY `termek_nev` (`termek_nev`);

--
-- A tábla indexei `rendeles`
--
ALTER TABLE `rendeles`
  ADD UNIQUE KEY `rendeles_id` (`rendeles_id`),
  ADD KEY `email` (`email`),
  ADD KEY `futar_email` (`futar_email`),
  ADD KEY `asztalszam` (`asztalszam`),
  ADD KEY `cim_id` (`cim_id`);

--
-- A tábla indexei `szallitasi_cim`
--
ALTER TABLE `szallitasi_cim`
  ADD PRIMARY KEY (`cim_id`),
  ADD KEY `email` (`email`);

--
-- A tábla indexei `szamla`
--
ALTER TABLE `szamla`
  ADD UNIQUE KEY `szamla_id` (`szamla_id`),
  ADD UNIQUE KEY `szla_sorszam` (`szla_sorszam`),
  ADD UNIQUE KEY `szla_teljsorszam` (`szla_teljsorszam`),
  ADD KEY `rendeles_id` (`rendeles_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `alkalm_felhasz`
--
ALTER TABLE `alkalm_felhasz`
  MODIFY `felhaszn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `helyfoglalas`
--
ALTER TABLE `helyfoglalas`
  MODIFY `foglalas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `kosar`
--
ALTER TABLE `kosar`
  MODIFY `kosar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `rendeles`
--
ALTER TABLE `rendeles`
  MODIFY `rendeles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `szallitasi_cim`
--
ALTER TABLE `szallitasi_cim`
  MODIFY `cim_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `szamla`
--
ALTER TABLE `szamla`
  MODIFY `szamla_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `alkalm_felhasz`
--
ALTER TABLE `alkalm_felhasz`
  ADD CONSTRAINT `alkalm_felhasz_ibfk_1` FOREIGN KEY (`asztalszam`) REFERENCES `asztalok` (`asztalszam`);

--
-- Megkötések a táblához `helyfoglalas`
--
ALTER TABLE `helyfoglalas`
  ADD CONSTRAINT `helyfoglalas_ibfk_1` FOREIGN KEY (`email`) REFERENCES `felhasznalo` (`email`),
  ADD CONSTRAINT `helyfoglalas_ibfk_2` FOREIGN KEY (`asztalszam`) REFERENCES `asztalok` (`asztalszam`);

--
-- Megkötések a táblához `kosar`
--
ALTER TABLE `kosar`
  ADD CONSTRAINT `kosar_ibfk_1` FOREIGN KEY (`rendeles_id`) REFERENCES `rendeles` (`rendeles_id`),
  ADD CONSTRAINT `kosar_ibfk_2` FOREIGN KEY (`termek_nev`) REFERENCES `etlap` (`termek_nev`);

--
-- Megkötések a táblához `rendeles`
--
ALTER TABLE `rendeles`
  ADD CONSTRAINT `rendeles_ibfk_1` FOREIGN KEY (`email`) REFERENCES `felhasznalo` (`email`),
  ADD CONSTRAINT `rendeles_ibfk_2` FOREIGN KEY (`futar_email`) REFERENCES `felhasznalo` (`email`),
  ADD CONSTRAINT `rendeles_ibfk_3` FOREIGN KEY (`asztalszam`) REFERENCES `asztalok` (`asztalszam`),
  ADD CONSTRAINT `rendeles_ibfk_4` FOREIGN KEY (`cim_id`) REFERENCES `szallitasi_cim` (`cim_id`);

--
-- Megkötések a táblához `szallitasi_cim`
--
ALTER TABLE `szallitasi_cim`
  ADD CONSTRAINT `szallitasi_cim_ibfk_1` FOREIGN KEY (`email`) REFERENCES `felhasznalo` (`email`);

--
-- Megkötések a táblához `szamla`
--
ALTER TABLE `szamla`
  ADD CONSTRAINT `szamla_ibfk_1` FOREIGN KEY (`rendeles_id`) REFERENCES `rendeles` (`rendeles_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
