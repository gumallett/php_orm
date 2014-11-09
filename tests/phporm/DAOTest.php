<?php

namespace phporm;

require_once __DIR__ . '/../../src/phporm/globals.php';

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

   public function testQueryDateArgReplacement() {
       $dao = DAO::get();
       $result = $dao->executeQuery('select * from record_test where a_date=:date', array('date' => new \DateTime('11/30/2014')));
       $this->assertNotNull($result);

       $result = $result->fetch_array();
       $this->assertEquals(1, $result['id']);
   }

   public function testInsertDateArgReplacement() {
       $dao = DAO::get();
       $id = 2;
       $success = $dao->executeInsert("insert into record_test values ($id,'testest',:date)", array('date' => new \DateTime('11/29/2014')));
       $dao->commit();

       $this->assertTrue($success);
       $dao->executeQuery("delete from record_test where id=$id");
   }

   public function testFind() {
      $dao = DAO::get();
      $result = $dao->find('model\\RecordTest', "name='test'");
      $this->assertNotNull($result);

      $this->assertEquals('test', $result->getName());
   }
}
 