<?php

namespace model;

use phporm\Record;
use DateTime;

/**
 * {@Table(name="record_test")}
 */
class RecordTest extends Record {

   public static $__CLASS__ = __CLASS__; // required
   private $id;
   private $name;

   /**
    * {@Temporal}
    */
   private $a_date;

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
     * @return DateTime
     */
    public function getADate() {
        return $this->a_date;
    }

    /**
     * @param DateTime $a_date
     */
    public function setADate(DateTime $a_date) {
        $this->a_date = $a_date;
    }


}
 