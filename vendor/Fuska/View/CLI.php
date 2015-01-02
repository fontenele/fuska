<?php

namespace Fuska\View;

class CLI extends \Fuska\System\ArrayObject {

    public function __construct($vars = []) {
        parent::__construct($vars);
    }

    public function render() {
        return "\n";
    }

}
