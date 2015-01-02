<?php

namespace Fuska\Mvc;

class Model {

    public function normalizeDataToView() {
        $this->recid = $this->getId();
        foreach ($this as &$_input) {
            if ($_input instanceof \DateTime) {
                $_input = $_input->format(\Fuska\App::$config['system']['view']['format']['datetime']);
            }
        }
        return $this;
    }

}
