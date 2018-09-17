# Host: srv-datos  (Version 5.5.5-10.1.34-MariaDB)
# Date: 2018-09-17 08:48:10
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "clientes"
#

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `CIF` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `emplazamiento` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `tecnico` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `fechacre` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fechamod` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `nombre_firma` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

#
# Structure for table "dispositivos"
#

DROP TABLE IF EXISTS `dispositivos`;
CREATE TABLE `dispositivos` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_dispositivo` varchar(255) COLLATE latin1_spanish_ci NOT NULL DEFAULT '0',
  `n_timbre` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `f_fabricacion` date DEFAULT NULL,
  `retimbrado` date DEFAULT NULL,
  `ubicacion` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `intervencion` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `nulo` bit(1) DEFAULT b'0',
  `subtipo` int(11) DEFAULT NULL,
  `fechacre` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fechamod` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `fecha_nulo` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2666 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

#
# Structure for table "dispositivos_cont"
#

DROP TABLE IF EXISTS `dispositivos_cont`;
CREATE TABLE `dispositivos_cont` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `cantidad` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `subtipo` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fechacre` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fechamod` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=218 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

#
# Structure for table "documentos"
#

DROP TABLE IF EXISTS `documentos`;
CREATE TABLE `documentos` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `id_revision` int(11) DEFAULT NULL,
  `ruta` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `tipo` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `fechacre` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fechamod` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=343 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

#
# Structure for table "pruebas"
#

DROP TABLE IF EXISTS `pruebas`;
CREATE TABLE `pruebas` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `equipo` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `timbre` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `fabricacion` date DEFAULT NULL,
  `retimbrado` date DEFAULT NULL,
  `ubicacion` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `intervencion` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=408 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

#
# Structure for table "revisiones"
#

DROP TABLE IF EXISTS `revisiones`;
CREATE TABLE `revisiones` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `n_revision` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `f_creacion` date DEFAULT NULL,
  `f_finalizacion` date DEFAULT NULL,
  `tecnico` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `finalizado` bit(1) DEFAULT NULL,
  `firma_tecnico` text COLLATE latin1_spanish_ci,
  `firma_cliente` text COLLATE latin1_spanish_ci,
  `tipo` int(11) DEFAULT NULL,
  `fechacre` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechamod` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

#
# Structure for table "tipos_dispositivos"
#

DROP TABLE IF EXISTS `tipos_dispositivos`;
CREATE TABLE `tipos_dispositivos` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

#
# Structure for table "usuarios"
#

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `password` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `fechacre` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechamod` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
