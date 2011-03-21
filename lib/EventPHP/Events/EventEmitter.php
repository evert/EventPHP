<?php

namespace EventPHP\Events;

class EventEmitter {

    protected $listeners;

    public function on($event, $listener) {

        $listeners =& $this->listeners($event);
        $listeners[] = $listener;

    }

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
     * Returns a list of listeners for an event.
     *
     * This list is returned by reference, so it can be freely manipulated. 
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

}

?>
