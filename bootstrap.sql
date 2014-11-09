drop database if exists php_orm;
create database php_orm;

GRANT SELECT, INSERT, DELETE, UPDATE
ON php_orm.*
TO orm@localhost
IDENTIFIED BY '';

CREATE TABLE php_orm.record_test (id INTEGER, name VARCHAR(50), a_date DATE);
INSERT INTO php_orm.record_test VALUES (1, 'test', '2014-11-30');
