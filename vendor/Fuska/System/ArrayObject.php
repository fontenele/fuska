<?php

namespace Fuska\System;

class ArrayObject extends \ArrayObject {

    public function __construct($array = []) {
        parent::__construct($array);
        $this->setFlags(\ArrayObject::STD_PROP_LIST | \ArrayObject::ARRAY_AS_PROPS);
    }

    public function offsetGet($index) {
        return $this->offsetExists($index) ? parent::offsetGet($index) : null;
    }

    public function __get($name) {
        return $this->offsetExists($name) ? $this->offsetGet($name) : '';
    }

    public function __set($name, $value = null) {
        $this->offsetSet($name, $value);
        return $this;
    }

    public function exchangeArray($input = null) {
        if (!$input) {
            return $this;
        }
        foreach ($input as &$_input) {
            if ($_input instanceof \DateTime) {
                $_input = $_input->format(\Fuska\App::$config['system']['view']['format']['datetime']);
            }
        }
        parent::exchangeArray($input);
        return $this;
    }

}
