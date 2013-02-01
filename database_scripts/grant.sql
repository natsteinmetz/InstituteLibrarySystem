/*Access rights on the stilibrary database*/

/*Default*/
GRANT USAGE ON stilibrary.* TO 'libraryDefault'@'localhost' IDENTIFIED BY 'default';
GRANT SELECT ON stilibrary.* TO 'libraryDefault'@'localhost';

/*Superuser*/
GRANT USAGE ON stilibrary.* TO 'librarySuperuser'@'localhost' IDENTIFIED BY 'superuser';
GRANT ALL PRIVILEGES ON stilibrary.* TO 'librarySuperuser'@'localhost' WITH GRANT OPTION;

/*User*/
GRANT USAGE ON stilibrary.* TO 'libraryUser'@'localhost' IDENTIFIED BY 'user';
GRANT SELECT, UPDATE (status) ON stilibrary.publication TO 'libraryUser'@'localhost';
GRANT SELECT, INSERT, DELETE ON stilibrary.borrowing TO 'libraryUser'@'localhost';
GRANT SELECT, UPDATE (password) ON stilibrary.user TO 'libraryUser'@'localhost';
GRANT SELECT (userReminder) ON stilibrary.organisation TO 'libraryUser'@'localhost';
