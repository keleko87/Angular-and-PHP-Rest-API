CREATE DATABASE IF NOT EXISTS test_backend_PHP;
 
USE test_backend_PHP;

--
-- Table structure for table `recursos`
--
CREATE TABLE IF NOT EXISTS `recursos` (
  `num` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `imagen` varchar(50) NOT NULL,
  PRIMARY KEY (`num`)
);

--
-- Dumping data for table `customers`
--
INSERT INTO `recursos` (`num`, `nombre`, `descripcion`, `imagen`, `fecha_creacion`) VALUES
(NULL,'Lakitu','agil e inteligente', 'img/personaje1.jpg','2016-10-29'),
(NULL,'Goombas','mala leche', 'img/personaje2.jpg','2016-10-29'),
(NULL,'Yoshi','verde muy verde', 'img/personaje3.jpg', '2016-10-29'),
(NULL,'Toad','cabezon a mas no poder', 'img/personaje4.png', '2016-10-29'),
(NULL,'Mario','el protagonista', 'img/personaje5.jpg','2016-10-29'),
(NULL,'Bowser','Pinchudo pinchudo', 'img/personaje6.jpg','2016-10-29'),
(NULL,'Star','la mejor y mas brillante', 'img/personaje7.jpg','2016-10-29'),
(NULL,'Kamek','the magician', 'img/personaje8.jpg','2016-10-29');


--
-- Create user
--

CREATE USER 'mario'@'localhost' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON *.* TO 'mario'@'localhost';
FLUSH PRIVILEGES;
