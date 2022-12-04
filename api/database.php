<?php

final class Database {

    private static $instance;
    private static $data;
    
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // INIT DATABASE
    }

    private function __clone() {
    }

    private function __sleep() {
    }

    private function __wakeup() {

    }

    public function getString($fio, $type) {
        return 'Data: '.$fio.' type: '.$type;
    }
}