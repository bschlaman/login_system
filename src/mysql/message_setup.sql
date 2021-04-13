CREATE DATABASE IF NOT EXISTS MESSAGEDATA;

USE MESSAGEDATA;

GRANT ALL ON MESSAGEDATA.* TO 'user'@'%';

DROP TABLE IF EXISTS messages;

CREATE TABLE messages (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	msg_datetime DATETIME NOT NULL
	msg_subject VARCHAR(30) NOT NULL,
	msg_message VARCHAR(140) NOT NULL,
	sender_fname VARCHAR(30) NOT NULL,
	sender_lname VARCHAR(30) NOT NULL,
	sender_email VARCHAR(30) NOT NULL,
);

INSERT INTO messages (sender_fname, sender_lname, sender_email, msg_subject, msg_message, msg_datetime) VALUES
    ("Brendan", "S", "brendans@brendan.com", "Greetings", "Greetings from the message box", CURTIME());

