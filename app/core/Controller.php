<?php
class Controller {
    public function view($view, $data = []) {
        $file = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            die("View tidak ditemukan: " . $file);
        }
    }
}