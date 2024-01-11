DATABASE - PIAproject
Tables - users
         slika




Commands for MySQL database
CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'artist', 'admin') NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE artworks (
    artwork_id INT NOT NULL AUTO_INCREMENT,
    artist_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(255) NOT NULL,
    creation_date DATE,
    technique VARCHAR(255),
    cost DECIMAL(10,2),
    on_sale TINYINT(1),
    dimensions VARCHAR(255),
    likes INT DEFAULT 0,
    visits INT DEFAULT 0,
    PRIMARY KEY (artwork_id),
    FOREIGN KEY (artist_id) REFERENCES artists(artist_id) ON DELETE SET NULL
);
CREATE TABLE comments (
    comment_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    artwork_id INT,
    comment TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (artwork_id) REFERENCES artworks(artwork_id)
);


CREATE TABLE user_likes (
    user_id INT NOT NULL,
    artwork_id INT NOT NULL,
    liked TINYINT(1) NOT NULL DEFAULT 0,
    favorite TINYINT(1) DEFAULT 0,
    grade INT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (user_id, artwork_id)
);
