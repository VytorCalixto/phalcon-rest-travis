CREATE DATABASE IF NOT EXISTS robotsDB;
USE robotsDB;

DROP TABLE IF EXISTS robots;

CREATE TABLE robots(
    id INT AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(100),
    year INT,
    PRIMARY KEY(id)
);

INSERT INTO robots (name, type, year) VALUES ('R2-D2', 'droid', '1977');
INSERT INTO robots (name, type, year) VALUES ('C3PO', 'droid', '1977');
INSERT INTO robots (name, type, year) VALUES ('Astro Boy', 'droid', '2000');
INSERT INTO robots (name, type, year) VALUES ('T-800', 'mechanical', '1984');
INSERT INTO robots (name, type, year) VALUES ('T-1000', 'mechanical', '1991');
INSERT INTO robots (name, type, year) VALUES ('Ed', 'virtual', '2000');