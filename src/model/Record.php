<?php

namespace model;

use ReflectionClass;

require_once __DIR__ . '/../inc/globals.php';

abstract class Record implements Identifiable {

   private $table;
   private $dirty;

   public function __construct() {
      $class = new ReflectionClass($this);
      $this->class = $class->getName();

      //try to guess the table name
      $this->table = static::correlate($this->class);
   }

   public static final function getTable() {
      return static::getTableName();
   }

   protected static function getTableName() {
      return '';
   }

   protected static function getClass() {
      return 'Record';
   }

   public final function save() {
      $dao = DAO::get();
      $dao->save($this);
   }

   public final function save_() {
      $dao = DAO::get();
      $dao->save_($this);
   }

   public final function delete() {
      static::deleteAll('id=:id', array('id' => $this->getId()));
   }

   public static final function find($where = null, $args = null) {
      $dao = DAO::get();
      return $dao->find('model\\'.static::getClass(), $where, $args);
   }

   public static final function findAll($where = null, $args = null) {
      $dao = DAO::get();
      return $dao->findAll('model\\'.static::getClass(), $where, $args);
   }

   public static final function query($sql, $args = null) {
      $dao = DAO::get();
      $result = $dao->executeQuery($sql, $args);
      $results = array();

      while($obj = $result->fetch_object('model\\' . static::getClass())) {
         $model = new TableModel($obj);
         $obj = $model->fetchEager();
         $results[] = $obj;
      }

      return $results;
   }

   public static final function count($where = null, $args = null) {
      $dao = DAO::get();
      return $dao->count('model\\'.static::getClass(), $where, $args);
   }

   public static final function deleteAll($where = null, $args = null) {
      $dao = DAO::get();
      $dao->delete('model\\'.static::getClass(), $where, $args);
   }

   public static function correlate($name) {
      $name = strtolower($name);
      $name = $name . 's';

      return $name;
   }

   protected final function setDirty($dirty) {
      $this->dirty = $dirty;
   }

   protected final function getDirty() {
      return $this->dirty;
   }
}