<?php

namespace EventPHP\Events;

/**
 * The EventEmitter can be used independently, or as a baseclass to distribute 
 * events to multiple listeners.
 *
 * Events are always based on a simple string indicating the event name, and a 
 * callback.
 *
 * @package EventPHP 
 * @subpackage Events
 * @copyright Copyright (C) 2011 Rooftop Solutions. All rights reserved.
 * @author Evert Pot (http://www.rooftopsolutions.nl/) 
 * @license http://code.google.com/p/sabredav/wiki/License Modified BSD License
 */
class EventEmitter {

    /**
     * List of listeners
     *
     * @see EventEmitter::listeners()
     * @var array 
     */
    protected $listeners = array();

    /**
     * Start listening for an event 
     * 
     * @param string $event 
     * @param callback $listener 
     * @return void
     */
    public function on($event, $listener) {

        $listeners =& $this->listeners($event);
        $listeners[] = $listener;

    }

    /**
     * Removes a listener for a specific event.
     *
     * Note that you must pass the exact same instance of the callback you used 
     * to subscribe to the event to also unsubscribe. 
     * 
     * @param string $event 
     * @param callback $listener
     * @throws \InvalidArgumentException
     * @return void
     */
    public function removeListener($event, $listener) {

        $listeners =& $this->listeners($event);

        foreach($listeners as $k=>$v) {

            if ($v===$listener) {
                unset($listeners[$k]);
                return;
            }

        }
        throw new \InvalidArgumentException('Listener was not attached');

    }

    /**
     * Removes all event listeners for a specific event. 
     * 
     * @param string $event 
     * @return void
     */
    public function removeAllListeners($event) {

        $this->listeners[$event] = array();

    }

    /**
     * Emits an event
     *
     * This method supports an arbitrary number of arguments that will be 
     * passed to the event listeners. 
     * 
     * @param string $event 
     * @return void
     */
    public function emit($event) {

        $args = func_get_args();
        array_shift($args);
        
        $listeners = $this->listeners($event);
        
        array_walk($listeners, function($listener) use ($args) {

            call_user_func_array($listener, $args);    

        }); 

    } 

    /**
     * Returns a list of listeners for an event.
     *
     * The list is simply an array with callbacks. This list is returned by 
     * reference, so it can be freely manipulated.
     * 
     * @param string $event 
     * @return array 
     */
    public function &listeners($event) {

        if (!isset($this->listeners[$event])) {
            $this->listeners[$event] = array();
        }

        return $this->listeners[$event]; 

    }


}

?>
