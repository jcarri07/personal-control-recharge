-- Creación de tablas para las 3 nuevas secciones

-- 1. Formación Actual
CREATE TABLE IF NOT EXISTS `formacion_actual` (
  `id_formacion_actual` INT(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(11) DEFAULT NULL,
  `estudios_en_curso` VARCHAR(200) NOT NULL,
  `anio_estimado_graduacion` VARCHAR(10) NOT NULL,
  `instituto_universidad` VARCHAR(200) NOT NULL,
  `observaciones` TEXT,
  `estatus` VARCHAR(10) DEFAULT 'activo',
  PRIMARY KEY (`id_formacion_actual`),
  KEY `usuario_formacion_actual` (`id_usuario`),
  CONSTRAINT `usuario_formacion_actual` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- 2. Cursos Realizados
CREATE TABLE IF NOT EXISTS `cursos_realizados` (
  `id_curso_realizado` INT(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(11) DEFAULT NULL,
  `nombre_curso` VARCHAR(200) NOT NULL,
  `duracion` VARCHAR(100) NOT NULL,
  `anio_curso` VARCHAR(10) NOT NULL,
  `instituto_universidad` VARCHAR(200) NOT NULL,
  `observaciones` TEXT,
  `estatus` VARCHAR(10) DEFAULT 'activo',
  PRIMARY KEY (`id_curso_realizado`),
  KEY `usuario_cursos_realizados` (`id_usuario`),
  CONSTRAINT `usuario_cursos_realizados` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- 3. Certificados de Actividades Realizadas en la Institución
CREATE TABLE IF NOT EXISTS `certificados_actividades` (
  `id_certificado_actividad` INT(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(11) DEFAULT NULL,
  `nombre_curso` VARCHAR(200) NOT NULL,
  `duracion` VARCHAR(100) NOT NULL,
  `anio_curso` VARCHAR(10) NOT NULL,
  `instituto_universidad` VARCHAR(200) NOT NULL,
  `observaciones` TEXT,
  `estatus` VARCHAR(10) DEFAULT 'activo',
  PRIMARY KEY (`id_certificado_actividad`),
  KEY `usuario_certificados_actividades` (`id_usuario`),
  CONSTRAINT `usuario_certificados_actividades` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
