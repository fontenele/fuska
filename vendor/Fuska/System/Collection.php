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
            }
        });
        return $this;
    }

}
