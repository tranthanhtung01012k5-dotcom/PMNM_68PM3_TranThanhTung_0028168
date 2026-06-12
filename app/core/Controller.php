<?php

class Controller {

    public function model($model) {

        require_once "../app/model/" . $model . ".php";

        return new $model();
    }

    public function view($viewName, $data = []) {
        extract($data);

        ob_start();
        require "../app/views/" . $viewName . ".php";
        $content = ob_get_clean();

        require "../app/views/layout/masterlayout.php";
    }
}

?>