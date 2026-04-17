-- Base de datos limpia para el framework FastLight.
-- Servirá como punto de partida de los proyectos FastLight.

-- se incluye:
--  la tabla para usuarios, con algunos usuarios para pruebas.
--  la tabla errores, permite registrar los errores de la aplicación en BDD.
--  la tabla stats, para contar las visitas de cada URL de la aplicación.

-- Última modificación: 02/02/2026


DROP DATABASE IF EXISTS wallacifo;

CREATE DATABASE wallacifo
	DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE wallacifo;

-- tabla users
-- se pueden crear campos adicionales o relaciones con otras entidades si es necesario
CREATE TABLE users(
	id INT PRIMARY KEY auto_increment,
	displayname VARCHAR(32) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE KEY,
	phone VARCHAR(32) NOT NULL UNIQUE KEY,
	password VARCHAR(255) NOT NULL,
	roles VARCHAR(1024) NOT NULL DEFAULT '["ROLE_USER"]',
	picture VARCHAR(256) DEFAULT NULL,
	poblacion VARCHAR(256) NULL DEFAULT NULL,
	cp VARCHAR(5) NULL DEFAULT NULL,
	template VARCHAR(32) NULL DEFAULT NULL COMMENT 'Template a cargar, de entre los que se encuentran en la carpeta templates',
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- usuarios para las pruebas, podéis crear tantos como necesitéis
INSERT INTO users(id, displayname, email, phone, picture, password, roles) VALUES
	(1, 'admin', 'admin@fastlight.org', '000001', 'admin.png', md5('1234'), '["ROLE_USER", "ROLE_ADMIN"]'),
	(2, 'editor', 'editor@fastlight.org', '000002', 'editor.png', md5('1234'), '["ROLE_USER", "ROLE_EDITOR"]'),
	(3, 'user', 'user@fastlight.org', '000003', 'user.png', md5('1234'), '["ROLE_USER"]'),
	(4, 'test', 'test@fastlight.org', '000004', 'test.png', md5('1234'), '["ROLE_USER", "ROLE_TEST", "ROLE_DEBUG"]'),
	(5, 'api', 'api@fastlight.org', '000005', 'api.png', md5('1234'), '["ROLE_API"]'),
    (6, 'blocked', 'blocked@fastlight.org', '000006', 'blocked.png', md5('1234'), '["ROLE_USER", "ROLE_BLOCKED"]'),
    (7, 'default', 'default@fastlight.org', '000007', NULL, md5('1234'), '[]'),
    (8, 'Robert', 'robert@fastlight.org', '000008', 'other.png', md5('1234'), '["ROLE_USER", "ROLE_ADMIN", "ROLE_TEST"]')
;



-- tabla errors
-- por si queremos registrar los errores en base de datos.
CREATE TABLE errors(
	id INT PRIMARY KEY auto_increment,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    type CHAR(3) NOT NULL DEFAULT 'WEB',
    level VARCHAR(32) NOT NULL DEFAULT 'ERROR',
    url VARCHAR(256) NOT NULL,
	message VARCHAR(2048) NOT NULL,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- tabla stats
-- por si queremos registrar las estadísticas de visitas a las disintas URLs de nuestra aplicación.
CREATE TABLE stats(
	id INT PRIMARY KEY auto_increment,
    url VARCHAR(250) NOT NULL UNIQUE KEY,
	count INT NOT NULL DEFAULT 1,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- tabla anuncios
CREATE TABLE anuncios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(256) NOT NULL,
  descripcion VARCHAR(2000) NULL DEFAULT NULL,
  imagen VARCHAR(256) NULL DEFAULT NULL,
  precio FLOAT NOT NULL DEFAULT 0,
  iduser INT NOT NULL,

  FOREIGN KEY (iduser) REFERENCES users(id)
		ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ANUNCIOS DE EJEMPLO QUE PERTENEDEN AL USUARIO USER

INSERT INTO anuncios (titulo, descripcion, imagen, precio, iduser) VALUES
('iPhone 13 128GB', 'En muy buen estado, batería al 90%.', NULL, 649.99, 3),
('Samsung Galaxy S21', 'Funciona perfectamente, incluye cargador.', NULL, 420, 3),
('Portátil Lenovo i5', '8GB RAM, SSD 256GB, ideal para trabajo.', NULL, 389.50, 3),
('Bicicleta urbana', 'Ligera, perfecta para ciudad.', NULL, 180, 3),
('TV LG 43 pulgadas', 'Smart TV Full HD.', NULL, 299.99, 3),
('Sofá 2 plazas', 'Color beige, buen estado.', NULL, 150, 3),
('Mesa comedor', 'Madera maciza, resistente.', NULL, 210, 3),
('Auriculares Sony', 'Cancelación de ruido.', NULL, 89.90, 3),
('Teclado mecánico', 'RGB, switches azules.', NULL, 59.99, 3),
('Ratón gaming Logitech', 'Alta precisión.', NULL, 35, 3),

('Monitor 24 pulgadas', 'Full HD, HDMI.', NULL, 120.75, 3),
('Impresora HP', 'Multifunción.', NULL, 75, 3),
('Cámara Nikon', 'Incluye lente 18-55.', NULL, 310.40, 3),
('Tablet Samsung', 'Pantalla 10".', NULL, 199.99, 3),
('Silla oficina', 'Ergonómica.', NULL, 95, 3),
('Estantería IKEA', '5 niveles.', NULL, 60, 3),
('Microondas Bosch', '20L.', NULL, 55.50, 3),
('Lavadora LG', '7kg.', NULL, 280, 3),
('Nevera pequeña', 'Ideal para oficina.', NULL, 130.99, 3),
('Cafetera Dolce Gusto', 'Incluye cápsulas.', NULL, 45, 3),

('Patinete eléctrico', 'Autonomía 20km.', NULL, 220.25, 3),
('Reloj smartwatch', 'Monitor de actividad.', NULL, 75.99, 3),
('Altavoz Bluetooth', 'Sonido potente.', NULL, 40, 3),
('Disco duro 1TB', 'USB 3.0.', NULL, 50.10, 3),
('Memoria USB 64GB', 'Alta velocidad.', NULL, 12, 3),
('Router WiFi', 'Doble banda.', NULL, 35.75, 3),
('Lampara escritorio', 'LED regulable.', NULL, 20, 3),
('Ventilador torre', 'Silencioso.', NULL, 65.30, 3),
('Aspiradora Xiaomi', 'Sin cable.', NULL, 140, 3),
('Plancha ropa', 'Vapor.', NULL, 30.99, 3),

('Chaqueta cuero', 'Talla M.', NULL, 85, 3),
('Zapatillas Adidas', 'Talla 42.', NULL, 70.50, 3),
('Mochila escolar', 'Resistente.', NULL, 25, 3),
('Gafas de sol', 'Protección UV.', NULL, 15.75, 3),
('Reloj Casio', 'Clásico.', NULL, 35, 3),
('Cinturón cuero', 'Negro.', NULL, 18.99, 3),
('Camisa formal', 'Talla L.', NULL, 22, 3),
('Pantalón vaquero', 'Talla 44.', NULL, 28.40, 3),
('Sudadera Nike', 'Con capucha.', NULL, 45, 3),
('Abrigo invierno', 'Muy cálido.', NULL, 120.99, 3),

('Libro novela', 'Buen estado.', NULL, 8, 3),
('Enciclopedia', 'Completa.', NULL, 55.25, 3),
('Juego PS5', 'Nuevo.', NULL, 60, 3),
('Mando PS5', 'Original.', NULL, 50.90, 3),
('Nintendo Switch', 'Con juegos.', NULL, 250, 3),
('Silla gamer', 'Cómoda.', NULL, 180.60, 3),
('Escritorio gaming', 'Amplio.', NULL, 130, 3),
('Webcam HD', '1080p.', NULL, 40.99, 3),
('Micrófono USB', 'Streaming.', NULL, 55, 3),
('Anillo plata', 'Nuevo.', NULL, 25.50, 3),

('Collar oro', '18k.', NULL, 300, 3),
('Pulsera acero', 'Elegante.', NULL, 35.75, 3),
('Pendientes', 'Diseño moderno.', NULL, 20, 3),
('Maleta viaje', 'Grande.', NULL, 90.99, 3),
('Bolso mujer', 'Nuevo.', NULL, 65, 3),
('Cartera cuero', 'Compacta.', NULL, 30.20, 3),
('Batería externa', '10000mAh.', NULL, 22, 3),
('Cargador rápido', 'USB-C.', NULL, 15.90, 3),
('Soporte móvil', 'Coche.', NULL, 10, 3),
('Drone básico', 'Con cámara.', NULL, 180.75, 3),

('Guitarra acústica', 'Incluye funda.', NULL, 95, 3),
('Teclado musical', '61 teclas.', NULL, 150.50, 3),
('Amplificador', 'Buen sonido.', NULL, 120, 3),
('Batería electrónica', 'Compacta.', NULL, 300.99, 3),
('Violín', 'Para principiantes.', NULL, 70, 3),
('Flauta', 'Metal.', NULL, 25.80, 3),
('Piano digital', '88 teclas.', NULL, 450, 3),
('Cajón flamenco', 'Madera.', NULL, 60.40, 3),
('Ukulele', 'Nuevo.', NULL, 35, 3),
('Micrófono karaoke', 'Bluetooth.', NULL, 28.99, 3),

('Bicicleta niño', 'Pequeña.', NULL, 80, 3),
('Patines', 'Talla 38.', NULL, 45.25, 3),
('Balón fútbol', 'Oficial.', NULL, 20, 3),
('Raqueta tenis', 'Ligera.', NULL, 55.90, 3),
('Pesas 10kg', 'Par.', NULL, 35, 3),
('Cinta correr', 'Plegable.', NULL, 300.50, 3),
('Bicicleta estática', 'Buen estado.', NULL, 220, 3),
('Colchoneta yoga', 'Antideslizante.', NULL, 15.99, 3),
('Guantes gimnasio', 'Cómodos.', NULL, 12, 3),
('Casco bicicleta', 'Seguro.', NULL, 25.70, 3),

('Coche RC', 'Control remoto.', NULL, 45, 3),
('Puzzle 1000 piezas', 'Completo.', NULL, 18.50, 3),
('Juego mesa', 'Divertido.', NULL, 25, 3),
('LEGO set', 'Original.', NULL, 60.99, 3),
('Muñeca', 'Nueva.', NULL, 20, 3),
('Tren eléctrico', 'Funciona.', NULL, 75.30, 3),
('Cuna bebé', 'Buen estado.', NULL, 120, 3),
('Silla bebé', 'Segura.', NULL, 85.75, 3),
('Carrito bebé', 'Plegable.', NULL, 150, 3),
('Andador bebé', 'Estable.', NULL, 40.99, 3),

('Barbacoa portátil', 'Carbón.', NULL, 70, 3),
('Tienda campaña', '2 personas.', NULL, 95.50, 3);
