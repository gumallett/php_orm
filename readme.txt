ORM layer for php
Written by Greg Mallett
Last Updated 10/2014

Run the bootstrap.sql file against a Mysql database of your choosing to allow the tests to work. Tests use PHPUnit.

There are a couple of conventions (assumptions) used by this library:

1) Model classes should extend phporm\Record
2) You should read the wiki on github

A Logger class and an __autoload function are also provided for your convenience.

globals.php contains 3 constants which control DB access. The defaults are:
DB_NAME -- database name
DB_USER -- database connection user
DB_PASSWORD -- database connection password