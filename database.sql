CREATE DATABASE ouvidoria;
USE ouvidoria;

--DROP TABLE IF EXISTS usuarios;
CREATE TABLE IF NOT EXISTS usuarios(
    id_usuario INT NOT NULL AUTO_INCREMENT,
    usuario VARCHAR(255) NOT NULL,
    senha text NOT NULL, -- one way hashed
    nome VARCHAR(255) NOT NULL,
    nascimento DATE NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(15) NULL,
    whatsapp VARCHAR(15) NULL,
    cidade VARCHAR(50) NOT NULL,
    estado VARCHAR(50) NOT NULL
);

--DROP TABLE IF EXISTS log;
CREATE TABLE IF NOT EXISTS log(
    id_log INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    token varchar(255) NOT NULL,
    data_criado DATE NOT NULL,
    ativo BOOLEAN NOT NULL,
    data_inativado DATE NULL, 
);

--DROP TABLE IF EXISTS ouvidoria;
CREATE TABLE IF NOT EXISTS ouvidoria(
    id_ouvidoria int NOT NULL AUTO_INCREMENT,
    id_usuario int NOT NULL,
    descricao text NOT NULL,
    tipo_servico text NOT NULL,
);

--DROP TABLE IF EXISTS anexos;
CREATE TABLE IF NOT EXISTS anexos(
    id_anexos int NOT NULL AUTO_INCREMENT,
    id_ouvidoria int NOT NULL,
    arquivo LONGBLOB NULL
);

-- usuarios
ALTER TABLE usuarios ADD CONSTRAINT pk_usuarios PRIMARY KEY (id_usuario) AUTO_INCREMENT;
CREATE INDEX idx_usuario_senha ON usuarios (usuario, senha);

-- log
ALTER TABLE log ADD CONSTRAINT pk_log PRIMARY KEY (id_log);
CREATE INDEX idx_log_ativo_token ON log (ativo, token);
CREATE INDEX idx_log_ativo_token_id_usuario ON log (ativo, token, id_usuario);
CREATE INDEX idx_log_ativo_token_id_log ON log (ativo, token, id_log);

-- ouvidoria
ALTER TABLE usuarios ADD CONSTRAINT pk_usuarios PRIMARY KEY (id_ouvidoria);

-- anexos
-- ALTER TABLE anexos ADD CONSTRAINT pk_anexos PRIMARY KEY (id_anexos);
-- CREATE INDEX idx_anexos_id_ouvidoria_arquivo ON log (id_ouvidoria, arquivo);