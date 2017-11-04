CREATE DATABASE `php_work` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `escolaridade` (
  `id` int(11) NOT NULL,
  `escolaridade` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grupoPaciente` (
  `idPaciente` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  PRIMARY KEY (`idPaciente`,`idGrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `pacientes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idade` int(11) DEFAULT NULL,
  `sexo` enum('Feminino','Masculino') DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `escolaridade` int(11) DEFAULT NULL,
  `tempoDeFumo` int(11) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf_UNIQUE` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
