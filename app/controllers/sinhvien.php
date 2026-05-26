<?php

require_once '../app/core/Controller.php';

class sinhvien extends Controller
{
    public function index()
    {
        $sinhvienModel = $this->model('sinhvienModel');

        $sinhviens = $sinhvienModel->getAllSinhVien();

        $this->view('sinhvien/index', [
            'sinhviens' => $sinhviens
        ]);
    }

    public function create()
    {
        require_once '../app/views/sinhvien/create.php';
    }
}