DATABASE - PIAproject
Tables - users
         slika




Commands for MySQL database
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'artist', 'admin') NOT NULL
);

CREATE TABLE artists (
    artist_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE,
    bio TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE artworks (
    artwork_id INT PRIMARY KEY AUTO_INCREMENT,
    artist_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(255) NOT NULL,
    creation_date DATE,
    technique VARCHAR(255),
    cost DECIMAL(10, 2),
    on_sale BOOLEAN,
    dimensions VARCHAR(255),
    FOREIGN KEY (artist_id) REFERENCES artists(artist_id)
);


CREATE TABLE ratings (
    rating_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    artwork_id INT,
    rating INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (artwork_id) REFERENCES artworks(artwork_id)
);

CREATE TABLE comments (
    comment_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    artwork_id INT,
    comment TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (artwork_id) REFERENCES artworks(artwork_id)
);


