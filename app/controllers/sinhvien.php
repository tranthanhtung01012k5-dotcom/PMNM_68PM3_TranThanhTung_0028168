<?php
class sinhvien extends Controller
{
    public function index()
    {
        $sinhvienModel = $this->model('sinhvienModel');
        $limit = 5;
        $filters = [
            'mssv' => trim($_GET['mssv'] ?? ''),
            'hoten' => trim($_GET['hoten'] ?? ''),
            'lop' => trim($_GET['lop'] ?? ''),
        ];
        $lopHocFilters = [
            'malop' => trim($_GET['lophoc_malop'] ?? ''),
        ];
        $sortField = $_GET['sort_field'] ?? 'mssv';
        $sortDirection = $_GET['sort_direction'] ?? 'asc';
        $sort = [
            'field' => in_array($sortField, ['mssv', 'hoten'], true) ? $sortField : 'mssv',
            'direction' => in_array($sortDirection, ['asc', 'desc'], true) ? $sortDirection : 'asc',
        ];
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max($page, 1);
        $totalSinhVien = $sinhvienModel->countSinhVien($filters);
        $totalPages = max((int) ceil($totalSinhVien / $limit), 1);

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $limit;
        $sinhviens = $sinhvienModel->paging($limit, $offset, $filters, $sort);
        $lopHocPage = isset($_GET['lophoc_page']) ? (int) $_GET['lophoc_page'] : 1;
        $lopHocPage = max($lopHocPage, 1);
        $totalLopHoc = $sinhvienModel->countLopHoc($lopHocFilters);
        $totalLopHocPages = max((int) ceil($totalLopHoc / $limit), 1);

        if ($lopHocPage > $totalLopHocPages) {
            $lopHocPage = $totalLopHocPages;
        }

        $lopHocOffset = ($lopHocPage - 1) * $limit;
        $lopHocRows = $sinhvienModel->pagingLopHoc($limit, $lopHocOffset, $lopHocFilters);

        $this->view('sinhvien/index', [
            'sinhviens' => $sinhviens,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'lopHocRows' => $lopHocRows,
            'currentLopHocPage' => $lopHocPage,
            'totalLopHocPages' => $totalLopHocPages,
            'filters' => $filters,
            'lopHocFilters' => $lopHocFilters,
            'sort' => $sort,
            'primaryKey' => $sinhvienModel->getPrimaryKeyColumn(),
            'columns' => $sinhvienModel->getColumns(),
            'lopHocs' => $sinhvienModel->getLopHocList(),
            'dbError' => $sinhvienModel->isConnected() ? '' : 'Chua ket noi duoc database. Hay kiem tra lai username/password trong connectDB.php.',
        ]);
    }

    public function create()
    {
        $sinhvienModel = $this->model('sinhvienModel');
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($sinhvienModel->createSinhVien($_POST)) {
                header('Location: ../sinhvien/index');
                exit();
            }

            $errors[] = 'Khong the them sinh vien. Vui long kiem tra lai du lieu.';
        }

        $this->view('sinhvien/create', [
            'columns' => $sinhvienModel->getEditableColumns(),
            'lopHocs' => $sinhvienModel->getLopHocList(),
            'errors' => $errors,
        ]);
    }

    public function delete()
    {
        $sinhvienModel = $this->model('sinhvienModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            if ($id !== '') {
                $sinhvienModel->deleteSinhVien($id);
            }
        }

        $page = isset($_POST['page']) ? max((int) $_POST['page'], 1) : 1;
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        header('Location: ' . $basePath . '/sinhvien/index?page=' . $page);
        exit();
    }

    public function update()
    {
        $sinhvienModel = $this->model('sinhvienModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            if ($id !== '') {
                $sinhvienModel->updateSinhVien($id, $_POST);
            }
        }

        $page = isset($_POST['page']) ? max((int) $_POST['page'], 1) : 1;
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        header('Location: ' . $basePath . '/sinhvien/index?page=' . $page);
        exit();
    }

    public function createLopHoc()
    {
        $sinhvienModel = $this->model('sinhvienModel');
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$sinhvienModel->createLopHoc($_POST)) {
            $error = '&error=create_lophoc';
        }

        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        header('Location: ' . $basePath . '/sinhvien/index?panel=lophoc' . $error);
        exit();
    }

    public function updateLopHoc()
    {
        $sinhvienModel = $this->model('sinhvienModel');
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            if ($id === '' || !$sinhvienModel->updateLopHoc($id, $_POST)) {
                $error = '&error=update_lophoc';
            }
        }

        $page = isset($_POST['lophoc_page']) ? max((int) $_POST['lophoc_page'], 1) : 1;
        $malop = trim($_POST['lophoc_malop'] ?? '');
        $filterQuery = $malop !== '' ? '&lophoc_malop=' . urlencode($malop) : '';
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        header('Location: ' . $basePath . '/sinhvien/index?panel=lophoc&lophoc_page=' . $page . $filterQuery . $error);
        exit();
    }

    public function deleteLopHoc()
    {
        $sinhvienModel = $this->model('sinhvienModel');
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            if ($id === '' || !$sinhvienModel->deleteLopHoc($id)) {
                $error = '&error=delete_lophoc';
            }
        }

        $page = isset($_POST['lophoc_page']) ? max((int) $_POST['lophoc_page'], 1) : 1;
        $malop = trim($_POST['lophoc_malop'] ?? '');
        $filterQuery = $malop !== '' ? '&lophoc_malop=' . urlencode($malop) : '';
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        header('Location: ' . $basePath . '/sinhvien/index?panel=lophoc&lophoc_page=' . $page . $filterQuery . $error);
        exit();
    }
}