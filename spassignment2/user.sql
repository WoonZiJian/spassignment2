CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    email VARCHAR(100) UNIQUE, 
    reset_token VARCHAR(255),
    reset_token_expiry DATETIME 
);