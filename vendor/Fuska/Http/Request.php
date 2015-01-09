<?php

namespace Fuska\Http;

class Request {

    /**
     * @var \Fuska\System\ArrayObject
     */
    public $get;

    /**
     * @var \Fuska\System\ArrayObject
     */
    public $post;

    /**
     * @var \Fuska\System\ArrayObject
     */
    public $files;

    /**
     * @var string
     */
    public $query;

    /**
     * @var string
     */
    public $method;

    /**
     * @var boolean
     */
    public $isAjax = false;

    public function __construct() {
        $get = $_GET;
        if (isset($get['d'])) {
            $get+= json_decode($_GET['d'], true);
            unset($get['d']);
        }
        $this->get = new \Fuska\System\ArrayObject($get);
        $post = file_get_contents('php://input');
//        $this->post = new \Fuska\System\ArrayObject($post ? json_decode($post, true) : $_POST);
        $this->post = new \Fuska\System\ArrayObject(count($_POST) ? $_POST : ($post ? json_decode($post, true) : $_POST));
        $this->files = new \Fuska\System\ArrayObject($_FILES);
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $this->isAjax = true;
        }
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function setQuery($queryString) {
        $this->query = $queryString;
        $query = explode('&', $queryString);
        foreach ($query as $item) {
            $get = explode('=', $item);
            $this->get->offsetSet($get[0], $get[1]);
        }
    }

//    public function isPost() {
//        return count($this->post) > 0;
//    }

    public function isPost() {
        return strtoupper($this->method === 'POST');
    }

    public function isDelete() {
        return strtoupper($this->method === 'DELETE');
    }

    public function isPut() {
        return strtoupper($this->method === 'PUT');
    }

    public function isGet() {
        return strtoupper($this->method === 'GET');
    }

    public function isAjax() {
        return $this->isAjax;
    }

}
