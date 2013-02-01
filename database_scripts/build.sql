/* dpslibrary database */

CREATE DATABASE stilibrary;

/* Tables */

CREATE TABLE user (
  uid			SMALLINT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  firstName		VARCHAR(50) NOT NULL,
  lastName		VARCHAR(50) NOT NULL,
  username		VARCHAR(16) UNIQUE NOT NULL,
  password		VARCHAR(50) NOT NULL,
  email			VARCHAR(50) UNIQUE NOT NULL,
  reminder		TINYINT(1) NOT NULL DEFAULT '1',
  superuser		TINYINT(1) NOT NULL DEFAULT '0');


CREATE TABLE publication (
  pid			SMALLINT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  author		TEXT,
  title			VARCHAR(250) NOT NULL,
  subtitle		TEXT,
  year			YEAR,
  publisher		VARCHAR(200),
  location		VARCHAR(200),
  ISBN			VARCHAR(13),
  keywords		TEXT,
  comment		TEXT,
  signature		VARCHAR(15) UNIQUE NOT NULL,
  procTime		DATE,
  confLoc		VARCHAR(200),
  supervisor		VARCHAR(100),
  school		VARCHAR(200),
  type			ENUM ('all', 'book', 'proceeding', 'manual', 'bachelor thesis', 'master thesis', 'phd thesis', 'miscellaneous') NOT NULL,
  classification	ENUM ('all', 'programming languages', 'software engineering', 'operation systems', 'computer networks', 'theoretical computer science', 'databases', 'compiler design', 'hardware', 'project management', 'mathematics', 'others') NOT NULL,
  status		ENUM('new', 'available', 'not available', 'checked out', 'missing') NOT NULL,
  originDate		DATE NOT NULL);
  
  
CREATE TABLE borrowing (
  bid			SMALLINT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  borrowDate		DATE NOT NULL,
  returnDate		DATE,
  user			SMALLINT UNSIGNED NOT NULL,
  publication		SMALLINT UNSIGNED UNIQUE NOT NULL,
  FOREIGN KEY (user) 		REFERENCES user (uid),
  FOREIGN KEY (publication) 	REFERENCES publication (pid));

CREATE TABLE organisation (
  userReminder		SMALLINT(5) UNSIGNED NOT NULL,
  newToAvailable	SMALLINT(5) UNSIGNED NOT NULL);
