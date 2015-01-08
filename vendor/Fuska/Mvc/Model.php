<?php

namespace Fuska\Mvc;

class Model {

    public function __construct($attributes = []) {
        foreach ($attributes as $index => $val) {
            $this->{$index} = $val;
        }
    }

    public function normalizeDataToView() {
        $this->recid = $this->getId();
        foreach ($this as $i => &$_input) {
            if ($_input instanceof \DateTime) {
                $_input = $_input->format(\Fuska\App::$config['system']['view']['format']['datetime']);
            }
            if ($_input instanceof Model) {
                $_input = $_input->loadData();
                $_input = json_decode(json_encode($_input), 1);
                unset($_input['__initializer__']);
                unset($_input['__cloner__']);
                unset($_input['__isInitialized__']);
            }
        }
        return $this;
    }

    public function loadData() {
        $this->__load();
        return $this;
    }

}
