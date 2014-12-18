<?php

namespace Fuska\View;

class Json extends Html {

    public function __construct($vars = array()) {
        parent::__construct($vars);
    }

    public function render() {
        return json_encode($this->getArrayCopy());
    }

}
