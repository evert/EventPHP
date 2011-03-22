<?php

namespace EventPHP\Streams;

use EventPHP\Events\EventEmitter as EventEmitter;

class ReadableStream extends EventEmitter {

    protected $handle;

    protected $lEvent;

    function __construct($handle) {

        $this->handle = $handle;
        $this->initEvents();

    }

    protected function initEvents() {

        $self = $this;
        $this->lEvent = event_new();

        event_set($this->lEvent, $this->handle, EV_READ | EV_PERSIST, array($this,'handleEvent'));
        \EventPHP\Events\Loop::getInstance()->add($this->lEvent);

    }

    public function handleEvent() {

        if (feof($this->handle)) {
            $this->emit('end');

            // There is a bug in libevent 0.0.4, which forces us to keep track 
            // of the event object. http://pecl.php.net/bugs/bug.php?id=22610
            //
            // After the event is 'completed' though, we should remove it.
            unset($this->lEvent);

        } else {

            $this->emit('data', fgets($this->handle));

        }

    } 

}

?>
