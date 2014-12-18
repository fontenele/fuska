<?php

namespace Fuska\View;

class Messenger {

    public static function success($message) {
        $session = new \Fuska\System\Session('__Fu5k4M3553ng3r__');
        $success = $session->success;
        $success[] = $message;
        $session->success = $success;
    }

    public static function error($message) {
        $session = new \Fuska\System\Session('__Fu5k4M3553ng3r__');
        $error = $session->error;
        $error[] = $message;
        $session->error = $error;
    }

    public static function getSuccess() {
        $session = new \Fuska\System\Session('__Fu5k4M3553ng3r__');
        $success = $session->success ? $session->success : [];
        $session->success = [];
        return $success;
    }

    public static function getError() {
        $session = new \Fuska\System\Session('__Fu5k4M3553ng3r__');
        $error = $session->error ? $session->error : [];
        $session->error = [];
        return $error;
    }

}
