CREATE DATABASE IF NOT EXISTS event_tracker;
USE event_tracker;

CREATE TABLE user (
    username VARCHAR(32) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);

CREATE TABLE events (
    id CHAR(8) PRIMARY KEY,
    name VARCHAR(64) NOT NULL,
    description VARCHAR(255),
    date DATE,
    time TIME,
    location VARCHAR(64),
    available_slots TINYINT UNSIGNED
);

CREATE TABLE event_signups (
    event_id CHAR(8),
    username VARCHAR(32),
    PRIMARY KEY (event_id, username),
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (username) REFERENCES user(username) ON DELETE CASCADE
);


-- DUMMY DATA

-- Users
INSERT INTO user (username, password, role) VALUES
('Bhavesh', 'bhavesh', 'admin'),
('Armenia', 'user', 'user'),
('Baljeet', 'user', 'user'),
('Pakistan', 'user', 'user');


-- Events
INSERT INTO events (id, name, description, date, time, location, available_slots) VALUES
('1a2b3c4d', 'Pappu Sonu Wedding', 'Sony wets Pappu', '2025-03-01', '10:00:00', 'Bihar, India', 1),
('2b3c4d5e', 'Carrot cake recipe reveal', 'Potatoes and cauliflower', '2025-03-02', '11:00:00', 'NTUC Fairprice', 2),
('3c4d5e6f', 'Shivangi Birthday', 'Special birthday 22 years', '2025-03-03', '12:00:00', 'Orchard plaza', 3),
('4d5e6f7g', 'Presidential speech', 'Halimah speaks about the president', '2025-03-04', '13:00:00', 'White house, Washington', 1);

-- Event Signups
INSERT INTO event_signups (event_id, username) VALUES
('1a2b3c4d', 'Armenia'),
('2b3c4d5e', 'Baljeet'),
('3c4d5e6f', 'Pakistan'),
('4d5e6f7g', 'Bhavesh'),
('1a2b3c4d', 'Baljeet');

