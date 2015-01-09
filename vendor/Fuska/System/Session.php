<?php

namespace Fuska\System;

class Session extends ArrayObject {

    public $container;

    public function __construct($container) {
        $this->container = $container;
        if (!isset($_SESSION[$container])) {
            $this->clear();
        } else {
            parent::__construct($_SESSION[$container]);
        }
    }

    public function offsetSet($name, $value = null) {
        $_SESSION[$this->container][$name] = serialize($value);
        parent::offsetSet($name, $value);
    }

    public function offsetUnset($index) {
        if (parent::offsetExists($index)) {
            unset($_SESSION[$this->container][$index]);
        }
        parent::offsetUnset($index);
    }

    public function offsetGet($index) {
        return unserialize(parent::offsetGet($index));
    }

    public function clear() {
        $_SESSION[$this->container] = [];
        $this->exchangeArray([]);
    }

    public static function create() {
        session_start();
    }

}
