CREATE TABLE IF NOT EXISTS users (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR (255) UNIQUE, password VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS posts (id INT NOT NULL AUTO_INCREMENT, user_id INT, title VARCHAR(255) NOT NULL, textbox_content TEXT NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id), CONSTRAINT FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL ON UPDATE SET NULL) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tokens (token_hash VARCHAR (64), user_id INT, expires_at DATETIME, PRIMARY KEY (token_hash), CONSTRAINT FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL ON UPDATE SET NULL) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;