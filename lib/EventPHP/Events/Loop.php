<?php

namespace EventPHP\Events;

/**
 * The Loop class represents the main event loop.
 *
 * The loop class provides the means to start looping through all outstanding 
 * I/O events and fires them off if they are triggered.
 *
 * The class can optionally work as a singleton.
 *
 * @package EventPHP 
 * @subpackage Events
 * @copyright Copyright (C) 2011 Rooftop Solutions. All rights reserved.
 * @author Evert Pot (http://www.rooftopsolutions.nl/) 
 * @license http://code.google.com/p/sabredav/wiki/License Modified BSD License
 */
class Loop {

    /**
     * @see Loop::loop
     */ 
    const ONCE = EVLOOP_ONCE;

    /**
     * @see Loop::loop
     */ 
    const NONBLOCK = EVLOOP_NONBLOCK;

    /**
     * Singleton instance
     */
    static protected $instance;

    /**
     * Returns an instance of the Loop object 
     * 
     * @return Loop 
     */
    static public function getInstance() {

        if (!self::$instance)
            self::$instance = new self();

        return self::$instance;

    }

    /**
     * Libevent base resource 
     * 
     * @var resource 
     */
    protected $eventBase;

    /**
     * Starts the event loop.
     *
     * THe NONBLOCK option will loop through the event once and exit 
     * immediately after there are no outstanding events.
     *
     * The ONCE does the same, but requires at least one event to be handled.
     * 
     * @return void 
     */
    public function loop($flags = 0) {

        event_base_loop($this->eventBase, $flags);

    }


    /**
     * Constructor 
     */
    public function __construct() {

        $this->eventBase = event_base_new();

    }

    /**
     * Adds an event to the loop
     *
     * @param resource $event event object as returned from event_new 
     * @return void 
     */
    public function add($event) {

        event_base_set($event, $this->eventBase);
        event_add($event);

    }
}

?>
