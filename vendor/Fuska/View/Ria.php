<?php

namespace Fuska\View;

class Ria extends Json {

    public function render() {

        return json_encode([
            'result' => $this->getArrayCopy(),
            'files' => $this->loadJsAndCssFiles(\Fuska\App::$router->getController(), \Fuska\App::$router->getAction())
        ]);
    }

}
