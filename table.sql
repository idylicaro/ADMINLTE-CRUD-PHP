CREATE TABLE users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(30) NOT NULL,
password VARCHAR(250) NOT NULL,
email VARCHAR(250) NOT NULL UNIQUE,
)