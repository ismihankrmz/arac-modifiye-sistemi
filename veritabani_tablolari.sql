
-- Kullanıcılar tablosu 
CREATE TABLE kullanicilar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    reset_token VARCHAR(255) DEFAULT NULL
);

-- Modifiyeler tablosu
CREATE TABLE modifiyeler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    modname VARCHAR(100) NOT NULL,
    details TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES kullanicilar(id) ON DELETE CASCADE
);
