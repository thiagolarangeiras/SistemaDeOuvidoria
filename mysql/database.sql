CREATE DATABASE ouvidoria;
USE ouvidoria;

DROP TABLE IF EXISTS anexos;
DROP TABLE IF EXISTS ouvidorias;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE IF NOT EXISTS usuarios(
    id_usuario INT NOT NULL,
    usuario VARCHAR(255) NOT NULL,
    senha text NOT NULL,
    nome VARCHAR(255) NOT NULL,
    nascimento DATE NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(15) NULL,
    whatsapp VARCHAR(15) NULL,
    cidade VARCHAR(50) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    validado BOOL NOT NULL
);

CREATE TABLE IF NOT EXISTS ouvidorias(
    id_ouvidoria int NOT NULL,
    id_usuario int NOT NULL,
    descricao text NOT NULL,
    tipo_servico text NOT NULL
);

CREATE TABLE IF NOT EXISTS anexos(
    id_anexo int NOT NULL,
    id_ouvidoria int NOT NULL,
    nome varchar(255) NOT NULL,
    arquivo LONGBLOB NULL
);

ALTER TABLE usuarios ADD CONSTRAINT pk_usuarios PRIMARY KEY (id_usuario);
ALTER TABLE usuarios MODIFY COLUMN id_usuario INT AUTO_INCREMENT;

ALTER TABLE ouvidorias ADD CONSTRAINT pk_ouvidorias PRIMARY KEY (id_ouvidoria); 
ALTER TABLE ouvidorias MODIFY COLUMN id_ouvidoria INT AUTO_INCREMENT;
ALTER TABLE ouvidorias ADD CONSTRAINT fk_ouvidorias_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario);

ALTER TABLE anexos ADD CONSTRAINT pk_anexos PRIMARY KEY (id_anexo);
ALTER TABLE anexos MODIFY COLUMN id_anexo INT AUTO_INCREMENT;
ALTER TABLE anexos ADD CONSTRAINT fk_anexos_usuarios FOREIGN KEY (id_ouvidoria) REFERENCES ouvidorias(id_ouvidoria);