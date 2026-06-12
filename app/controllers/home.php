<?php
require_once '../app/core/Controller.php';

class home extends Controller
{
  public function index()
  {
    $this->view('lauyout/masterlayout',[]);
  }

  public function about()
  {
    echo "Đây là trang giới thiệu";
  }
  public function login()
  {
    require_once '../app/views/home/login.php';

  }
}