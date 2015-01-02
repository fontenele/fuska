<?php

namespace Fuska\System;

class DateTime extends \DateTime {

    public function __toString() {
        return $this->format('d/m/Y h:i:s');
    }

}
