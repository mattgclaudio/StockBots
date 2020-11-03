USE login_db;

CREATE TABLE keys (
	id int NOT NULL IDENTITY(1, 1),
	username varchar(128) NOT NULL,
	publickey varchar(128) NOT NULL,
	privatekey varchar(128) NOT NULL,
	);

INSERT INTO keys (username, publickey, privatekey) VALUES ('testuser', 'PKOWHBTVHXBZXFDOY8YU', 'sNoRCTp9cK6Y8k4jerXijbPeY1553MkxcKe4sHgt');

SELECT * FROM keys;
	
