<?php

namespace model;

require_once __DIR__ . '/../globals.php';

__autoload('phporm\Record');

use phporm\Record;

/**
 * {@Table(name="record_test")}
 */
class RecordTest extends Record {

   public static $__CLASS__ = __CLASS__; // required
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
}
 