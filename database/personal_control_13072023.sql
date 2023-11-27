/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.27-MariaDB : Database - personal_control
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`personal_control` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `personal_control`;

/*Table structure for table `ciudades` */

DROP TABLE IF EXISTS `ciudades`;

CREATE TABLE `ciudades` (
  `id_ciudad` int(50) NOT NULL DEFAULT 0,
  `id_estado` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ciudades` */

insert  into `ciudades`(`id_ciudad`,`id_estado`,`ciudad`) values 
(1,'1','Alto Orinoco'),
(2,'1','Atabapo'),
(3,'1','Atures'),
(4,'1','Autana'),
(5,'1','Manapiare'),
(6,'1','Maroa'),
(7,'1','Río Negro'),
(8,'2','Anaco'),
(9,'2','Aragua'),
(10,'2','Manuel Ezequiel Bruzual'),
(11,'2','Diego Bautista Urbaneja'),
(12,'2','Fernando Peñalver'),
(13,'2','Francisco Del Carmen Carvajal'),
(14,'2','General Sir Arthur McGregor'),
(15,'2','Guanta'),
(16,'2','Independencia'),
(17,'2','José Gregorio Monagas'),
(18,'2','Juan Antonio Sotillo'),
(19,'2','Juan Manuel Cajigal'),
(20,'2','Libertad'),
(21,'2','Francisco de Miranda'),
(22,'2','Pedro María Freites'),
(23,'2','Píritu'),
(24,'2','San José de Guanipa'),
(25,'2','San Juan de Capistrano'),
(26,'2','Santa Ana'),
(27,'2','Simón Bolívar'),
(28,'2','Simón Rodríguez'),
(29,'3','Achaguas'),
(30,'3','Biruaca'),
(31,'3','Muñóz'),
(32,'3','Páez'),
(33,'3','Pedro Camejo'),
(34,'3','Rómulo Gallegos'),
(35,'3','San Fernando'),
(36,'4','Atanasio Girardot'),
(37,'4','Bolívar'),
(38,'4','Camatagua'),
(39,'4','Francisco Linares Alcántara'),
(40,'4','José Ángel Lamas'),
(41,'4','José Félix Ribas'),
(42,'4','José Rafael Revenga'),
(43,'4','Libertador'),
(44,'4','Mario Briceño Iragorry'),
(45,'4','Ocumare de la Costa de Oro'),
(46,'4','San Casimiro'),
(47,'4','San Sebastián'),
(48,'4','Santiago Mariño'),
(49,'4','Santos Michelena'),
(50,'4','Sucre'),
(51,'4','Tovar'),
(52,'4','Urdaneta'),
(53,'4','Zamora'),
(54,'5','Alberto Arvelo Torrealba'),
(55,'5','Andrés Eloy Blanco'),
(56,'5','Antonio José de Sucre'),
(57,'5','Arismendi'),
(58,'5','Barinas'),
(59,'5','Bolívar'),
(60,'5','Cruz Paredes'),
(61,'5','Ezequiel Zamora'),
(62,'5','Obispos'),
(63,'5','Pedraza'),
(64,'5','Rojas'),
(65,'5','Sosa'),
(66,'6','Caroní'),
(67,'6','Cedeño'),
(68,'6','El Callao'),
(69,'6','Gran Sabana'),
(70,'6','Heres'),
(71,'6','Piar'),
(72,'6','Angostura (Raúl Leoni)'),
(73,'6','Roscio'),
(74,'6','Sifontes'),
(75,'6','Sucre'),
(76,'6','Padre Pedro Chien'),
(77,'7','Bejuma'),
(78,'7','Carlos Arvelo'),
(79,'7','Diego Ibarra'),
(80,'7','Guacara'),
(81,'7','Juan José Mora'),
(82,'7','Libertador'),
(83,'7','Los Guayos'),
(84,'7','Miranda'),
(85,'7','Montalbán'),
(86,'7','Naguanagua'),
(87,'7','Puerto Cabello'),
(88,'7','San Diego'),
(89,'7','San Joaquín'),
(90,'7','Valencia'),
(91,'8','Anzoátegui'),
(92,'8','Tinaquillo'),
(93,'8','Girardot'),
(94,'8','Lima Blanco'),
(95,'8','Pao de San Juan Bautista'),
(96,'8','Ricaurte'),
(97,'8','Rómulo Gallegos'),
(98,'8','San Carlos'),
(99,'8','Tinaco'),
(100,'9','Antonio Díaz'),
(101,'9','Casacoima'),
(102,'9','Pedernales'),
(103,'9','Tucupita'),
(104,'10','Acosta'),
(105,'10','Bolívar'),
(106,'10','Buchivacoa'),
(107,'10','Cacique Manaure'),
(108,'10','Carirubana'),
(109,'10','Colina'),
(110,'10','Dabajuro'),
(111,'10','Democracia'),
(112,'10','Falcón'),
(113,'10','Federación'),
(114,'10','Jacura'),
(115,'10','José Laurencio Silva'),
(116,'10','Los Taques'),
(117,'10','Mauroa'),
(118,'10','Miranda'),
(119,'10','Monseñor Iturriza'),
(120,'10','Palmasola'),
(121,'10','Petit'),
(122,'10','Píritu'),
(123,'10','San Francisco'),
(124,'10','Sucre'),
(125,'10','Tocópero'),
(126,'10','Unión'),
(127,'10','Urumaco'),
(128,'10','Zamora'),
(129,'11','Camaguán'),
(130,'11','Chaguaramas'),
(131,'11','El Socorro'),
(132,'11','José Félix Ribas'),
(133,'11','José Tadeo Monagas'),
(134,'11','Juan Germán Roscio'),
(135,'11','Julián Mellado'),
(136,'11','Las Mercedes'),
(137,'11','Leonardo Infante'),
(138,'11','Pedro Zaraza'),
(139,'11','Ortíz'),
(140,'11','San Gerónimo de Guayabal'),
(141,'11','San José de Guaribe'),
(142,'11','Santa María de Ipire'),
(143,'11','Sebastián Francisco de Miranda'),
(144,'12','Andrés Eloy Blanco'),
(145,'12','Crespo'),
(146,'12','Iribarren'),
(147,'12','Jiménez'),
(148,'12','Morán'),
(149,'12','Palavecino'),
(150,'12','Simón Planas'),
(151,'12','Torres'),
(152,'12','Urdaneta'),
(179,'13','Alberto Adriani'),
(180,'13','Andrés Bello'),
(181,'13','Antonio Pinto Salinas'),
(182,'13','Aricagua'),
(183,'13','Arzobispo Chacón'),
(184,'13','Campo Elías'),
(185,'13','Caracciolo Parra Olmedo'),
(186,'13','Cardenal Quintero'),
(187,'13','Guaraque'),
(188,'13','Julio César Salas'),
(189,'13','Justo Briceño'),
(190,'13','Libertador'),
(191,'13','Miranda'),
(192,'13','Obispo Ramos de Lora'),
(193,'13','Padre Noguera'),
(194,'13','Pueblo Llano'),
(195,'13','Rangel'),
(196,'13','Rivas Dávila'),
(197,'13','Santos Marquina'),
(198,'13','Sucre'),
(199,'13','Tovar'),
(200,'13','Tulio Febres Cordero'),
(201,'13','Zea'),
(223,'14','Acevedo'),
(224,'14','Andrés Bello'),
(225,'14','Baruta'),
(226,'14','Brión'),
(227,'14','Buroz'),
(228,'14','Carrizal'),
(229,'14','Chacao'),
(230,'14','Cristóbal Rojas'),
(231,'14','El Hatillo'),
(232,'14','Guaicaipuro'),
(233,'14','Independencia'),
(234,'14','Lander'),
(235,'14','Los Salias'),
(236,'14','Páez'),
(237,'14','Paz Castillo'),
(238,'14','Pedro Gual'),
(239,'14','Plaza'),
(240,'14','Simón Bolívar'),
(241,'14','Sucre'),
(242,'14','Urdaneta'),
(243,'14','Zamora'),
(258,'15','Acosta'),
(259,'15','Aguasay'),
(260,'15','Bolívar'),
(261,'15','Caripe'),
(262,'15','Cedeño'),
(263,'15','Ezequiel Zamora'),
(264,'15','Libertador'),
(265,'15','Maturín'),
(266,'15','Piar'),
(267,'15','Punceres'),
(268,'15','Santa Bárbara'),
(269,'15','Sotillo'),
(270,'15','Uracoa'),
(271,'16','Antolín del Campo'),
(272,'16','Arismendi'),
(273,'16','García'),
(274,'16','Gómez'),
(275,'16','Maneiro'),
(276,'16','Marcano'),
(277,'16','Mariño'),
(278,'16','Península de Macanao'),
(279,'16','Tubores'),
(280,'16','Villalba'),
(281,'16','Díaz'),
(282,'17','Agua Blanca'),
(283,'17','Araure'),
(284,'17','Esteller'),
(285,'17','Guanare'),
(286,'17','Guanarito'),
(287,'17','Monseñor José Vicente de Unda'),
(288,'17','Ospino'),
(289,'17','Páez'),
(290,'17','Papelón'),
(291,'17','San Genaro de Boconoíto'),
(292,'17','San Rafael de Onoto'),
(293,'17','Santa Rosalía'),
(294,'17','Sucre'),
(295,'17','Turén'),
(296,'18','Andrés Eloy Blanco'),
(297,'18','Andrés Mata'),
(298,'18','Arismendi'),
(299,'18','Benítez'),
(300,'18','Bermúdez'),
(301,'18','Bolívar'),
(302,'18','Cajigal'),
(303,'18','Cruz Salmerón Acosta'),
(304,'18','Libertador'),
(305,'18','Mariño'),
(306,'18','Mejía'),
(307,'18','Montes'),
(308,'18','Ribero'),
(309,'18','Sucre'),
(310,'18','Valdéz'),
(341,'19','Andrés Bello'),
(342,'19','Antonio Rómulo Costa'),
(343,'19','Ayacucho'),
(344,'19','Bolívar'),
(345,'19','Cárdenas'),
(346,'19','Córdoba'),
(347,'19','Fernández Feo'),
(348,'19','Francisco de Miranda'),
(349,'19','García de Hevia'),
(350,'19','Guásimos'),
(351,'19','Independencia'),
(352,'19','Jáuregui'),
(353,'19','José María Vargas'),
(354,'19','Junín'),
(355,'19','Libertad'),
(356,'19','Libertador'),
(357,'19','Lobatera'),
(358,'19','Michelena'),
(359,'19','Panamericano'),
(360,'19','Pedro María Ureña'),
(361,'19','Rafael Urdaneta'),
(362,'19','Samuel Darío Maldonado'),
(363,'19','San Cristóbal'),
(364,'19','Seboruco'),
(365,'19','Simón Rodríguez'),
(366,'19','Sucre'),
(367,'19','Torbes'),
(368,'19','Uribante'),
(369,'19','San Judas Tadeo'),
(370,'20','Andrés Bello'),
(371,'20','Boconó'),
(372,'20','Bolívar'),
(373,'20','Candelaria'),
(374,'20','Carache'),
(375,'20','Escuque'),
(376,'20','José Felipe Márquez Cañizalez'),
(377,'20','Juan Vicente Campos Elías'),
(378,'20','La Ceiba'),
(379,'20','Miranda'),
(380,'20','Monte Carmelo'),
(381,'20','Motatán'),
(382,'20','Pampán'),
(383,'20','Pampanito'),
(384,'20','Rafael Rangel'),
(385,'20','San Rafael de Carvajal'),
(386,'20','Sucre'),
(387,'20','Trujillo'),
(388,'20','Urdaneta'),
(389,'20','Valera'),
(390,'21','Vargas'),
(391,'22','Arístides Bastidas'),
(392,'22','Bolívar'),
(407,'22','Bruzual'),
(408,'22','Cocorote'),
(409,'22','Independencia'),
(410,'22','José Antonio Páez'),
(411,'22','La Trinidad'),
(412,'22','Manuel Monge'),
(413,'22','Nirgua'),
(414,'22','Peña'),
(415,'22','San Felipe'),
(416,'22','Sucre'),
(417,'22','Urachiche'),
(418,'22','José Joaquín Veroes'),
(441,'23','Almirante Padilla'),
(442,'23','Baralt'),
(443,'23','Cabimas'),
(444,'23','Catatumbo'),
(445,'23','Colón'),
(446,'23','Francisco Javier Pulgar'),
(447,'23','Páez'),
(448,'23','Jesús Enrique Losada'),
(449,'23','Jesús María Semprún'),
(450,'23','La Cañada de Urdaneta'),
(451,'23','Lagunillas'),
(452,'23','Machiques de Perijá'),
(453,'23','Mara'),
(454,'23','Maracaibo'),
(455,'23','Miranda'),
(456,'23','Rosario de Perijá'),
(457,'23','San Francisco'),
(458,'23','Santa Rita'),
(459,'23','Simón Bolívar'),
(460,'23','Sucre'),
(461,'23','Valmore Rodríguez'),
(462,'24','Libertador');

/*Table structure for table `datos_abae` */

DROP TABLE IF EXISTS `datos_abae`;

CREATE TABLE `datos_abae` (
  `id_datos_abae` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_unidad` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `cargo` varchar(50) NOT NULL,
  `correo_abae` varchar(100) NOT NULL,
  `nombres_familiares_abae` varchar(200) NOT NULL DEFAULT 'N/A',
  `estatus` varchar(10) DEFAULT NULL,
  `fecha_inicio_administracion` date DEFAULT NULL,
  `id_direccion` int(30) NOT NULL DEFAULT 0,
  `tlf_oficina` varchar(40) NOT NULL DEFAULT '00000000',
  PRIMARY KEY (`id_datos_abae`),
  KEY `usuario_datos_abae` (`id_usuario`),
  KEY `usuario_unidad` (`id_unidad`),
  KEY `usuario_direccion` (`id_direccion`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `datos_abae` */

insert  into `datos_abae`(`id_datos_abae`,`id_usuario`,`id_unidad`,`fecha_ingreso`,`cargo`,`correo_abae`,`nombres_familiares_abae`,`estatus`,`fecha_inicio_administracion`,`id_direccion`,`tlf_oficina`) values 
(14,10,2,'2019-06-17','Jefe','yguaramato@abae.gob.ve','','activo','2019-06-17',1,'00000000'),
(15,11,2,'2019-06-17','Empleado','yguaramato@abae.gob.ve','','activo','2019-06-17',1,'00000000'),
(36,8,0,'2000-06-23','Presidente','agodoy@abae.gob.ve','N/A','activo','2000-06-08',0,'00000000'),
(38,6,2,'2019-06-17','Personal de Investigacion','carrizalesj@abae.gob.ve','','activo','2019-06-17',1,''),
(39,14,2,'2012-04-12','Jefe','carrizalesj@abae.gob.ve','','activo','2012-03-12',1,''),
(40,15,2,'2019-06-17','Personal de Investigacion','carrizalesj@abae.gob.ve','','activo','2019-06-17',1,''),
(41,16,2,'2000-01-01','Personal de Investigacion','usuario@abae.gob.ve','','activo','2000-01-01',1,'02420000000');

/*Table structure for table `datos_hijos` */

DROP TABLE IF EXISTS `datos_hijos`;

CREATE TABLE `datos_hijos` (
  `id_datos_hijos` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT 'nombre',
  `fecha_nacimiento` date DEFAULT NULL,
  `cedula` varchar(30) NOT NULL DEFAULT '0',
  `sexo` varchar(20) DEFAULT NULL,
  `grado_escolar_semestre` varchar(50) NOT NULL DEFAULT 'N/A',
  `talla_camisa` varchar(10) NOT NULL DEFAULT '0',
  `talla_pantalon` varchar(10) NOT NULL DEFAULT '0',
  `talla_calzado` varchar(10) NOT NULL DEFAULT '0',
  `estatus` varchar(10) DEFAULT NULL,
  `edad` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_datos_hijos`),
  KEY `usuario_hijos` (`id_usuario`),
  CONSTRAINT `usuario_hijos` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `datos_hijos` */

insert  into `datos_hijos`(`id_datos_hijos`,`id_usuario`,`nombre`,`fecha_nacimiento`,`cedula`,`sexo`,`grado_escolar_semestre`,`talla_camisa`,`talla_pantalon`,`talla_calzado`,`estatus`,`edad`) values 
(79,6,'Yeshua Carrizales','2025-08-28','0','Femenino','Primaria','S','S','0','activo',-3);

/*Table structure for table `datos_militar` */

DROP TABLE IF EXISTS `datos_militar`;

CREATE TABLE `datos_militar` (
  `id_datos_militar` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `instituto_militar` varchar(100) NOT NULL,
  `rango` varchar(50) NOT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_datos_militar`),
  KEY `usuario_datos_militar` (`id_usuario`),
  CONSTRAINT `usuario_datos_militar` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `datos_militar` */

/*Table structure for table `datos_personales` */

DROP TABLE IF EXISTS `datos_personales`;

CREATE TABLE `datos_personales` (
  `id_datos_personales` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_municipio` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT current_timestamp(),
  `domicilio` varchar(100) NOT NULL,
  `lugar_nacimiento` varchar(100) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` varchar(20) NOT NULL,
  `estado_civil` varchar(50) NOT NULL,
  `talla_camisa` varchar(10) NOT NULL,
  `talla_pantalon` varchar(10) NOT NULL,
  `talla_calzado` varchar(10) NOT NULL,
  `estatura` varchar(10) NOT NULL,
  `peso` varchar(10) NOT NULL,
  `perfil_dominante` varchar(50) NOT NULL,
  `telefono_movil` varchar(20) NOT NULL,
  `telefono_habitacion` varchar(20) NOT NULL DEFAULT 'N/A',
  `rif` varchar(20) NOT NULL,
  `contacto_emergencia` varchar(50) NOT NULL,
  `telefono_emergencia` varchar(50) NOT NULL,
  `alergias` varchar(200) NOT NULL DEFAULT 'Ninguna',
  `tipo_sangre` varchar(20) NOT NULL,
  `padece_enfermedad_cronica` varchar(50) DEFAULT 'N/A',
  `esta_embarazada` varchar(10) NOT NULL,
  `meses_gestacion` varchar(10) DEFAULT 'N/A',
  `firma` varchar(500) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT 'Inactivo',
  `foto` varchar(100) NOT NULL DEFAULT 'default_image.jpg',
  `cantidad_hijos` int(10) NOT NULL DEFAULT 0,
  `enfermedad_cronica` varchar(200) NOT NULL DEFAULT 'N/A',
  `nombre_conyugue` varchar(200) NOT NULL DEFAULT 'N/A',
  PRIMARY KEY (`id_datos_personales`),
  KEY `usuario_datos_personales` (`id_usuario`),
  KEY `usuario_parroquia` (`id_municipio`),
  KEY `id_municipio` (`id_municipio`),
  CONSTRAINT `usuario_datos_personales` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `usuario_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `datos_personales` */

insert  into `datos_personales`(`id_datos_personales`,`id_usuario`,`id_municipio`,`fecha_registro`,`domicilio`,`lugar_nacimiento`,`fecha_nacimiento`,`sexo`,`estado_civil`,`talla_camisa`,`talla_pantalon`,`talla_calzado`,`estatura`,`peso`,`perfil_dominante`,`telefono_movil`,`telefono_habitacion`,`rif`,`contacto_emergencia`,`telefono_emergencia`,`alergias`,`tipo_sangre`,`padece_enfermedad_cronica`,`esta_embarazada`,`meses_gestacion`,`firma`,`estatus`,`foto`,`cantidad_hijos`,`enfermedad_cronica`,`nombre_conyugue`) values 
(40,6,87,'2023-06-20','Nueva Taborda / Calle el Silencio','Puerto Cabello','1995-07-29','Masculino','Casado(a)','M','32','42','1.68','80','Diestro','04144001564','02423770971','246420099','Yohaily Añez','04244086819','Priperam','B+','No','N/A','N/A','26-260608_zelda-clipart-black-and-white-legend-of-zelda.png','activo','26-260608_zelda-clipart-black-and-white-legend-of-zelda.png',0,'N/A','Yohaily Añez'),
(41,7,462,'2023-06-20','Direccion','Caracas','1978-05-12','Masculino','Casado(a)','M','32','40','1.60','80','Diestro','0414000000','0242000000','12345678','Aime Contreras','0412000000','34234234','A-','No','N/A','N/A','Boceto 2.jpg','activo','Boceto 2.jpg',1,'N/A','Aime Contreras'),
(42,2,87,'2023-06-26','Puerto Cabello','Pto Cabello','1999-02-24','Masculino','Soltero(a)','S','34','40','170','54','Zurdo','123456','123456','123456','Alguien','123456','No','O+','No','N/A','N/A','MI FIRMA.jpg','activo','descarga (1).jpg',0,'N/A','N/A'),
(43,10,87,'2023-06-27','Bartolome Salom','Pto Cabello','1995-11-13','Femenino','Soltero(a)','M','34','38','160','75','Diestro','1234566','123466','1234567','Yasmira Perozo','5452311','Ninguna','O+','No','N/A','N/A','firma3.png','activo','Yo.jpg',0,'N/A','N/A'),
(44,11,87,'2023-06-27','Bartolome Salom','Pto Cabello','1995-11-13','Femenino','Soltero(a)','M','34','38','160','75','Diestro','1234568','123456','12345678','Jose ','13546856','Ninguna','O+','No','N/A','N/A','firma1.png','activo','lady-justice-png-png-image-901203.png',0,'N/A','N/A'),
(45,12,87,'2023-06-27','Bartolome Salom','Puerto Cabello','1995-11-13','Femenino','Soltero(a)','M','34','38','160','75','Diestro','157468979','12346589','1236589','Yasmira Perozo','15468798','Ninguna','O+','No','N/A','N/A','firma2.png','activo','Yoseli.jpg',0,'N/A','N/A'),
(47,6,87,'2023-07-10','Nueva Taborda / Calle el Silencio','Puerto Cabello','1995-07-29','Masculino','Casado(a)','M','34','42','1.68','80','Diestro','04144001564','02423770971','246420099','Yohaily Añez','04244086819','Priperam','B+','No','N/A','N/A','MER personal-control.png','activo','MER personal-control.png',0,'N/A','Yohaily Añez'),
(48,14,87,'2023-07-10','Vistamar','Puerto Cabello','1989-02-12','Femenino','Soltero(a)','S','28','41','1.68','70','Diestro','0414465454','','156458844','Ninoska Mieres','0414465454','','B-','No','No','N/A','MER personal-control.png','activo','MER personal-control.png',0,'N/A','N/A'),
(49,15,87,'2023-07-10','Nueva Taborda / Calle el Silencio','Puerto Cabello','1995-07-29','Masculino','Casado(a)','M','34','42','1.68','80','Diestro','04144001564','02423770971','246420099','Yohaily Añez','04244086819','Priperam','B+','No','N/A','N/A','MER personal-control.png','activo','Captura de pantalla 2023-01-27 140450-modified.png',0,'N/A','Yohaily Añez'),
(50,16,1,'2023-07-10','Direccion','Lugar de Nacimiento','2000-01-01','Masculino','Soltero(a)','L','30','41','1.60','70','Diestro','04120000000','02420000000','123456788','Contacto','04140000000','Alergias','O-','No','N/A','N/A','26-260608_zelda-clipart-black-and-white-legend-of-zelda.png','activo','26-260608_zelda-clipart-black-and-white-legend-of-zelda.png',0,'N/A','N/A');

/*Table structure for table `datos_vacaciones` */

DROP TABLE IF EXISTS `datos_vacaciones`;

CREATE TABLE `datos_vacaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_solicitud` int(11) DEFAULT NULL,
  `fecha_reintegro` date DEFAULT NULL,
  `cant_periodos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `datos_vacaciones` */

insert  into `datos_vacaciones`(`id`,`id_solicitud`,`fecha_reintegro`,`cant_periodos`) values 
(1,7,'2023-07-31',1);

/*Table structure for table `direccion` */

DROP TABLE IF EXISTS `direccion`;

CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL AUTO_INCREMENT,
  `id_sede` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT 'Nombre de la Direccion',
  `jefe` varchar(100) NOT NULL DEFAULT 'Nombre del Jefe',
  `estatus` varchar(10) DEFAULT 'activo',
  PRIMARY KEY (`id_direccion`),
  KEY `direccion_sede` (`id_sede`),
  CONSTRAINT `direccion_sede` FOREIGN KEY (`id_sede`) REFERENCES `sede` (`id_sede`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `direccion` */

insert  into `direccion`(`id_direccion`,`id_sede`,`nombre`,`jefe`,`estatus`) values 
(1,5,'Dirección de\nInvestigación e\nInnovación','Gustavo Guedez','activo'),
(2,1,'Direccion de Calidad, Normalizacion y Regulacion','Nombre del Jefe','activo'),
(3,1,'Direccion de Ciencia Formacion y Desarrollo','Nombre del Jefe','activo'),
(4,1,'Direccion de Sistemas Espaciales','Nombre del Jefe','activo'),
(5,1,'Direccion de Aplicaciones Espaciales','Nombre del Jefe','activo'),
(8,1,'N/A','N/A','activo');

/*Table structure for table `estados` */

DROP TABLE IF EXISTS `estados`;

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(250) NOT NULL,
  `iso_3166-2` varchar(4) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `estados` */

insert  into `estados`(`id_estado`,`estado`,`iso_3166-2`) values 
(1,'Amazonas','VE-X'),
(2,'Anzoátegui','VE-B'),
(3,'Apure','VE-C'),
(4,'Aragua','VE-D'),
(5,'Barinas','VE-E'),
(6,'Bolívar','VE-F'),
(7,'Carabobo','VE-G'),
(8,'Cojedes','VE-H'),
(9,'Delta Amacuro','VE-Y'),
(10,'Falcón','VE-I'),
(11,'Guárico','VE-J'),
(12,'Lara','VE-K'),
(13,'Mérida','VE-L'),
(14,'Miranda','VE-M'),
(15,'Monagas','VE-N'),
(16,'Nueva Esparta','VE-O'),
(17,'Portuguesa','VE-P'),
(18,'Sucre','VE-R'),
(19,'Táchira','VE-S'),
(20,'Trujillo','VE-T'),
(21,'La Guaira','VE-W'),
(22,'Yaracuy','VE-U'),
(23,'Zulia','VE-V'),
(24,'Distrito Capital','VE-A'),
(25,'Dependencias Federales','VE-Z');

/*Table structure for table `experiencia_instituciones_publicas` */

DROP TABLE IF EXISTS `experiencia_instituciones_publicas`;

CREATE TABLE `experiencia_instituciones_publicas` (
  `id_experiencia_instituciones_publicas` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `organismo` varchar(100) NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_egreso` date DEFAULT NULL,
  `cargo` varchar(50) NOT NULL,
  `antecedentes_servicios` varchar(20) NOT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_experiencia_instituciones_publicas`),
  KEY `usuario_experiencia_publica` (`id_usuario`),
  CONSTRAINT `usuario_experiencia_publica` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `experiencia_instituciones_publicas` */

insert  into `experiencia_instituciones_publicas`(`id_experiencia_instituciones_publicas`,`id_usuario`,`organismo`,`fecha_ingreso`,`fecha_egreso`,`cargo`,`antecedentes_servicios`,`estatus`) values 
(1,11,'eaba','2007-01-07','2021-02-07','el que sea','','activa'),
(8,6,'213213','2023-07-06','2023-07-28','PI-4 PASO 1','Si','activo');

/*Table structure for table `feriados` */

DROP TABLE IF EXISTS `feriados`;

CREATE TABLE `feriados` (
  `id` int(11) NOT NULL,
  `days_actual` text DEFAULT NULL,
  `days_siguiente` text DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `feriados` */

insert  into `feriados`(`id`,`days_actual`,`days_siguiente`,`fecha_actualizacion`) values 
(1,'[{\"name\":\"Año Nuevo\",\"date\":\"2023-01-01\",\"status\":\"activo\"},{\"name\":\"Día de los Reyes Magos\",\"date\":\"2023-01-06\",\"status\":\"inactivo\"},{\"name\":\"Día del Maestro\",\"date\":\"2023-01-15\",\"status\":\"inactivo\"},{\"name\":\"Carnaval\",\"date\":\"2023-02-20\",\"status\":\"activo\"},{\"name\":\"Carnaval\",\"date\":\"2023-02-21\",\"status\":\"activo\"},{\"name\":\"San José\",\"date\":\"2023-03-19\",\"status\":\"inactivo\"},{\"name\":\"Semana Santa\",\"date\":\"2023-04-03\",\"status\":\"inactivo\"},{\"name\":\"Jueves Santo\",\"date\":\"2023-04-06\",\"status\":\"activo\"},{\"name\":\"Viernes Santo\",\"date\":\"2023-04-07\",\"status\":\"activo\"},{\"name\":\"Pascua\",\"date\":\"2023-04-09\",\"status\":\"inactivo\"},{\"name\":\"Declaración de la Independencia\",\"date\":\"2023-04-19\",\"status\":\"inactivo\"},{\"name\":\"Día del trabajador\",\"date\":\"2023-05-01\",\"status\":\"activo\"},{\"name\":\"Aniversario de la Batalla de Carabobo\",\"date\":\"2023-06-24\",\"status\":\"activo\"},{\"name\":\"Día de la Independencia\",\"date\":\"2023-07-05\",\"status\":\"activo\"},{\"name\":\"Natalicio de Simón Bolívar\",\"date\":\"2023-07-24\",\"status\":\"activo\"},{\"name\":\"Día de la Bandera\",\"date\":\"2023-08-03\",\"status\":\"inactivo\"},{\"name\":\"Día de Nuestra Señora de Coromoto\",\"date\":\"2023-09-11\",\"status\":\"inactivo\"},{\"name\":\"Día de la resistencia indígena\",\"date\":\"2023-10-12\",\"status\":\"inactivo\"},{\"name\":\"Todos los Santos\",\"date\":\"2023-11-01\",\"status\":\"inactivo\"},{\"name\":\"Día de los Difuntos\",\"date\":\"2023-11-02\",\"status\":\"inactivo\"},{\"name\":\"La inmaculada concepción\",\"date\":\"2023-12-08\",\"status\":\"inactivo\"},{\"name\":\"Día de la Aviación Nacional\",\"date\":\"2023-12-10\",\"status\":\"inactivo\"},{\"name\":\"Nochebuena\",\"date\":\"2023-12-24\",\"status\":\"activo\"},{\"name\":\"Navidad\",\"date\":\"2023-12-25\",\"status\":\"activo\"},{\"name\":\"Fin del Año\",\"date\":\"2023-12-31\",\"status\":\"activo\"}]','[{\"name\":\"Año Nuevo\",\"date\":\"2024-01-01\",\"status\":\"activo\"},{\"name\":\"Día de los Reyes Magos\",\"date\":\"2024-01-06\",\"status\":\"inactivo\"},{\"name\":\"Día del Maestro\",\"date\":\"2024-01-15\",\"status\":\"inactivo\"},{\"name\":\"Carnaval\",\"date\":\"2024-02-12\",\"status\":\"activo\"},{\"name\":\"Carnaval\",\"date\":\"2024-02-13\",\"status\":\"activo\"},{\"name\":\"San José\",\"date\":\"2024-03-19\",\"status\":\"inactivo\"},{\"name\":\"Semana Santa\",\"date\":\"2024-03-25\",\"status\":\"inactivo\"},{\"name\":\"Jueves Santo\",\"date\":\"2024-03-28\",\"status\":\"activo\"},{\"name\":\"Viernes Santo\",\"date\":\"2024-03-29\",\"status\":\"activo\"},{\"name\":\"Pascua\",\"date\":\"2024-03-31\",\"status\":\"inactivo\"},{\"name\":\"Declaración de la Independencia\",\"date\":\"2024-04-19\",\"status\":\"inactivo\"},{\"name\":\"Día del trabajador\",\"date\":\"2024-05-01\",\"status\":\"activo\"},{\"name\":\"Aniversario de la Batalla de Carabobo\",\"date\":\"2024-06-24\",\"status\":\"activo\"},{\"name\":\"Día de la Independencia\",\"date\":\"2024-07-05\",\"status\":\"activo\"},{\"name\":\"Natalicio de Simón Bolívar\",\"date\":\"2024-07-24\",\"status\":\"activo\"},{\"name\":\"Día de la Bandera\",\"date\":\"2024-08-03\",\"status\":\"inactivo\"},{\"name\":\"Día de Nuestra Señora de Coromoto\",\"date\":\"2024-09-11\",\"status\":\"inactivo\"},{\"name\":\"Día de la resistencia indígena\",\"date\":\"2024-10-12\",\"status\":\"inactivo\"},{\"name\":\"Todos los Santos\",\"date\":\"2024-11-01\",\"status\":\"inactivo\"},{\"name\":\"Día de los Difuntos\",\"date\":\"2024-11-02\",\"status\":\"inactivo\"},{\"name\":\"La inmaculada concepción\",\"date\":\"2024-12-08\",\"status\":\"inactivo\"},{\"name\":\"Día de la Aviación Nacional\",\"date\":\"2024-12-10\",\"status\":\"inactivo\"},{\"name\":\"Nochebuena\",\"date\":\"2024-12-24\",\"status\":\"activo\"},{\"name\":\"Navidad\",\"date\":\"2024-12-25\",\"status\":\"activo\"},{\"name\":\"Fin del Año\",\"date\":\"2024-12-31\",\"status\":\"activo\"}]','2023-07-28');

/*Table structure for table `formacion_exterior` */

DROP TABLE IF EXISTS `formacion_exterior`;

CREATE TABLE `formacion_exterior` (
  `id_formacion_exterior` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `titulo_obtenido` varchar(100) NOT NULL,
  `anio_egreso` varchar(10) NOT NULL,
  `instituto_universitario` varchar(100) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_formacion_exterior`),
  KEY `usuario_formacion_exterior` (`id_usuario`),
  CONSTRAINT `usuario_formacion_exterior` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `formacion_exterior` */

insert  into `formacion_exterior`(`id_formacion_exterior`,`id_usuario`,`titulo_obtenido`,`anio_egreso`,`instituto_universitario`,`pais`,`estatus`) values 
(19,6,'dasda','2312321','3213123','Afganistán','activo'),
(20,6,'Ingeniero Mecatronica','312321','23213','Afganistán','activo'),
(21,6,'213321','3123213','123123','Afganistán','activo');

/*Table structure for table `municipios` */

DROP TABLE IF EXISTS `municipios`;

CREATE TABLE `municipios` (
  `id_municipio` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  PRIMARY KEY (`id_municipio`),
  KEY `municipios_ibfk_1` (`id_estado`),
  CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=463 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `municipios` */

insert  into `municipios`(`id_municipio`,`id_estado`,`municipio`) values 
(1,1,'Alto Orinoco'),
(2,1,'Atabapo'),
(3,1,'Atures'),
(4,1,'Autana'),
(5,1,'Manapiare'),
(6,1,'Maroa'),
(7,1,'Río Negro'),
(8,2,'Anaco'),
(9,2,'Aragua'),
(10,2,'Manuel Ezequiel Bruzual'),
(11,2,'Diego Bautista Urbaneja'),
(12,2,'Fernando Peñalver'),
(13,2,'Francisco Del Carmen Carvajal'),
(14,2,'General Sir Arthur McGregor'),
(15,2,'Guanta'),
(16,2,'Independencia'),
(17,2,'José Gregorio Monagas'),
(18,2,'Juan Antonio Sotillo'),
(19,2,'Juan Manuel Cajigal'),
(20,2,'Libertad'),
(21,2,'Francisco de Miranda'),
(22,2,'Pedro María Freites'),
(23,2,'Píritu'),
(24,2,'San José de Guanipa'),
(25,2,'San Juan de Capistrano'),
(26,2,'Santa Ana'),
(27,2,'Simón Bolívar'),
(28,2,'Simón Rodríguez'),
(29,3,'Achaguas'),
(30,3,'Biruaca'),
(31,3,'Muñóz'),
(32,3,'Páez'),
(33,3,'Pedro Camejo'),
(34,3,'Rómulo Gallegos'),
(35,3,'San Fernando'),
(36,4,'Atanasio Girardot'),
(37,4,'Bolívar'),
(38,4,'Camatagua'),
(39,4,'Francisco Linares Alcántara'),
(40,4,'José Ángel Lamas'),
(41,4,'José Félix Ribas'),
(42,4,'José Rafael Revenga'),
(43,4,'Libertador'),
(44,4,'Mario Briceño Iragorry'),
(45,4,'Ocumare de la Costa de Oro'),
(46,4,'San Casimiro'),
(47,4,'San Sebastián'),
(48,4,'Santiago Mariño'),
(49,4,'Santos Michelena'),
(50,4,'Sucre'),
(51,4,'Tovar'),
(52,4,'Urdaneta'),
(53,4,'Zamora'),
(54,5,'Alberto Arvelo Torrealba'),
(55,5,'Andrés Eloy Blanco'),
(56,5,'Antonio José de Sucre'),
(57,5,'Arismendi'),
(58,5,'Barinas'),
(59,5,'Bolívar'),
(60,5,'Cruz Paredes'),
(61,5,'Ezequiel Zamora'),
(62,5,'Obispos'),
(63,5,'Pedraza'),
(64,5,'Rojas'),
(65,5,'Sosa'),
(66,6,'Caroní'),
(67,6,'Cedeño'),
(68,6,'El Callao'),
(69,6,'Gran Sabana'),
(70,6,'Heres'),
(71,6,'Piar'),
(72,6,'Angostura (Raúl Leoni)'),
(73,6,'Roscio'),
(74,6,'Sifontes'),
(75,6,'Sucre'),
(76,6,'Padre Pedro Chien'),
(77,7,'Bejuma'),
(78,7,'Carlos Arvelo'),
(79,7,'Diego Ibarra'),
(80,7,'Guacara'),
(81,7,'Juan José Mora'),
(82,7,'Libertador'),
(83,7,'Los Guayos'),
(84,7,'Miranda'),
(85,7,'Montalbán'),
(86,7,'Naguanagua'),
(87,7,'Puerto Cabello'),
(88,7,'San Diego'),
(89,7,'San Joaquín'),
(90,7,'Valencia'),
(91,8,'Anzoátegui'),
(92,8,'Tinaquillo'),
(93,8,'Girardot'),
(94,8,'Lima Blanco'),
(95,8,'Pao de San Juan Bautista'),
(96,8,'Ricaurte'),
(97,8,'Rómulo Gallegos'),
(98,8,'San Carlos'),
(99,8,'Tinaco'),
(100,9,'Antonio Díaz'),
(101,9,'Casacoima'),
(102,9,'Pedernales'),
(103,9,'Tucupita'),
(104,10,'Acosta'),
(105,10,'Bolívar'),
(106,10,'Buchivacoa'),
(107,10,'Cacique Manaure'),
(108,10,'Carirubana'),
(109,10,'Colina'),
(110,10,'Dabajuro'),
(111,10,'Democracia'),
(112,10,'Falcón'),
(113,10,'Federación'),
(114,10,'Jacura'),
(115,10,'José Laurencio Silva'),
(116,10,'Los Taques'),
(117,10,'Mauroa'),
(118,10,'Miranda'),
(119,10,'Monseñor Iturriza'),
(120,10,'Palmasola'),
(121,10,'Petit'),
(122,10,'Píritu'),
(123,10,'San Francisco'),
(124,10,'Sucre'),
(125,10,'Tocópero'),
(126,10,'Unión'),
(127,10,'Urumaco'),
(128,10,'Zamora'),
(129,11,'Camaguán'),
(130,11,'Chaguaramas'),
(131,11,'El Socorro'),
(132,11,'José Félix Ribas'),
(133,11,'José Tadeo Monagas'),
(134,11,'Juan Germán Roscio'),
(135,11,'Julián Mellado'),
(136,11,'Las Mercedes'),
(137,11,'Leonardo Infante'),
(138,11,'Pedro Zaraza'),
(139,11,'Ortíz'),
(140,11,'San Gerónimo de Guayabal'),
(141,11,'San José de Guaribe'),
(142,11,'Santa María de Ipire'),
(143,11,'Sebastián Francisco de Miranda'),
(144,12,'Andrés Eloy Blanco'),
(145,12,'Crespo'),
(146,12,'Iribarren'),
(147,12,'Jiménez'),
(148,12,'Morán'),
(149,12,'Palavecino'),
(150,12,'Simón Planas'),
(151,12,'Torres'),
(152,12,'Urdaneta'),
(179,13,'Alberto Adriani'),
(180,13,'Andrés Bello'),
(181,13,'Antonio Pinto Salinas'),
(182,13,'Aricagua'),
(183,13,'Arzobispo Chacón'),
(184,13,'Campo Elías'),
(185,13,'Caracciolo Parra Olmedo'),
(186,13,'Cardenal Quintero'),
(187,13,'Guaraque'),
(188,13,'Julio César Salas'),
(189,13,'Justo Briceño'),
(190,13,'Libertador'),
(191,13,'Miranda'),
(192,13,'Obispo Ramos de Lora'),
(193,13,'Padre Noguera'),
(194,13,'Pueblo Llano'),
(195,13,'Rangel'),
(196,13,'Rivas Dávila'),
(197,13,'Santos Marquina'),
(198,13,'Sucre'),
(199,13,'Tovar'),
(200,13,'Tulio Febres Cordero'),
(201,13,'Zea'),
(223,14,'Acevedo'),
(224,14,'Andrés Bello'),
(225,14,'Baruta'),
(226,14,'Brión'),
(227,14,'Buroz'),
(228,14,'Carrizal'),
(229,14,'Chacao'),
(230,14,'Cristóbal Rojas'),
(231,14,'El Hatillo'),
(232,14,'Guaicaipuro'),
(233,14,'Independencia'),
(234,14,'Lander'),
(235,14,'Los Salias'),
(236,14,'Páez'),
(237,14,'Paz Castillo'),
(238,14,'Pedro Gual'),
(239,14,'Plaza'),
(240,14,'Simón Bolívar'),
(241,14,'Sucre'),
(242,14,'Urdaneta'),
(243,14,'Zamora'),
(258,15,'Acosta'),
(259,15,'Aguasay'),
(260,15,'Bolívar'),
(261,15,'Caripe'),
(262,15,'Cedeño'),
(263,15,'Ezequiel Zamora'),
(264,15,'Libertador'),
(265,15,'Maturín'),
(266,15,'Piar'),
(267,15,'Punceres'),
(268,15,'Santa Bárbara'),
(269,15,'Sotillo'),
(270,15,'Uracoa'),
(271,16,'Antolín del Campo'),
(272,16,'Arismendi'),
(273,16,'García'),
(274,16,'Gómez'),
(275,16,'Maneiro'),
(276,16,'Marcano'),
(277,16,'Mariño'),
(278,16,'Península de Macanao'),
(279,16,'Tubores'),
(280,16,'Villalba'),
(281,16,'Díaz'),
(282,17,'Agua Blanca'),
(283,17,'Araure'),
(284,17,'Esteller'),
(285,17,'Guanare'),
(286,17,'Guanarito'),
(287,17,'Monseñor José Vicente de Unda'),
(288,17,'Ospino'),
(289,17,'Páez'),
(290,17,'Papelón'),
(291,17,'San Genaro de Boconoíto'),
(292,17,'San Rafael de Onoto'),
(293,17,'Santa Rosalía'),
(294,17,'Sucre'),
(295,17,'Turén'),
(296,18,'Andrés Eloy Blanco'),
(297,18,'Andrés Mata'),
(298,18,'Arismendi'),
(299,18,'Benítez'),
(300,18,'Bermúdez'),
(301,18,'Bolívar'),
(302,18,'Cajigal'),
(303,18,'Cruz Salmerón Acosta'),
(304,18,'Libertador'),
(305,18,'Mariño'),
(306,18,'Mejía'),
(307,18,'Montes'),
(308,18,'Ribero'),
(309,18,'Sucre'),
(310,18,'Valdéz'),
(341,19,'Andrés Bello'),
(342,19,'Antonio Rómulo Costa'),
(343,19,'Ayacucho'),
(344,19,'Bolívar'),
(345,19,'Cárdenas'),
(346,19,'Córdoba'),
(347,19,'Fernández Feo'),
(348,19,'Francisco de Miranda'),
(349,19,'García de Hevia'),
(350,19,'Guásimos'),
(351,19,'Independencia'),
(352,19,'Jáuregui'),
(353,19,'José María Vargas'),
(354,19,'Junín'),
(355,19,'Libertad'),
(356,19,'Libertador'),
(357,19,'Lobatera'),
(358,19,'Michelena'),
(359,19,'Panamericano'),
(360,19,'Pedro María Ureña'),
(361,19,'Rafael Urdaneta'),
(362,19,'Samuel Darío Maldonado'),
(363,19,'San Cristóbal'),
(364,19,'Seboruco'),
(365,19,'Simón Rodríguez'),
(366,19,'Sucre'),
(367,19,'Torbes'),
(368,19,'Uribante'),
(369,19,'San Judas Tadeo'),
(370,20,'Andrés Bello'),
(371,20,'Boconó'),
(372,20,'Bolívar'),
(373,20,'Candelaria'),
(374,20,'Carache'),
(375,20,'Escuque'),
(376,20,'José Felipe Márquez Cañizalez'),
(377,20,'Juan Vicente Campos Elías'),
(378,20,'La Ceiba'),
(379,20,'Miranda'),
(380,20,'Monte Carmelo'),
(381,20,'Motatán'),
(382,20,'Pampán'),
(383,20,'Pampanito'),
(384,20,'Rafael Rangel'),
(385,20,'San Rafael de Carvajal'),
(386,20,'Sucre'),
(387,20,'Trujillo'),
(388,20,'Urdaneta'),
(389,20,'Valera'),
(390,21,'Vargas'),
(391,22,'Arístides Bastidas'),
(392,22,'Bolívar'),
(407,22,'Bruzual'),
(408,22,'Cocorote'),
(409,22,'Independencia'),
(410,22,'José Antonio Páez'),
(411,22,'La Trinidad'),
(412,22,'Manuel Monge'),
(413,22,'Nirgua'),
(414,22,'Peña'),
(415,22,'San Felipe'),
(416,22,'Sucre'),
(417,22,'Urachiche'),
(418,22,'José Joaquín Veroes'),
(441,23,'Almirante Padilla'),
(442,23,'Baralt'),
(443,23,'Cabimas'),
(444,23,'Catatumbo'),
(445,23,'Colón'),
(446,23,'Francisco Javier Pulgar'),
(447,23,'Páez'),
(448,23,'Jesús Enrique Losada'),
(449,23,'Jesús María Semprún'),
(450,23,'La Cañada de Urdaneta'),
(451,23,'Lagunillas'),
(452,23,'Machiques de Perijá'),
(453,23,'Mara'),
(454,23,'Maracaibo'),
(455,23,'Miranda'),
(456,23,'Rosario de Perijá'),
(457,23,'San Francisco'),
(458,23,'Santa Rita'),
(459,23,'Simón Bolívar'),
(460,23,'Sucre'),
(461,23,'Valmore Rodríguez'),
(462,24,'Libertador');

/*Table structure for table `nivel_academico` */

DROP TABLE IF EXISTS `nivel_academico`;

CREATE TABLE `nivel_academico` (
  `id_nivel_academico` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `especializacion` varchar(50) NOT NULL,
  `titulo_obtenido` varchar(100) NOT NULL,
  `anio_egreso` varchar(10) NOT NULL,
  `instituto_universitario` varchar(100) NOT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_nivel_academico`),
  KEY `usuario_nivel_academico` (`id_usuario`),
  CONSTRAINT `usuario_nivel_academico` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `nivel_academico` */

insert  into `nivel_academico`(`id_nivel_academico`,`id_usuario`,`especializacion`,`titulo_obtenido`,`anio_egreso`,`instituto_universitario`,`estatus`) values 
(6,6,'Licenciatura','Ingeniero de Sistemas','2019','UNEFA','activo'),
(7,7,'Licenciatura','Ingeniero de Sistemas','2019','UNEFA','activo'),
(8,10,'Licenciatura','Ingeniero de Sistemas','2019','UNEFA','activo'),
(9,6,'TSU','Ingeniero de Sistemas','2313','UNEFA','activo'),
(10,14,'Licenciatura','Ingeniero Mecanico','2012','UNEFA','activo'),
(11,15,'Licenciatura','Ingeniero de Sistemas','2019','UNEFA','activo'),
(12,16,'Licenciatura','Ingeniero','2000','Universidad','activo');

/*Table structure for table `nucleo_familiar` */

DROP TABLE IF EXISTS `nucleo_familiar`;

CREATE TABLE `nucleo_familiar` (
  `id_nucleo_familiar` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `parentesco` varchar(50) NOT NULL,
  `cedula` varchar(30) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` varchar(10) NOT NULL,
  `estado_civil` varchar(20) NOT NULL,
  `grado_instruccion` varchar(50) NOT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_nucleo_familiar`),
  KEY `usuario_nucleo_familiar` (`id_usuario`),
  CONSTRAINT `usuario_nucleo_familiar` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `nucleo_familiar` */

insert  into `nucleo_familiar`(`id_nucleo_familiar`,`id_usuario`,`nombre`,`apellido`,`parentesco`,`cedula`,`fecha_nacimiento`,`sexo`,`estado_civil`,`grado_instruccion`,`estatus`) values 
(22,6,'Yohaily de los Angeles','Añez Hernandez','Esposo(a)','28551224','2002-10-11','Femenino','Casado(a)','Secundaria','activo'),
(23,6,'Zuleima Josefina','Vargas Rivas','Madre','15642139','1976-09-09','Femenino','Conyugue','Primaria','activo'),
(24,6,'Jose Francisco','Carrizales Breto','Padre','12424814','1974-06-14','Masculino','Conyugue','Secundaria','activo'),
(25,6,'Yohaily de los Angeles','Añez Hernandez','Esposo(a)','28551224','2002-10-11','Femenino','Casado(a)','N/A','activo'),
(26,15,'Yohaily de los Angeles','Añez Hernandez','Esposo(a)','28551224','2002-10-11','Femenino','Casado(a)','Secundaria','activo');

/*Table structure for table `otros_datos_usuario` */

DROP TABLE IF EXISTS `otros_datos_usuario`;

CREATE TABLE `otros_datos_usuario` (
  `id_otros_datos_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `facebook` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `instagram` varchar(100) NOT NULL,
  `otras_redes` varchar(100) NOT NULL,
  `tiene_carnet_patria` varchar(10) NOT NULL,
  `codigo_carnet_patria` varchar(100) NOT NULL,
  `serial_carnet_patria` varchar(100) NOT NULL,
  `beneficios_patria` varchar(100) NOT NULL,
  `tiene_carnet_psuv` varchar(10) NOT NULL,
  `codigo_carnet_psuv` varchar(100) NOT NULL,
  `serial_carnet_psuv` varchar(100) NOT NULL,
  `beneficios_psuv` varchar(100) NOT NULL,
  `partido_politico` varchar(100) NOT NULL,
  `movimiento_social` varchar(100) NOT NULL,
  `comuna` varchar(100) NOT NULL,
  `es_vocero_comuna` varchar(10) NOT NULL,
  `recibe_clap` varchar(20) NOT NULL,
  `vivienda` varchar(50) NOT NULL,
  `tipo_vivienda` varchar(50) NOT NULL,
  `posee_vehiculo` varchar(20) NOT NULL,
  `tipo_vehiculo` varchar(50) NOT NULL,
  `usa_transporte_publico` varchar(10) NOT NULL,
  `tipo_transporte_publico` varchar(50) NOT NULL,
  `ruta_trabajo` varchar(500) NOT NULL,
  `deporte_actividad_cutural` varchar(200) NOT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_otros_datos_usuario`),
  KEY `usuario_otros_datos` (`id_usuario`),
  CONSTRAINT `usuario_otros_datos` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `otros_datos_usuario` */

insert  into `otros_datos_usuario`(`id_otros_datos_usuario`,`id_usuario`,`facebook`,`twitter`,`instagram`,`otras_redes`,`tiene_carnet_patria`,`codigo_carnet_patria`,`serial_carnet_patria`,`beneficios_patria`,`tiene_carnet_psuv`,`codigo_carnet_psuv`,`serial_carnet_psuv`,`beneficios_psuv`,`partido_politico`,`movimiento_social`,`comuna`,`es_vocero_comuna`,`recibe_clap`,`vivienda`,`tipo_vivienda`,`posee_vehiculo`,`tipo_vehiculo`,`usa_transporte_publico`,`tipo_transporte_publico`,`ruta_trabajo`,`deporte_actividad_cutural`,`estatus`) values 
(3,6,'Jose Carrizales','jcarri07','jcarri07','','Si','261261511651','165165165114','Bolsa, Bonos y Gas','No','','','','No','No','No','No','Si','Alquilada','Casa','No','Automóvil','Si','Autobus','Nueva Taborda - Centro / Centro - Borburata','Sky','activo'),
(4,6,'Jose Carrizales','jcarri07','jcarri07','','Si','456415656165165','484894944484846','Alimentaciones, Proteccion social y Servicios','No','','','','No','No','No','No','Si','Alquilada','Casa','No','Automóvil','Si','bus','Nueva Taborda - Centro / Centro - Borburata','si','activo'),
(5,15,'Jose Carrizales','jcarri07','jcarri07','','Si','151561611561','146161611561','Alimentaciones, Proteccion social y Servicios','No','','','','No','No','No','No','No','Alquilada','Casa','No','Automóvil','Si','Autobus','Nueva Taborda - Centro / Centro - Borburata','Sky','activo'),
(6,16,'Usuario','Usuario','Usuario','','No','','','','No','','','','No','No','No','No','No','Propia','Casa','No','Automóvil','Si','Transporte','Borburata','Sky','activo');

/*Table structure for table `paises` */

DROP TABLE IF EXISTS `paises`;

CREATE TABLE `paises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `paises` */

insert  into `paises`(`id`,`pais`) values 
(1,'Afganistán'),
(2,'Albania'),
(3,'Alemania'),
(4,'Andorra'),
(5,'Angola'),
(6,'Antigua y Barbuda'),
(7,'Arabia Saudita'),
(8,'Argelia'),
(9,'Argentina'),
(10,'Armenia'),
(11,'Australia'),
(12,'Austria'),
(13,'Azerbaiyán'),
(14,'Bahamas'),
(15,'Bangladés'),
(16,'Barbados'),
(17,'Baréin'),
(18,'Bélgica'),
(19,'Belice'),
(20,'Benín'),
(21,'Bielorrusia'),
(22,'Birmania (Myanmar)'),
(23,'Bolivia'),
(24,'Bosnia y Herzegovina'),
(25,'Botsuana'),
(26,'Brasil'),
(27,'Brunéi'),
(28,'Bulgaria'),
(29,'Burkina Faso'),
(30,'Burundi'),
(31,'Bután'),
(32,'Cabo Verde'),
(33,'Camboya'),
(34,'Camerún'),
(35,'Canadá'),
(36,'Catar'),
(37,'Chad'),
(38,'Chile'),
(39,'China'),
(40,'Chipre'),
(41,'Ciudad del Vaticano'),
(42,'Colombia'),
(43,'Comoras'),
(44,'Corea del Norte'),
(45,'Corea del Sur'),
(46,'Costa de Marfil'),
(47,'Costa Rica'),
(48,'Croacia'),
(49,'Cuba'),
(50,'Dinamarca'),
(51,'Dominica'),
(52,'Ecuador'),
(53,'Egipto'),
(54,'El Salvador'),
(55,'Emiratos Árabes Unidos'),
(56,'Eritrea'),
(57,'Eslovaquia'),
(58,'Eslovenia'),
(59,'España'),
(60,'Estados Unidos'),
(61,'Estonia'),
(62,'Eswatini'),
(63,'Etiopía'),
(64,'Filipinas'),
(65,'Finlandia'),
(66,'Fiyi'),
(67,'Francia'),
(68,'Gabón'),
(69,'Gambia'),
(70,'Georgia'),
(71,'Ghana'),
(72,'Granada'),
(73,'Grecia'),
(74,'Guatemala'),
(75,'Guinea'),
(76,'Guinea-Bisáu'),
(77,'Guinea Ecuatorial'),
(78,'Guyana'),
(79,'Haití'),
(80,'Honduras'),
(81,'Hungría'),
(82,'India'),
(83,'Indonesia'),
(84,'Irak'),
(85,'Irán'),
(86,'Irlanda'),
(87,'Islandia'),
(88,'Islas Marshall'),
(89,'Islas Salomón'),
(90,'Israel'),
(91,'Italia'),
(92,'Jamaica'),
(93,'Japón'),
(94,'Jordania'),
(95,'Kazajistán'),
(96,'Kenia'),
(97,'Kirguistán'),
(98,'Kiribati'),
(99,'Kuwait'),
(100,'Laos'),
(101,'Lesoto'),
(102,'Letonia'),
(103,'Líbano'),
(104,'Liberia'),
(105,'Libia'),
(106,'Liechtenstein'),
(107,'Lituania'),
(108,'Luxemburgo'),
(109,'Madagascar'),
(110,'Malasia'),
(111,'Malaui'),
(112,'Maldivas'),
(113,'Malí'),
(114,'Malta'),
(115,'Marruecos'),
(116,'Mauricio'),
(117,'Mauritania'),
(118,'México'),
(119,'Micronesia'),
(120,'Moldavia'),
(121,'Mónaco'),
(122,'Mongolia'),
(123,'Montenegro'),
(124,'Mozambique'),
(125,'Namibia'),
(126,'Nauru'),
(127,'Nepal'),
(128,'Nicaragua'),
(129,'Níger'),
(130,'Nigeria'),
(131,'Noruega'),
(132,'Nueva Zelanda'),
(133,'Omán'),
(134,'Países Bajos'),
(135,'Pakistán'),
(136,'Palaos'),
(137,'Panamá'),
(138,'Papúa Nueva Guinea'),
(139,'Paraguay'),
(140,'Perú'),
(141,'Polonia'),
(142,'Portugal'),
(143,'Reino Unido'),
(144,'República Centroafricana'),
(145,'República Checa'),
(146,'República Democrática del Congo'),
(147,'República Dominicana'),
(148,'Ruanda'),
(149,'Rumania'),
(150,'Rusia'),
(151,'Samoa'),
(152,'San Cristóbal y Nieves'),
(153,'San Marino'),
(154,'Santa Lucía'),
(155,'Santo Tomé y Príncipe'),
(156,'San Vicente y las Granadinas'),
(157,'Senegal'),
(158,'Serbia'),
(159,'Seychelles'),
(160,'Sierra Leona'),
(161,'Singapur'),
(162,'Siria'),
(163,'Somalia'),
(164,'Sri Lanka'),
(165,'Sudáfrica'),
(166,'Sudán'),
(167,'Sudán del Sur'),
(168,'Suecia'),
(169,'Suiza'),
(170,'Surinam'),
(171,'Tailandia'),
(172,'Tanzania'),
(173,'Tayikistán'),
(174,'Timor Oriental'),
(175,'Togo'),
(176,'Tonga'),
(177,'Trinidad y Tobago'),
(178,'Túnez'),
(179,'Turkmenistán'),
(180,'Turquía'),
(181,'Tuvalu'),
(182,'Ucrania'),
(183,'Uganda'),
(184,'Uruguay'),
(185,'Uzbekistán'),
(186,'Vanuatu'),
(187,'Venezuela'),
(188,'Vietnam'),
(189,'Yemen'),
(190,'Yibuti'),
(191,'Zambia'),
(192,'Zimbabue');

/*Table structure for table `parroquias` */

DROP TABLE IF EXISTS `parroquias`;

CREATE TABLE `parroquias` (
  `id_parroquia` int(11) NOT NULL AUTO_INCREMENT,
  `id_municipio` int(11) NOT NULL,
  `parroquia` varchar(250) NOT NULL,
  PRIMARY KEY (`id_parroquia`),
  KEY `parroquias_ibfk_1` (`id_municipio`),
  CONSTRAINT `parroquias_ibfk_1` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `parroquias` */

/*Table structure for table `sede` */

DROP TABLE IF EXISTS `sede`;

CREATE TABLE `sede` (
  `id_sede` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono_oficina` varchar(50) NOT NULL,
  `jefe` varchar(100) NOT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_sede`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `sede` */

insert  into `sede`(`id_sede`,`nombre`,`direccion`,`telefono_oficina`,`jefe`,`estatus`) values 
(1,'CTSR','Caracas','02420000000','','activo'),
(2,'SAT','Caracas','024200000000','','activo'),
(3,'ETCS-Baemari','Guarico','024200000000','','activo'),
(4,'ETCS-Luepa','Bolivar','024200000000','','activo'),
(5,'CIDE','Borburata','024200000000','','activo');

/*Table structure for table `solicitud` */

DROP TABLE IF EXISTS `solicitud`;

CREATE TABLE `solicitud` (
  `id_solicitud` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `tipo_solicitud` varchar(50) NOT NULL,
  `observacion` varchar(300) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_fin` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_apro` timestamp NOT NULL DEFAULT current_timestamp(),
  `dias_cant` int(30) NOT NULL,
  `estatus` varchar(50) DEFAULT NULL,
  `obs_supervisor` varchar(200) NOT NULL,
  `estatus_supervisor` varchar(30) NOT NULL,
  `supervisor` int(30) NOT NULL,
  `aprobado_por` int(30) NOT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_solicitud`),
  KEY `usuario_solicitud` (`id_usuario`),
  CONSTRAINT `usuario_solicitud` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `solicitud` */

insert  into `solicitud`(`id_solicitud`,`id_usuario`,`tipo_solicitud`,`observacion`,`motivo`,`descripcion`,`fecha_inicio`,`fecha_fin`,`created_date`,`date_apro`,`dias_cant`,`estatus`,`obs_supervisor`,`estatus_supervisor`,`supervisor`,`aprobado_por`,`is_read`) values 
(1,11,'Reposo','','Reposo por dolor abdominal','','2023-06-27 08:00:00','2023-06-30 08:00:00','2023-06-27 20:14:28','2023-06-27 20:14:28',4,'pendiente','','pendiente',10,0,1),
(2,11,'Reposo','','Dolor de cabeza','Validado IVSS','2023-07-03 08:00:00','2023-07-07 08:00:00','2023-06-27 20:30:32','2023-06-27 21:14:59',5,'aprobada','Aprobada','aprobada',10,12,1),
(3,11,'Reposo','Aprobada aun falta por validar IVSS','Reposo por intervencion','Validado IVSS','2023-07-03 08:00:00','2023-07-07 08:00:00','2023-06-27 20:35:38','2023-06-27 22:27:09',5,'aprobada','Apruebo, pero pendiente por validar IVSS','aprobada',10,12,1),
(4,11,'Constancia','','Para apertura de cuenta bancaria','','0000-00-00 00:00:00','0000-00-00 00:00:00','2023-06-28 00:01:37','2023-06-28 00:11:41',1,'aprobada','','aprobada',10,12,1),
(5,11,'Reposo','','Prueba de fechas','','0000-00-00 00:00:00','2023-07-05 00:00:00','2023-07-01 22:35:49','2023-07-01 22:35:49',3,'pendiente','','pendiente',10,0,1),
(6,11,'Reposo','','de hoy al 5','','2023-07-01 00:00:00','2023-07-05 00:00:00','2023-07-01 22:49:44','2023-07-01 22:49:44',5,'pendiente','','pendiente',10,0,1),
(7,11,'Vacaciones','fhhhhhhhhhhhhhhhhhhhhhhhhhhhh  sjhgkjdsfhgkjhdfkgjhfdkjgh kjghfkghkdfhg kfjhgkfjhgkdfjghkfdjhgkdfj kfjghkfjhgkfdhgkfjhg','Me fui vale','','2023-07-10 00:00:00','2023-08-10 00:00:00','2023-07-01 22:50:23','2023-07-01 22:50:23',20,'aprobada','','aprobada',10,12,1),
(10,11,'Constancia','Vamos a decir que si ps','Constancia de prueba','','0000-00-00 00:00:00','0000-00-00 00:00:00','2023-07-02 01:22:58','2023-07-02 01:39:09',1,'aprobada','','aprobada',10,12,1),
(11,10,'Reposo','','Prueba de solicitud como jefe','','2023-07-02 00:00:00','2023-07-08 00:00:00','2023-07-02 02:56:42','2023-07-02 02:56:42',7,'pendiente','','pendiente',7,0,NULL),
(12,11,'Reposo','','Para el datatable','Por validar IVSS','2023-07-03 00:00:00','2023-07-04 00:00:00','2023-07-03 00:39:46','2023-07-03 00:39:46',2,'pendiente','','rechazada',10,0,1),
(13,11,'','','','','0000-00-00 00:00:00','0000-00-00 00:00:00','2023-07-04 00:04:42','2023-07-04 00:04:42',1,'pendiente','','pendiente',10,0,NULL),
(14,11,'Constancia','','Constancia, prueba','','0000-00-00 00:00:00','0000-00-00 00:00:00','2023-07-04 22:55:02','2023-07-04 22:55:02',1,'pendiente','','aprobada',10,0,1),
(15,11,'Reposo','','123456','','2023-07-08 00:00:00','2023-07-10 00:00:00','2023-07-04 23:12:07','2023-07-04 23:12:07',3,'pendiente','','pendiente',10,0,NULL),
(16,11,'Constancia','','369852','','0000-00-00 00:00:00','0000-00-00 00:00:00','2023-07-04 23:13:11','2023-07-04 23:13:11',1,'pendiente','','aprobada',10,0,1),
(18,11,'','','36987412366554','','0000-00-00 00:00:00','0000-00-00 00:00:00','2023-07-04 23:13:59','2023-07-04 23:13:59',1,'pendiente','','pendiente',10,0,NULL);

/*Table structure for table `tipo_solicitud` */

DROP TABLE IF EXISTS `tipo_solicitud`;

CREATE TABLE `tipo_solicitud` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tipo_solicitud` */

insert  into `tipo_solicitud`(`id`,`nombre`,`estatus`) values 
(1,'Reposo','activa'),
(2,'Constancia','activa'),
(3,'Permisos','activa'),
(4,'Vacaciones','activa');

/*Table structure for table `unidad` */

DROP TABLE IF EXISTS `unidad`;

CREATE TABLE `unidad` (
  `id_unidad` int(11) NOT NULL AUTO_INCREMENT,
  `id_direccion` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `jefe` varchar(100) NOT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_unidad`),
  KEY `unidad_direccion` (`id_direccion`),
  CONSTRAINT `unidad_direccion` FOREIGN KEY (`id_direccion`) REFERENCES `direccion` (`id_direccion`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `unidad` */

insert  into `unidad`(`id_unidad`,`id_direccion`,`nombre`,`jefe`,`estatus`) values 
(1,1,'Desarrollo e Innovacion Tecnologica','1','activo'),
(2,1,'Logistica de Produccion','10','activo'),
(3,1,'Desarrollo de Productos y Procesos','Eduard Diaz','activo'),
(4,1,'Mantenimiento Industrial','Emerson Aguiar','activo'),
(5,2,'Gestion de Plataformas y Proyectos Espaciales','','activo'),
(6,2,'Aseguramiento de la Calidad de Productos Espaciales','','activo'),
(7,2,'Ingenieria Espacial','','activo'),
(8,2,'Gestion de Calidad','','activo'),
(9,3,'Ciencias Espaciales y Exploracion','','activo'),
(10,3,'Educacion Espacial','','activo'),
(11,4,'Operacion de Vehiculos Espaciales','','activo'),
(12,4,'Segmento Terreno','','activo'),
(13,4,'Equipos y Talleres Especializados','','activo'),
(14,5,'Observacion de la Tierra','','activo'),
(15,5,'Mediciones Cientificas','','activo'),
(16,5,'Sistemas de Navegacion','','activo'),
(17,5,'Telecomunicaciones','','activo'),
(18,5,'Gestion de Datos Espaciales','','activo'),
(25,1,'N/A','N/A','activo');

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `cargo` varchar(30) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `tipo_usuario` varchar(50) NOT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `id_jefe` int(30) NOT NULL,
  `step` int(10) NOT NULL DEFAULT 0,
  `correo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `usuario` */

insert  into `usuario`(`id_usuario`,`nombres`,`apellidos`,`cedula`,`cargo`,`user`,`pass`,`tipo_usuario`,`estatus`,`id_jefe`,`step`,`correo`) values 
(1,'Yoseli','Guaramato','24913526','PI-4 PASO 1','admin','1234','empleado','activo',2,0,'yguaramato@abae.gob.ve'),
(2,'Juan','Ruiz','12345','PI-4 PASO 1','juan','12345','empleado','activo',3,1,'ruizj@abae.gob.ve'),
(6,'Jose','Carrizales','24642009','Admin','jcarri07','12345','empleado','activo',8,9,'carrizalesj5@gmail.com'),
(7,'Gustavo','Guedez','16154544','Director','tavito','12345','jefe','activo',8,6,'gguedez@abae.gob.ve'),
(8,'Adolfo','Godoy','15000000','Presidente','godoy','12345','empleado','activo',0,0,'adolfog@abae.gob.ve'),
(10,'Yoseli','Guaramato','123456','Jefe','User_jefe','1234','jefe','activo',7,6,'yoselionel@gmail.com'),
(11,'Empleado','ABAE','1234567','empleado','User_empleado','1234','empleado','activo',10,1,'empl_abae@abae.gob.ve'),
(12,'Admin','DGH','1234786','director','User_admin','1234','admin','activo',0,1,'dgh_abae@abae.gob.ve'),
(14,'Karla Desiree','Mieres Henriquez','15645884','Jefe','kmieres','12345','jefe','activo',8,7,'kmieres@abae.gob.ve'),
(15,'Jose Franzue','Carrizales Vargas','24642008','','jcarri','12345','empleado','activo',14,9,'carrizalesj5@gmail.com'),
(16,'Usuario','Empleado','12345678','','user01','12345','empleado','activo',14,9,'usuario@abae.gob.ve');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
