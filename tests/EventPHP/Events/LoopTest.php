<?php

namespace EventPHP\Events;

class LoopTest extends \PHPUnit_Framework_TestCase {

    function testConstruct() {

        $loop = new Loop();

    }

    function testGetInstance() {

        $loop = Loop::getInstance();
        $this->assertTrue($loop instanceof Loop);
        $loop2 = Loop::getInstance();
        $this->assertTrue($loop===$loop2); 

    }

}

?>
