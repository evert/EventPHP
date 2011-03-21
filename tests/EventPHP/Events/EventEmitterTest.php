<?php

namespace EventPHP\Events;

class EventEmitterTest extends \PHPUnit_Framework_TestCase {

    function testConstruct() {

        $eventEmitter = new EventEmitter();

    }

    function testEmit() {

        $self = $this;
        $ok = false;

        $eventEmitter = new EventEmitter();
        $eventEmitter->on('test', function($arg) use ($self, &$ok) {

            $self->assertEquals('foo', $arg);
            $ok = true;

        });

        $eventEmitter->emit('test','foo');
        $this->assertTrue($ok);

    }

    function testRemoveListener() {

        $self = $this;
        $ok = false;

        $eventEmitter = new EventEmitter();

        $bad = false;
        $ok = false; 

        $listener1 = function() use (&$bad) {
           $bad = true; 
        };
        $listener2 = function() use (&$ok) {
           $ok = true; 
        };

        $eventEmitter->on('test', $listener1);
        $eventEmitter->on('test', $listener2);
        
        $eventEmitter->removeListener('test', $listener1);

        $eventEmitter->emit('test');

        $this->assertTrue($ok);
        $this->assertFalse($bad);

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testRemoveListenerNotFound() {

        $self = $this;
        $ok = false;

        $eventEmitter = new EventEmitter();

        $eventEmitter->removeListener('test', function() { });

    }

    function testRemoveAllListeners() {

        $self = $this;
        $ok = false;

        $bad = false;

        $eventEmitter = new EventEmitter();

        $listener1 = function() use (&$bad) {
           $bad = true; 
        };
        $listener2 = function() use (&$bad) {
           $bad = true; 
        };

        $eventEmitter->on('test', $listener1);
        $eventEmitter->on('test', $listener2);
        
        $eventEmitter->removeAllListeners('test');

        $eventEmitter->emit('test');

        $this->assertFalse($bad);

    }

}

?>
