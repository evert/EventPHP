<?php

namespace EventPHP\Events;

class Loop {

    const ONCE = EVLOOP_ONCE;
    const NONBLOCK = EVLOOP_NONBLOCK;

    static protected $instance;

    static public function getInstance() {

        if (!self::$instance)
            self::$instance = new self();

        return self::$instance;

    }

    protected $eventBase;

    public function __construct() {

        $this->eventBase = event_base_new();

    }

    public function add($event) {

        event_base_set($event, $this->eventBase);
        event_add($event);

    }

    public function loop() {

        event_base_loop($this->eventBase);

    }

}

?>
