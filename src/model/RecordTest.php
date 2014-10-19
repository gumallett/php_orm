<?php

namespace model;

require_once __DIR__ . '/../globals.php';

use phporm\Record;

class RecordTest extends Record {

   private $id;
   private $name;

   /**
    * @return mixed
    */
   public function getId() {
      return $this->id;
   }

   /**
    * @param mixed $id
    */
   public function setId($id) {
      $this->id = $id;
   }

   /**
    * @return mixed
    */
   public function getName() {
      return $this->name;
   }

   /**
    * @param mixed $name
    */
   public function setName($name) {
      $this->name = $name;
   }

   /**
    * @return string
    */
   public static function getTableName() {
      return 'record_test';
   }
}
 