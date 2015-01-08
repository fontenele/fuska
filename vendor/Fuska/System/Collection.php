<?php

namespace Fuska\System;

class Collection extends \Doctrine\Common\Collections\ArrayCollection {

    public function normalizeDataToGrid() {
        $this->map(function($item) {
            $item->recid = $item->getId();
            foreach ($item as &$_input) {
                if ($_input instanceof \DateTime) {
                    $_input = $_input->format(\Fuska\App::$config['system']['view']['format']['datetime']);
                }
                if ($_input instanceof \Fuska\Mvc\Model) {
                    $_input = $_input->loadData();
                    $_input = json_decode(json_encode($_input), 1);
                    unset($_input['__initializer__']);
                    unset($_input['__cloner__']);
                    unset($_input['__isInitialized__']);
                }
            }
        });
        return $this;
    }

}
