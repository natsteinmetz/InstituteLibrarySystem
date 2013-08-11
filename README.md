
##InstituteLibrarySystem

By [Nathalie Steinmetz](http://www.linkedin.com/in/nathaliesteinmetz).

The **Institute Library System** is a Library Management System developed for university institutes.

This work was done in the scope of a bachelor thesis in CS at University of Innsbruck, Austria, in 2006. A detailed user manual can be found in the [thesis PDF document](thesis_steinmetz_institute_library_system.pdf).

## Description

The **Institute Library System** is a Web application developed for the library of the Distributed Parallel Systems Group (DPS) of the Computer Science Institute of Innsbruck. The system runs on an Apache Web Server and is implemented using PHP. The underlying database is MySQL. 

The **Institute Library System** (ILS) allows managing both library publications and library users. The ILS provides search functionalities: a simple mode for keyword search and an expert mode for advanced search possibilities. Library users can login to the ILS and borrow books. The Web application is the first “contact point” for users when they
search for a publication, borrow or return it. Only books are available to be checked out of the library. All other
publications should be read or eventually copied in the library room. New books are not be checked out during a certain time period, e.g. one month.

The publication and user database is managed by one or more persons with additional competences: the library administrators. They are the ones who add new publications and users to the library and who manage the library content (publications and users). They are also responsible for the allocation of user rights (e.g. administrator rights).

The ILS sends automatic emails to library users to remind them when they need to return a book to the library.

## Installation

The system was developed with the goal to be run on a Windows server. Detailed installation instructions for the needed programs are available on the official websites:
- Apache - http://httpd.apache.org/docs/2.0/en/install.html (version used 2.0.52)
- PHP - http://www.php.net/manual/en/install.php (version used 4.3.10)
- MySQL - http://dev.mysql.com/doc/refman/4.1/en/installing.html (version used 4.0.21)
- phpMyAdmin - http://www.phpmyadmin.net/documentation/#quick_install (version used 2.6.1)

PHP needs to be installed as CGI (Common Gateway Interface) or CLI (Command Line Interface) program, as we want to execute a PHP cron job.

## Configuration

We configured Apache and MySQL according to the official instructions and applied only for PHP an own configuration:

Change the following values in the PHP configuration file php.ini:
- set "register globals" to OFF
- set "display errors" to OFF
- set "log errors" to ON

Please save the folder "dpslibrary_php" (within the sources folder) into the Apache "htdocs" folder.

To be able to login to the library, you need to create a user for yourself, e.g. within the "insert.sql" file (folder "database_scripts") or using phpMyAdmin.

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request


## License

[MIT License] (LICENSE.txt)
