<?php

require_once '../app/core/controller.php';

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
        $this->view('sinhvien/create', [
            'title' => 'Thêm sinh viên'
        ]);
    }           

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'ma_sv'     => $_POST['ma_sv'] ?? null,
                'ho_ten'    => $_POST['ho_ten'] ?? null,
                'gioi_tinh' => $_POST['gioi_tinh'] ?? null,
                'ngay_sinh' => $_POST['ngay_sinh'] ?? null,
                'dia_chi'   => $_POST['dia_chi'] ?? null,
                'lop'       => $_POST['lop'] ?? null
            ];

            
            if (empty($data['ho_ten'])) {
                $_SESSION['error'] = "Họ tên không được để trống!";
                header('Location: /sinhvien/create');
                exit();
            }

            $sinhvienModel = $this->model('sinhvienModel');
            $result = $sinhvienModel->create($data);

            if ($result) {
                $_SESSION['success'] = 'Thêm sinh viên thành công!';
                header('Location: /sinhvien/index');
                exit();
            } else {
                $_SESSION['error'] = 'Thêm sinh viên thất bại!';
                header('Location: /sinhvien/create');
                exit();
            }
        }
    }
}