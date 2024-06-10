CREATE DATABASE ouvidoria;
USE ouvidoria;

-- DROP TABLE IF EXISTS usuarios;
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
    estado VARCHAR(50) NOT NULL
);

-- DROP TABLE IF EXISTS logs;
CREATE TABLE IF NOT EXISTS logs(
    id_log INT NOT NULL,
    id_usuario INT NOT NULL,
    token varchar(255) NOT NULL,
    data_criado DATE NOT NULL,
    ativo BOOLEAN NOT NULL,
    data_inativado DATE NULL
);

-- DROP TABLE IF EXISTS ouvidorias;
CREATE TABLE IF NOT EXISTS ouvidorias(
    id_ouvidoria int NOT NULL,
    id_usuario int NOT NULL,
    descricao text NOT NULL,
    tipo_servico text NOT NULL
);

-- DROP TABLE IF EXISTS anexos;
CREATE TABLE IF NOT EXISTS anexos(
    id_anexo int NOT NULL,
    id_ouvidoria int NOT NULL,
    nome varchar(255) NOT NULL,
    arquivo LONGBLOB NULL
);


-- usuarios
ALTER TABLE usuarios ADD CONSTRAINT pk_usuarios PRIMARY KEY (id_usuario);
ALTER TABLE usuarios MODIFY COLUMN id_usuario INT AUTO_INCREMENT;
-- CREATE INDEX idx_usuario_senha ON usuarios (usuario, senha);

-- log
ALTER TABLE logs ADD CONSTRAINT pk_logs PRIMARY KEY (id_log);
ALTER TABLE logs ADD CONSTRAINT fk_logs_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario);
ALTER TABLE logs MODIFY COLUMN id_log INT AUTO_INCREMENT;
-- CREATE INDEX idx_log_ativo_token ON log (ativo, token);
-- CREATE INDEX idx_log_ativo_token_id_usuario ON log (ativo, token, id_usuario);
-- CREATE INDEX idx_log_ativo_token_id_log ON log (ativo, token, id_log);

-- ouvidoria
ALTER TABLE ouvidorias ADD CONSTRAINT pk_ouvidorias PRIMARY KEY (id_ouvidoria); 
ALTER TABLE ouvidorias ADD CONSTRAINT fk_ouvidorias_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario);
ALTER TABLE ouvidorias MODIFY COLUMN id_ouvidoria INT AUTO_INCREMENT;

-- anexos
ALTER TABLE anexos ADD CONSTRAINT pk_anexos PRIMARY KEY (id_anexo);
ALTER TABLE anexos ADD CONSTRAINT fk_anexos_usuarios FOREIGN KEY (id_ouvidoria) REFERENCES ouvidorias(id_ouvidoria);
ALTER TABLE anexos MODIFY COLUMN id_anexo INT AUTO_INCREMENT;
-- CREATE INDEX idx_anexos_id_ouvidoria_arquivo ON log (id_ouvidoria, arquivo);