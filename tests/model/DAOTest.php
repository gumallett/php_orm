<?php

namespace model;

include_once __DIR__ . '/../../src/model/DAO.php';

class DAOTest extends \PHPUnit_Framework_TestCase {

   public function testGet() {
      $dao = DAO::get();
      $this->assertNotNull($dao);
   }

   public function testQuery() {
      $dao = DAO::get();
      $dao->executeQuery('select * from record_test');
   }
}
 