<?php
/* 

Run this to log into mysql
Then run the command below, replacing cs-username with your own CS username:

  mysql -u NETID -D NETID -h helmi -p

-- =========================================
-- INITIALIZE COLORS TABLE
-- Run this if the table does NOT exist
-- =========================================

CREATE TABLE colors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    hex_value VARCHAR(7) NOT NULL UNIQUE
);

INSERT INTO colors (name, hex_value) VALUES
('Red', '#FF0000'),
('Orange', '#FFA500'),
('Yellow', '#FFFF00'),
('Green', '#008000'),
('Blue', '#0000FF'),
('Purple', '#800080'),
('Grey', '#808080'),
('Brown', '#A52A2A'),
('Black', '#000000'),
('Teal', '#008080');

-- =========================================
-- RESET COLORS TABLE
-- WARNING: This deletes ALL data
-- =========================================

DROP TABLE IF EXISTS colors;

CREATE TABLE colors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    hex_value VARCHAR(7) NOT NULL UNIQUE
);

INSERT INTO colors (name, hex_value) VALUES
('Red', '#FF0000'),
('Orange', '#FFA500'),
('Yellow', '#FFFF00'),
('Green', '#008000'),
('Blue', '#0000FF'),
('Purple', '#800080'),
('Grey', '#808080'),
('Brown', '#A52A2A'),
('Black', '#000000'),
('Teal', '#008080');
*/

$host = "helmi";
$user = "carter64";
$password = "iminhillbillyhell";
$database = "carter64";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


?>