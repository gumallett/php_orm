<?php

namespace phporm;

require_once __DIR__ . '/../globals.php';

__autoload('\Logger');
__autoload('\phporm\Record');
__autoload('\phporm\TableModel');

use \Logger;
use \mysqli;

class DAO {

   private $connection;
   private static $instance;

   private function __construct() {
      $this->connection = new mysqli("localhost", "root", "", "php_orm");
      $this->connection->autocommit(false);
   }

   public static function get() {
      if(self::$instance == null) {
         self::$instance = new DAO;
      }

      return self::$instance;
   }

   public function find($class, $where, $args = array()) {
      __autoload($class);
      $table = $class::getTable();
      $sql = "select * from $table where $where limit 1";

      $result = $this->executeQuery($sql, $args);
      $record = $result->fetch_object($class);

      if($record) {
         $model = new TableModel($record);
         $record = $model->fetchEager();
      }

      return $record;
   }

   public function findAll($class, $where = null, $args = array()) {
      $table = $class::getTable();
      $sql = "select * from $table ";

      if(isset($where)) {
         $sql .= "where $where";
      }

      $result = $this->executeQuery($sql, $args);
      $results = array();

      while($obj = $result->fetch_object($class)) {
         $model = new TableModel($obj);
         $obj = $model->fetchEager();
         $results[] = $obj;
      }

      return $results;
   }

   public function delete($class, $where = null, $args = array()) {
      $table = $class::getTable();
      $sql = "delete from $table ";

      if(isset($where)) {
         $sql .= "where $where";
      }

      $result = $this->executeQuery($sql, $args);

      if($result) {
         $this->commit();
      }
      else {
         $this->rollback();
      }
   }

   public function save(Record $object) {
      $table_model = new TableModel($object);

      if($object->getId() == null) {
         $table_model->doInsert();
      }
      else {
         $table_model->doUpdate();
      }
   }

   public function save_(Record $object) {
      $table_model = new TableModel($object);

      if($object->getId() == null) {
         $table_model->doInsert();

         if($object->getId() == null) {
            throw new \Exception("Error saving record.");
         }
      }
      else {
         $success = $table_model->doUpdate();

         if(!$success) {
            throw new \Exception("Error saving record.");
         }
      }
   }

   public function saveAll(array $objects) {
      if(count($objects) == 1) {
         $this->save($objects[0]);
      }

      $this->executeBulkInsert($objects);
   }

   public function count($class, $where = null, $args = null) {
      $table = $class::getTable();
      $sql = "select count(1) from $table";

      if($where != null) {
         $sql .= " where $where";
      }

      $result = $this->executeQuery($sql, $args);
      $result = $result->fetch_array();

      return $result[0];
   }

   public function doInTransaction($callback) {
      $success = $callback();

      if($success) {
         $this->commit();
      }
      else {
         $this->rollback();
      }

      return $success;
   }

   public function executeInsert($sql, $args = null, &$inserted_id = 0) {
      $success = $this->executeQuery($sql, $args);

      if($success) {
         $inserted_id = $this->getLastInsertId();
      }

      return $success;
   }

   public function executeQuery($sql, $args = array()) {
      if(isset($args)) {
         $sql = $this->bindParams($sql, $args);
      }

      Logger::log("Executing: $sql");

      $start = microtime(true);
      $result = $this->connection->query($sql);
      $time = microtime(true) - $start;

      if(!$result) {
         Logger::log($this->getError());
      }
      else {
         Logger::log("Query complete in $time ms");
      }

      return $result;
   }

   public function getLastInsertId() {
      return $this->connection->insert_id;
   }

   public function begin() {
      //$this->connection->rollback();
      //not needed in mysqli
   }

   public function commit() {
      $this->connection->commit();
   }

   public function rollback() {
      $this->connection->rollback();
   }

   public function getError() {
      return $this->connection->error;
   }

   private function bindParams($sql, $params) {
      foreach($params as $param => $val) {
         if(is_null($val)) {
            $sql = preg_replace("/:$param(,|\))/m", "NULL$1", $sql);
            $sql = preg_replace("/:$param(,|\s|$)/m", "NULL$1", $sql);
         }
         elseif(is_int($val)) {
            $sql = preg_replace("/:$param(,|\))/m", "$val$1", $sql);
            $sql = preg_replace("/:$param(,|\s|$)/m", "$val$1", $sql);
         }
         elseif(is_float($val)) {
            $sql = preg_replace("/:$param(,|\))/m", "$val$1", $sql);
            $sql = preg_replace("/:$param(,|\s|$)/m", "$val$1", $sql);
         }
         else {
            $val = $this->connection->real_escape_string($val);
            $val = addcslashes($val, '$');
            $sql = preg_replace("/:$param(,|\))/m", "'$val'$1", $sql);
            $sql = preg_replace("/:$param(,|\s|$)/m", "'$val'$1", $sql);
         }
      }

      return $sql;
   }
}