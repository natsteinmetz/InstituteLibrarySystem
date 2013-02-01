InstituteLibrarySystem
======================

Library System developed for university institutes

This work was done in the scope of a bachelor thesis in CS at University of Innsbruck, Austria, in 2006. A detailed user manual can be found in the thesis PDF document.

----------

Installation instructions:

The system was developed with the goal to be run on a Windows server. Detailed installation instructions for the needed programs are available on the official websites:
- Apache - http://httpd.apache.org/docs/2.0/en/install.html (version used 2.0.52)
- PHP - http://www.php.net/manual/en/install.php (version used 4.3.10)
- MySQL - http://dev.mysql.com/doc/refman/4.1/en/installing.html (version used 4.0.21)
- phpMyAdmin - http://www.phpmyadmin.net/documentation/#quick_install (version used 2.6.1)

PHP needs to be installed as CGI (Common Gateway Interface) or CLI (Command Line Interface) program, as we want to execute a PHP cron job.

----------

Configuration instructions:

We configured Apache and MySQL according to the official instructions and applied only for PHP an own configuration:

Change the following values in the PHP configuration file php.ini:
- set "register globals" to OFF
- set "display errors" to OFF
- set "log errors" to ON

----------

Please save the folder "dpslibrary_php" (within the sources folder) into the Apache "htdocs" folder.

To be able to login to the library, you need to create a user for yourself, e.g. within the "insert.sql" file (folder "database_scripts") or using phpMyAdmin.