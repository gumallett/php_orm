<?php

namespace phporm;

include_once __DIR__ . '/../../src/phporm/DAO.php';

class DAOTest extends \PHPUnit_Framework_TestCase {

   public function testGet() {
      $dao = DAO::get();
      $this->assertNotNull($dao);
   }

   public function testQuery() {
      $dao = DAO::get();
      $result = $dao->executeQuery('select * from record_test');
      $this->assertNotNull($result);
   }

   public function testQueryIntArgReplacement() {
      $dao = DAO::get();
      $result = $dao->executeQuery('select * from record_test where id=:id', array('id' => 1));
      $this->assertNotNull($result);

      $result = $result->fetch_array();
      $this->assertEquals(1, $result['id']);
   }

   public function testQueryStringArgReplacement() {
      $dao = DAO::get();
      $result = $dao->executeQuery('select * from record_test where name=:name', array('name' => 'test'));
      $this->assertNotNull($result);

      $result = $result->fetch_array();
      $this->assertEquals('test', $result['name']);
   }

   public function testFind() {
      $dao = DAO::get();
      $result = $dao->find('model\\RecordTest', "name='test'");
      $this->assertNotNull($result);

      $this->assertEquals('test', $result->getName());
   }
}
 