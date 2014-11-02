<?php

namespace phporm;

require_once __DIR__ . '/../../src/phporm/globals.php';
require_once __DIR__.'/../../src/model/RecordTest.php';

class RecordTest extends \PHPUnit_Framework_TestCase {

   public function testRecordFind() {
      $result = \model\RecordTest::find("name='test'");
   }

}
 