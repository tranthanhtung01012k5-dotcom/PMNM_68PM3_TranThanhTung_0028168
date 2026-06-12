<?php
class App
{
  protected $controller = "home";
  protected $action = "index";
  protected $param = [];

  public function __construct()
  {
    $urlProcessed = $this->urlProcess();

    if (isset($urlProcessed[0])) {
      $controllerName = $urlProcessed[0];

      if (file_exists('../app/controllers/' . $controllerName . '.php')) {
        $this->controller = $controllerName;
        unset($urlProcessed[0]);
      }
    }

    require_once '../app/controllers/' . $this->controller . '.php';

    $className = ucfirst($this->controller);
    $this->controller = new $className();

    if (isset($urlProcessed[1])) {
      if (method_exists($this->controller, $urlProcessed[1])) {
        $this->action = $urlProcessed[1];
        unset($urlProcessed[1]);
      }
    }

    $this->param = $urlProcessed ? array_values($urlProcessed) : [];

    call_user_func_array([$this->controller, $this->action], $this->param);
  }

  public function urlProcess()
  {
    if (isset($_GET['url'])) {
      return explode('/', filter_var(trim($_GET['url'], '/')));
    }
  }
}