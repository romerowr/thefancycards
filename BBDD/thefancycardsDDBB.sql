DROP DATABASE IF EXISTS thefancycards;
CREATE DATABASE thefancycards DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;
USE thefancycards ;
-- -----------------------------------------------------
-- Table roles
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS roles (
  idRol INT(2) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(45) NOT NULL,
  CONSTRAINT pkRoles PRIMARY KEY (idRol))
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table usuarios
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
  idUsuario INT(5) NOT NULL AUTO_INCREMENT,
  nombreUsuario VARCHAR(12) NOT NULL,
  password VARCHAR(45) NOT NULL,
  email VARCHAR(45) NOT NULL,
  activo BOOLEAN DEFAULT TRUE NOT NULL,
  roles_idRol INT(2) NOT NULL,
  CONSTRAINT pk_usuarios PRIMARY KEY (idUsuario),
  UNIQUE KEY uk_nombreUsuario (nombreUsuario),
  UNIQUE KEY uk_email (email),
  CONSTRAINT fk_usuarios_roles
    FOREIGN KEY (roles_idRol)
    REFERENCES roles (idRol)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table provincias
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS provincias (
  codigoProvincia INT(2) NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  CONSTRAINT pk_provincias PRIMARY KEY (codigoProvincia))
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table poblaciones
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS poblaciones (
  idPoblacion INT(2) NOT NULL AUTO_INCREMENT,
  provincias_idProvincia INT(2) NOT NULL,
  codigoMunicipio INT(3) NOT NULL,
  digitoControl INT(3) NOT NULL,
  nombre VARCHAR(145) NOT NULL,
  CONSTRAINT pk_poblaciones PRIMARY KEY (idPoblacion),
  CONSTRAINT fk_poblaciones_proviencias
    FOREIGN KEY (provincias_idProvincia)
    REFERENCES provincias (codigoProvincia)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table pedidos
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pedidos (
  idPedido INT NOT NULL AUTO_INCREMENT,
  fechaCreacion TIMESTAMP DEFAULT  CURRENT_TIMESTAMP NOT NULL,
  usuarios_idUsuario INT NOT NULL,
  CONSTRAINT pk_pedidos PRIMARY KEY (idPedido),
  CONSTRAINT fk_pedidos_usuarios
    FOREIGN KEY (usuarios_idUsuario)
    REFERENCES usuarios (idUsuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table productos
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS productos (
  idProducto INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(45) NOT NULL,
  descripcion VARCHAR(255) NOT NULL,
  precio DOUBLE NOT NULL,
  activo BOOLEAN DEFAULT TRUE NOT NULL,
  CONSTRAINT pk_productos PRIMARY KEY (idProducto))
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table categorias
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS categorias (
  idCategoria INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(45) NOT NULL,
  CONSTRAINT pk_categorias PRIMARY KEY (idCategoria))
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table pedidos_has_productos
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pedidos_has_productos (
  pedidos_idPedido INT NOT NULL,
  productos_idProducto INT NOT NULL,
  emailDestino VARCHAR(45) NULL,
  CONSTRAINT pk_pedidos_has_productos PRIMARY KEY (pedidos_idPedido , productos_idProducto),
  CONSTRAINT fk_pedidos_has_productos_pedidos
    FOREIGN KEY (pedidos_idPedido)
    REFERENCES pedidos (idPedido)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_pedidos_has_productos_productos
    FOREIGN KEY (productos_idProducto)
    REFERENCES productos (idProducto)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table productos_has_categorias
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS productos_has_categorias (
  productos_idProducto INT NOT NULL,
  categorias_idCategoria INT NOT NULL,
  CONSTRAINT pk_productos_has_categorias PRIMARY KEY (productos_idProducto, categorias_idCategoria),
  CONSTRAINT fk_productos_has_categorias_productos
    FOREIGN KEY (productos_idProducto)
    REFERENCES productos (idProducto)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_productos_has_categorias_categorias
    FOREIGN KEY (categorias_idCategoria)
    REFERENCES categorias (idCategoria)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table perfiles
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS perfiles (
  usuarios_idUsuario INT(5) NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  apellido1 VARCHAR(45) NOT NULL,
  apellido2 VARCHAR(45) NULL,
  dni VARCHAR(11) NOT NULL,
  direccion VARCHAR(45) NOT NULL,
  telefono INT(9) NOT NULL,
  poblaciones_idPoblaciones INT(2) NOT NULL,
  CONSTRAINT pk_perfiles PRIMARY KEY (usuarios_idUsuario),
  UNIQUE KEY uk_dni (dni),
  CONSTRAINT fk_perfil_poblaciones
    FOREIGN KEY (poblaciones_idPoblaciones)
    REFERENCES poblaciones (idPoblacion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_perfiles_usuarios
    FOREIGN KEY (usuarios_idUsuario)
    REFERENCES usuarios (idUsuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table metodosDePago
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS metodosDePago (
  idMetodosDePago INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(45) NOT NULL,
  CONSTRAINT pk_metodosDePago PRIMARY KEY (idMetodosDePago))
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table imagenes
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS imagenes (
  idImagen INT NOT NULL AUTO_INCREMENT,
  path VARCHAR(255) NOT NULL,
  productos_idProducto INT NOT NULL,
  CONSTRAINT pk_imagenes PRIMARY KEY (idImagen),
  CONSTRAINT fk_imagenes_productos
    FOREIGN KEY (productos_idProducto)
    REFERENCES productos (idProducto)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table pagados
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS pagados (
  pedidos_idPedido INT NOT NULL,
  fechaPago TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  descuento DECIMAL NOT NULL,
  precioFinal DECIMAL NOT NULL,
  metodosDePago_idMetodosDePago INT NOT NULL,
  CONSTRAINT pk_pagados PRIMARY KEY (pedidos_idPedido),
  CONSTRAINT fk_pagados_pedidos
    FOREIGN KEY (pedidos_idPedido)
    REFERENCES pedidos (idPedido)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_pagados_metodosDePago
    FOREIGN KEY (metodosDePago_idMetodosDePago)
    REFERENCES metodosDePago (idMetodosDePago)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;