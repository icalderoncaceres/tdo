#  Creado con Kata Kuntur - Modelador de Datos
#  Versión: 2.5.2
#  Sitio Web: http://katakuntur.jeanmazuelos.com/
#  Si usted encuentra algún error le agradeceriamos lo reporte en:
#  http://pm.jeanmazuelos.com/katakuntur/issues/new

#  Administrador de Base de Datos: MySQL/MariaDB
#  Diagrama: bd_apreciodepana
#  Autor: ROMEL FLORES
#  Fecha y hora: 09/10/2015 14:24:04

# GENERANDO TABLAS
CREATE TABLE `usuarios` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identificador del usuario',
	`direccion` VARCHAR(1024) NOT NULL COMMENT 'direccion del usuario',
	`telefono` VARCHAR(11) NOT NULL COMMENT 'telefono del usuario',
	`descripcion` LONGTEXT NOT NULL COMMENT 'campo personalizado por el usuario',
	`estados_id` INTEGER NOT NULL COMMENT 'identificador del estado',	
	KEY(`estados_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `paises` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'id del pais',
	`nombre` VARCHAR(200) NOT NULL COMMENT 'nombre del pais',
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `estados` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identificador del estado',
	`nombre` VARCHAR(100) NOT NULL COMMENT 'nombre del estado',
	`paises_id` INTEGER NOT NULL COMMENT 'id del pais',
	KEY(`paises_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `fotos` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identificador de fotos de publicaciones y fotos de perfil',
	`ruta` VARCHAR(1024) NOT NULL,
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `usuarios_naturales` (
	`identificacion` INTEGER NOT NULL COMMENT 'numero que identifica al usuario legalmente',
	`nombre` VARCHAR(512) NOT NULL COMMENT 'nombre dado por el usuario',
	`apellido` VARCHAR(512) NOT NULL COMMENT 'apellido dado por el usuario',
	`tipo` CHAR(1) NOT NULL,
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`)
) ENGINE=INNODB;
CREATE TABLE `usuarios_accesos` (
	`seudonimo` VARCHAR(32) NOT NULL COMMENT 'nombre unico que identifica al usuario',
	`email` VARCHAR(256) NOT NULL COMMENT 'email del usuario',
	`password` VARCHAR(24) NOT NULL COMMENT 'no menor a 6 caracteres',
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`)
) ENGINE=INNODB;
CREATE TABLE `fotos_usuarios` (
	`status` CHAR(1) NULL COMMENT 'define la foto activa de perfil del usuario',
	`fotos_id` INTEGER NOT NULL COMMENT 'identificador de fotos de publicaciones y fotos de perfil',
	KEY(`fotos_id`),
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`)
) ENGINE=INNODB;
CREATE TABLE `status_usuarios` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identificador',
	`nombre` VARCHAR(128) NOT NULL,
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `categorias_juridicos` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identificador',
	`nombre` VARCHAR(128) NOT NULL,
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `usuarios_juridicos` (
	`razon_social` VARCHAR(512) NOT NULL COMMENT 'nombre juridico de la empresa',
	`rif` INTEGER NOT NULL COMMENT 'rif de la empresa',
	`tipo` CHAR(1) NOT NULL COMMENT 'define el tipo de rif j=juridico,g=gubernamental',
	`categorias_juridicos_id` INTEGER NOT NULL COMMENT 'identificador de la categoria',	
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`)
) ENGINE=INNODB;
CREATE TABLE `status_usuarios` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identificador',
	`nombre` VARCHAR(128) NOT NULL,
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `usuariosxstatus` (
	`fecha` DATE NOT NULL COMMENT 'fecha en que se cambia el status',
	`status_usuarios_id` INTEGER NOT NULL COMMENT 'identificador',
	KEY(`status_usuarios_id`),
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`)
) ENGINE=INNODB;
CREATE TABLE `ultimos_accesos` (
	`fecha` DATE NOT NULL COMMENT 'fecha del acceso',
	`ip` VARCHAR(15) NOT NULL COMMENT 'ip del cliente',
	`datos_cliente` LONGTEXT NOT NULL,
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`)
) ENGINE=INNODB;
CREATE TABLE `publicaciones` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identificador de la publicacion',
	`titulo` VARCHAR(60) NOT NULL COMMENT 'titulo de la publicacion',
	`descripcion` LONGTEXT NOT NULL COMMENT 'descripcion de la publicacion',
	`stock` INTEGER NULL COMMENT 'cantidad de articulos diponibles,si es null=es un servicio',
	`dias_garantia` INTEGER NOT NULL COMMENT 'cantidad de dias de garantia',
	`dafactura` CHAR(1) NOT NULL COMMENT 'si emite factura campo si/no',
	`estienda` CHAR(1) NOT NULL,
	`clasificados_id` INTEGER NOT NULL COMMENT 'identificador del clasificado',
	KEY(`clasificados_id`),
	`condiciones_publicaciones_id` INTEGER NOT NULL COMMENT 'identifcador de la condicion',
	KEY(`condiciones_publicaciones_id`),
	`vencimientos_publicaciones_id` INTEGER NOT NULL COMMENT 'identificador de vencimeinto',
	KEY(`vencimientos_publicaciones_id`),
	`visitas_publicaciones_id` INTEGER NOT NULL COMMENT 'identificador de visitas',
	KEY(`visitas_publicaciones_id`),
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `visitas_publicaciones` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identificador de visitas',
	`numero` INTEGER NOT NULL COMMENT 'contador de visitas',
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `vencimientos_publicaciones` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identificador de vencimeinto',
	`dias` INTEGER NOT NULL COMMENT 'dias para elc alculo del vencimeinto de la publicacion',
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `condiciones_publicaciones` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identifcador de la condicion',
	`condicion` VARCHAR(24) NOT NULL COMMENT 'condicion del articulo en la publicacion',
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `fotosxpublicaciones` (
	`fotos_id` INTEGER NOT NULL COMMENT 'identificador de fotos de publicaciones y fotos de perfil',
	KEY(`fotos_id`),
	`publicaciones_id` INTEGER NOT NULL COMMENT 'identificador de la publicacion',
	KEY(`publicaciones_id`)
) ENGINE=INNODB;
CREATE TABLE `publicaciones_montos` (
	`fecha` DATE NOT NULL COMMENT 'fecha de publicar monto',
	`monto` FLOAT(18) NOT NULL COMMENT 'monto de la publicacion',
	`fecha_fin` DATE NULL,
	`publicaciones_id` INTEGER NOT NULL COMMENT 'identificador de la publicacion',
	KEY(`publicaciones_id`)
) ENGINE=INNODB;
CREATE TABLE `preguntas_publicaciones` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id de la pregunta',
	`contenido` VARCHAR(1024) NOT NULL COMMENT 'la pregunta',
	`publicaciones_id` INTEGER NOT NULL COMMENT 'identificador de la publicacion',
	KEY(`publicaciones_id`),
	`preguntas_publicaciones_id` INTEGER NULL COMMENT 'id de la pregunta',
	KEY(`preguntas_publicaciones_id`),
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `status_publicaciones` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'id del estatus',
	`nombre` VARCHAR(24) NOT NULL COMMENT 'definicion del estatus',
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `publicacionesxstatus` (
	`fecha` DATE NOT NULL COMMENT 'fecha del cambio del estatus',
	`publicaciones_id` INTEGER NOT NULL COMMENT 'identificador de la publicacion',
	KEY(`publicaciones_id`),
	`status_publicaciones_id` INTEGER NOT NULL COMMENT 'id del estatus',
	KEY(`status_publicaciones_id`)
) ENGINE=INNODB;
CREATE TABLE `clasificados` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'identificador del clasificado',
	`nombre` VARCHAR(128) NOT NULL COMMENT 'nombre del clasificado',
	`clasificados_id` INTEGER NULL COMMENT 'identificador del clasificado',
	KEY(`clasificados_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `compras_publicaciones` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id que identifica la compra',
	`fecha` dATE NOT NULL COMMENT 'fecha de la compra',
	`publicaciones_id` INTEGER NOT NULL COMMENT 'identificador de la publicacion',
	KEY(`publicaciones_id`),
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `bancos` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id que identifica el banco',
	`nombre` vARCHAR(512) NOT NULL COMMENT 'nombre del banco',
	`siglas` vARCHAR(12) NOT NULL COMMENT 'nombre corto que identifica el banco',
	PRIMARY KEY(`id`)
) COMMENT='tabla maestra q contiene los bancos' ENGINE=INNODB;
CREATE TABLE `formas_pagos` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id que identifica la forma de pago',
	`nombre` vARCHAR(512) NOT NULL COMMENT 'nombre de la forma de pago',
	PRIMARY KEY(`id`)
) COMMENT='Tabla Maestra que contiene informacion de las formas de pagos' ENGINE=INNODB;
CREATE TABLE `pagosxcompras` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id que identifica el pago',
	`referencia` vARCHAR(32) NOT NULL COMMENT 'numero que representa el apgo por medio del banco',
	`monto` fLOAT(15,2) NOT NULL COMMENT 'monto del pago',
	`fecha` DATE NOT NULL COMMENT 'fecha del pago',
	`status_pago` cHAR(1) NOT NULL COMMENT '//falta',
	`bancos_id` INTEGER NOT NULL COMMENT 'id que identifica el banco',
	KEY(`bancos_id`),
	`compras_publicaciones_id` INTEGER NOT NULL COMMENT 'id que identifica la compra',
	KEY(`compras_publicaciones_id`),
	`formas_pagos_id` INTEGER NOT NULL COMMENT 'id que identifica la forma de pago',
	KEY(`formas_pagos_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `status_envios_compras` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'id que identifica el estatus del envio',
	`nombre` vARCHAR(128) NOT NULL COMMENT 'nombre del status del envio',
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `compras_envios` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id que identifica el envio',
	`fecha` dATE NOT NULL COMMENT 'fehca del envio',
	`nro_guia` vARCHAR(32) NOT NULL COMMENT 'referencia de la agencia de envios',
	`direccion` LONGTEXT NOT NULL COMMENT 'direccion del envio',
	`status_envios_compras_id` INTEGER NOT NULL COMMENT 'id que identifica el estatus del envio',
	KEY(`status_envios_compras_id`),
	`compras_publicaciones_id` INTEGER NOT NULL COMMENT 'id que identifica la compra',
	KEY(`compras_publicaciones_id`),
	`agencias_envios_id` INTEGER NOT NULL COMMENT 'id que identifica la agencia',
	KEY(`agencias_envios_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `agencias_envios` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id que identifica la agencia',
	`nombre` vARCHAR(512) NOT NULL COMMENT 'nombre completo de la agencia',
	`siglas` vARCHAR(12) NOT NULL COMMENT 'nombre coroto de la agencia',
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `reclamos` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id que identifica el reclamo',
	`asunto` LONGTEXT NOT NULL COMMENT 'asunto del reclamo',
	`compras_publicaciones_id` INTEGER NOT NULL COMMENT 'id que identifica la compra',
	KEY(`compras_publicaciones_id`),
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`),
	`tipos_reclamos_id` INTEGER NOT NULL COMMENT 'id que identifica el tipo de reclamo',
	KEY(`tipos_reclamos_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `tipos_reclamos` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id que identifica el tipo de reclamo',
	`nombre` vARCHAR(32) NOT NULL COMMENT 'tipo de reclamo',
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `fases_reclamos` (
	`fecha` dATE NOT NULL COMMENT 'fecha de la face del reclamo',
	`status` eNUM('M','N') NOT NULL COMMENT 'normal,mediacion. son las faces',
	`reclamos_id` INTEGER NOT NULL COMMENT 'id que identifica el reclamo',
	KEY(`reclamos_id`)
) ENGINE=INNODB;
CREATE TABLE `reclamos_comentarios` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id que representa el comentario del reclamo',
	`comentario` longtEXT NOT NULL COMMENT 'contenido del comentario',
	`fecha` dATE NOT NULL COMMENT 'fecha del comentario',
	`reclamos_id` INTEGER NOT NULL COMMENT 'id que identifica el reclamo',
	KEY(`reclamos_id`),
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `calificaciones_compras` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id de referencia que identifica la calificacion',
	`comentario` longtEXT NOT NULL COMMENT 'comentario de la calificacion',
	`calificacion` iNTEGER NOT NULL COMMENT 'valor numerico de la calificacion',
	`compras_publicaciones_id` INTEGER NOT NULL COMMENT 'id que identifica la compra',
	KEY(`compras_publicaciones_id`),
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `publicaciones_favoritos` (
	`visitas_publicaciones_id` INTEGER NOT NULL COMMENT 'identificador de visitas',
	KEY(`visitas_publicaciones_id`),
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`)
) ENGINE=INNODB;
CREATE TABLE `usuarios_amigos` (
	`fecha` dATE NOT NULL COMMENT 'fecha en que se hacen amigos',
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`),
	`amigo_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`amigo_id`)
) ENGINE=INNODB;
CREATE TABLE `notificaciones` (
	`id` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'id identificador de la notificacion',
	`fecha` DATE NOT NULL COMMENT 'fecha de la notififcacion',
	`tipos_notificaciones_id` INTEGER NOT NULL COMMENT 'id identificador del tipo de notificacion',
	KEY(`tipos_notificaciones_id`),
	`usuarios_id` INTEGER NOT NULL COMMENT 'identificador del usuario',
	KEY(`usuarios_id`),
	PRIMARY KEY(`id`)
) ENGINE=INNODB;
CREATE TABLE `tipos_notificaciones` (
	`id` iNTEGER NOT NULL AUTO_INCREMENT COMMENT 'id identificador del tipo de notificacion',
	`tipo` vARCHAR(32) NOT NULL COMMENT 'el tipo de notificacion',
	PRIMARY KEY(`id`)
) ENGINE=INNODB;

# GENERANDO RELACIONES
ALTER TABLE `usuarios` ADD CONSTRAINT `usuarios_estados_estados_id` FOREIGN KEY (`estados_id`) REFERENCES `estados`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `estados` ADD CONSTRAINT `estados_paises_paises_id` FOREIGN KEY (`paises_id`) REFERENCES `paises`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `usuarios_naturales` ADD CONSTRAINT `usuarios_naturales_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `usuarios_accesos` ADD CONSTRAINT `usuarios_accesos_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `fotos_usuarios` ADD CONSTRAINT `fotos_usuarios_fotos_fotos_id` FOREIGN KEY (`fotos_id`) REFERENCES `fotos`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `fotos_usuarios` ADD CONSTRAINT `fotos_usuarios_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `usuarios_juridicos` ADD CONSTRAINT `usuarios_juridicos_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `usuarios_juridicos` ADD CONSTRAINT `usuarios_juridicos_usuarios_categorias_juridicos_id` FOREIGN KEY (`categorias_juridicos_id`) REFERENCES `categorias_juridicos_id`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `usuariosxstatus` ADD CONSTRAINT `usuariosxstatus_status_usuarios_status_usuarios_id` FOREIGN KEY (`status_usuarios_id`) REFERENCES `status_usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `usuariosxstatus` ADD CONSTRAINT `usuariosxstatus_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `ultimos_accesos` ADD CONSTRAINT `ultimos_accesos_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `publicaciones` ADD CONSTRAINT `publicaciones_clasificados_clasificados_id` FOREIGN KEY (`clasificados_id`) REFERENCES `clasificados`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `publicaciones` ADD CONSTRAINT `publicaciones_condiciones_publicaciones_condiciones_publicaci12` FOREIGN KEY (`condiciones_publicaciones_id`) REFERENCES `condiciones_publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `publicaciones` ADD CONSTRAINT `publicaciones_vencimientos_publicaciones_vencimientos_publica13` FOREIGN KEY (`vencimientos_publicaciones_id`) REFERENCES `vencimientos_publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `publicaciones` ADD CONSTRAINT `publicaciones_visitas_publicaciones_visitas_publicaciones_id` FOREIGN KEY (`visitas_publicaciones_id`) REFERENCES `visitas_publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `publicaciones` ADD CONSTRAINT `publicaciones_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `fotosxpublicaciones` ADD CONSTRAINT `fotosxpublicaciones_fotos_fotos_id` FOREIGN KEY (`fotos_id`) REFERENCES `fotos`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `fotosxpublicaciones` ADD CONSTRAINT `fotosxpublicaciones_publicaciones_publicaciones_id` FOREIGN KEY (`publicaciones_id`) REFERENCES `publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `publicaciones_montos` ADD CONSTRAINT `publicaciones_montos_publicaciones_publicaciones_id` FOREIGN KEY (`publicaciones_id`) REFERENCES `publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `preguntas_publicaciones` ADD CONSTRAINT `preguntas_publicaciones_publicaciones_publicaciones_id` FOREIGN KEY (`publicaciones_id`) REFERENCES `publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `preguntas_publicaciones` ADD CONSTRAINT `preguntas_publicaciones_preguntas_publicaciones_preguntas_pub20` FOREIGN KEY (`preguntas_publicaciones_id`) REFERENCES `preguntas_publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `preguntas_publicaciones` ADD CONSTRAINT `preguntas_publicaciones_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `publicacionesxstatus` ADD CONSTRAINT `publicacionesxstatus_publicaciones_publicaciones_id` FOREIGN KEY (`publicaciones_id`) REFERENCES `publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `publicacionesxstatus` ADD CONSTRAINT `publicacionesxstatus_status_publicaciones_status_publicacione23` FOREIGN KEY (`status_publicaciones_id`) REFERENCES `status_publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `clasificados` ADD CONSTRAINT `clasificados_clasificados_clasificados_id` FOREIGN KEY (`clasificados_id`) REFERENCES `clasificados`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `compras_publicaciones` ADD CONSTRAINT `compras_publicaciones_publicaciones_publicaciones_id` FOREIGN KEY (`publicaciones_id`) REFERENCES `publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `compras_publicaciones` ADD CONSTRAINT `compras_publicaciones_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `pagosxcompras` ADD CONSTRAINT `pagosxcompras_bancos_bancos_id` FOREIGN KEY (`bancos_id`) REFERENCES `bancos`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `pagosxcompras` ADD CONSTRAINT `pagosxcompras_compras_publicaciones_compras_publicaciones_id` FOREIGN KEY (`compras_publicaciones_id`) REFERENCES `compras_publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `pagosxcompras` ADD CONSTRAINT `pagosxcompras_formas_pagos_formas_pagos_id` FOREIGN KEY (`formas_pagos_id`) REFERENCES `formas_pagos`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `compras_envios` ADD CONSTRAINT `compras_envios_status_envios_compras_status_envios_compras_id` FOREIGN KEY (`status_envios_compras_id`) REFERENCES `status_envios_compras`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `compras_envios` ADD CONSTRAINT `compras_envios_compras_publicaciones_compras_publicaciones_id` FOREIGN KEY (`compras_publicaciones_id`) REFERENCES `compras_publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `compras_envios` ADD CONSTRAINT `compras_envios_agencias_envios_agencias_envios_id` FOREIGN KEY (`agencias_envios_id`) REFERENCES `agencias_envios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `reclamos` ADD CONSTRAINT `reclamos_compras_publicaciones_compras_publicaciones_id` FOREIGN KEY (`compras_publicaciones_id`) REFERENCES `compras_publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `reclamos` ADD CONSTRAINT `reclamos_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `reclamos` ADD CONSTRAINT `reclamos_tipos_reclamos_tipos_reclamos_id` FOREIGN KEY (`tipos_reclamos_id`) REFERENCES `tipos_reclamos`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `fases_reclamos` ADD CONSTRAINT `fases_reclamos_reclamos_reclamos_id` FOREIGN KEY (`reclamos_id`) REFERENCES `reclamos`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `reclamos_comentarios` ADD CONSTRAINT `reclamos_comentarios_reclamos_reclamos_id` FOREIGN KEY (`reclamos_id`) REFERENCES `reclamos`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `reclamos_comentarios` ADD CONSTRAINT `reclamos_comentarios_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `calificaciones_compras` ADD CONSTRAINT `calificaciones_compras_compras_publicaciones_compras_publicac39` FOREIGN KEY (`compras_publicaciones_id`) REFERENCES `compras_publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `calificaciones_compras` ADD CONSTRAINT `calificaciones_compras_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `publicaciones_favoritos` ADD CONSTRAINT `publicaciones_favoritos_visitas_publicaciones_visitas_publica41` FOREIGN KEY (`visitas_publicaciones_id`) REFERENCES `visitas_publicaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `publicaciones_favoritos` ADD CONSTRAINT `publicaciones_favoritos_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `usuarios_amigos` ADD CONSTRAINT `usuarios_amigos_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `usuarios_amigos` ADD CONSTRAINT `usuarios_amigos_usuarios_amigo_id` FOREIGN KEY (`amigo_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `notificaciones` ADD CONSTRAINT `notificaciones_tipos_notificaciones_tipos_notificaciones_id` FOREIGN KEY (`tipos_notificaciones_id`) REFERENCES `tipos_notificaciones`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
ALTER TABLE `notificaciones` ADD CONSTRAINT `notificaciones_usuarios_usuarios_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios`(`id`) ON DELETE NO ACTION ON UPDATE CASCADE;