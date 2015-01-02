<?php

namespace Fuska\View;

class Json extends Html {

    public function __construct($vars = []) {
        parent::__construct($vars);
    }

    public function render() {
        return json_encode($this->getArrayCopy());
    }

    public static function createWithArrayOrObject($arrayOrObject) {
        $view = new Json;
        $view->exchangeArray($arrayOrObject);
        return $view;
    }

}
