<?php
class sinhvienModel
{
    private $table = 'sinhvien';
    private $classTable = 'lophoc';
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB::Connect();
    }

    public function isConnected()
    {
        return $this->conn !== null;
    }

    public function getAllSinhVien()
    {
        if (!$this->conn) {
            return [];
        }

        $sql = $this->getSinhVienSelectSql();
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paging($limit = 5, $offset = 0, $filters = [], $sort = [])
    {
        if (!$this->conn) {
            return [];
        }

        $whereData = $this->buildSinhVienSearchWhere($filters);
        $sql = $this->getSinhVienSelectSql($whereData['where'], $sort) . " LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);

        foreach ($whereData['params'] as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSinhVien($filters = [])
    {
        if (!$this->conn) {
            return 0;
        }

        $whereData = $this->buildSinhVienSearchWhere($filters);
        $sql = "SELECT COUNT(*)
                FROM " . $this->table . " sv
                LEFT JOIN " . $this->classTable . " lh ON sv.malop = lh.malop" . $whereData['where'];
        $stmt = $this->conn->prepare($sql);

        foreach ($whereData['params'] as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function getColumns()
    {
        if (!$this->conn) {
            return [];
        }

        $stmt = $this->conn->query("DESCRIBE " . $this->table);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPrimaryKeyColumn()
    {
        foreach ($this->getColumns() as $column) {
            if (($column['Key'] ?? '') === 'PRI') {
                return $column['Field'];
            }
        }

        return '';
    }

    public function getEditableColumns()
    {
        return array_values(array_filter($this->getColumns(), function ($column) {
            return stripos($column['Extra'] ?? '', 'auto_increment') === false;
        }));
    }

    public function getUpdatableColumns()
    {
        $primaryKey = $this->getPrimaryKeyColumn();

        return array_values(array_filter($this->getColumns(), function ($column) use ($primaryKey) {
            $field = $column['Field'] ?? '';

            if ($field === $primaryKey) {
                return false;
            }

            if (strtolower($field) === 'msv') {
                return false;
            }

            return stripos($column['Extra'] ?? '', 'auto_increment') === false;
        }));
    }

    public function getLopHocList()
    {
        if (!$this->conn) {
            return [];
        }

        $sql = "SELECT malop, tenlop, namhoc FROM " . $this->classTable . " ORDER BY malop";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function pagingLopHoc($limit = 5, $offset = 0, $filters = [])
    {
        if (!$this->conn) {
            return [];
        }

        $whereData = $this->buildLopHocSearchWhere($filters);
        $sql = "SELECT malop, tenlop, namhoc FROM " . $this->classTable . $whereData['where'] . " ORDER BY malop LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);

        foreach ($whereData['params'] as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countLopHoc($filters = [])
    {
        if (!$this->conn) {
            return 0;
        }

        $whereData = $this->buildLopHocSearchWhere($filters);
        $sql = "SELECT COUNT(*) FROM " . $this->classTable . $whereData['where'];
        $stmt = $this->conn->prepare($sql);

        foreach ($whereData['params'] as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function createLopHoc($data)
    {
        if (!$this->conn) {
            return false;
        }

        $lopHocData = [
            'malop' => trim($data['malop'] ?? ''),
            'tenlop' => trim($data['tenlop'] ?? ''),
            'namhoc' => trim($data['namhoc'] ?? ''),
        ];

        if ($lopHocData['malop'] === '' || $lopHocData['tenlop'] === '') {
            return false;
        }

        $sql = "INSERT INTO " . $this->classTable . " (malop, tenlop, namhoc)
                VALUES (:malop, :tenlop, :namhoc)";
        $stmt = $this->conn->prepare($sql);

        try {
            return $stmt->execute($lopHocData);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateLopHoc($id, $data)
    {
        if (!$this->conn || $id === '') {
            return false;
        }

        $lopHocData = [
            'tenlop' => trim($data['tenlop'] ?? ''),
            'namhoc' => trim($data['namhoc'] ?? ''),
            'id' => $id,
        ];

        if ($lopHocData['tenlop'] === '') {
            return false;
        }

        $sql = "UPDATE " . $this->classTable . "
                SET tenlop = :tenlop, namhoc = :namhoc
                WHERE malop = :id";
        $stmt = $this->conn->prepare($sql);

        try {
            return $stmt->execute($lopHocData);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteLopHoc($id)
    {
        if (!$this->conn || $id === '') {
            return false;
        }

        $sql = "DELETE FROM " . $this->classTable . " WHERE malop = :id";
        $stmt = $this->conn->prepare($sql);

        try {
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function createSinhVien($data)
    {
        if (!$this->conn) {
            return false;
        }

        $columns = array_column($this->getEditableColumns(), 'Field');
        $insertData = [];

        foreach ($columns as $column) {
            if (array_key_exists($column, $data)) {
                $insertData[$column] = trim($data[$column]);
            }
        }

        if (empty($insertData)) {
            return false;
        }

        $fieldNames = array_keys($insertData);
        $placeholders = array_map(function ($field) {
            return ':' . $field;
        }, $fieldNames);

        $quotedFields = array_map(function ($field) {
            return '`' . str_replace('`', '``', $field) . '`';
        }, $fieldNames);

        $sql = "INSERT INTO " . $this->table . " (" . implode(', ', $quotedFields) . ")
                VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute($insertData);
    }

    public function deleteSinhVien($id)
    {
        if (!$this->conn) {
            return false;
        }

        $primaryKey = $this->getPrimaryKeyColumn();

        if ($primaryKey === '') {
            return false;
        }

        $quotedPrimaryKey = '`' . str_replace('`', '``', $primaryKey) . '`';
        $sql = "DELETE FROM " . $this->table . " WHERE " . $quotedPrimaryKey . " = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    public function updateSinhVien($id, $data)
    {
        if (!$this->conn) {
            return false;
        }

        $primaryKey = $this->getPrimaryKeyColumn();

        if ($primaryKey === '' || $id === '') {
            return false;
        }

        $columns = array_column($this->getUpdatableColumns(), 'Field');
        $updateData = [];

        foreach ($columns as $column) {
            if (array_key_exists($column, $data)) {
                $updateData[$column] = trim($data[$column]);
            }
        }

        if (empty($updateData)) {
            return false;
        }

        $setParts = array_map(function ($field) {
            $quotedField = '`' . str_replace('`', '``', $field) . '`';
            return $quotedField . ' = :' . $field;
        }, array_keys($updateData));

        $quotedPrimaryKey = '`' . str_replace('`', '``', $primaryKey) . '`';
        $sql = "UPDATE " . $this->table . " SET " . implode(', ', $setParts) . " WHERE " . $quotedPrimaryKey . " = :id";
        $stmt = $this->conn->prepare($sql);
        $updateData['id'] = $id;

        return $stmt->execute($updateData);
    }

    private function buildSinhVienSearchWhere($filters)
    {
        $conditions = [];
        $params = [];

        $mssv = trim($filters['mssv'] ?? '');
        $hoten = trim($filters['hoten'] ?? '');
        $lop = trim($filters['lop'] ?? '');

        if ($mssv !== '') {
            $conditions[] = 'sv.mssv LIKE :mssv';
            $params[':mssv'] = '%' . $mssv . '%';
        }

        if ($hoten !== '') {
            $conditions[] = 'sv.hoten LIKE :hoten';
            $params[':hoten'] = '%' . $hoten . '%';
        }

        if ($lop !== '') {
            $conditions[] = '(sv.malop LIKE :lop OR lh.tenlop LIKE :lop)';
            $params[':lop'] = '%' . $lop . '%';
        }

        return [
            'where' => empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions),
            'params' => $params,
        ];
    }

    private function buildLopHocSearchWhere($filters)
    {
        $malop = trim($filters['malop'] ?? '');

        if ($malop === '') {
            return [
                'where' => '',
                'params' => [],
            ];
        }

        return [
            'where' => ' WHERE malop LIKE :malop',
            'params' => [
                ':malop' => '%' . $malop . '%',
            ],
        ];
    }

    private function getSinhVienOrderBy($sort)
    {
        $fieldMap = [
            'mssv' => 'sv.mssv',
            'hoten' => 'sv.hoten',
        ];
        $field = $sort['field'] ?? 'mssv';
        $direction = strtoupper($sort['direction'] ?? 'ASC');

        if (!isset($fieldMap[$field])) {
            $field = 'mssv';
        }

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'ASC';
        }

        return ' ORDER BY ' . $fieldMap[$field] . ' ' . $direction . ', sv.mssv ASC';
    }

    private function getSinhVienSelectSql($where = '', $sort = [])
    {
        return "SELECT sv.*, lh.tenlop
                FROM " . $this->table . " sv
                LEFT JOIN " . $this->classTable . " lh ON sv.malop = lh.malop" . $where . "
                " . $this->getSinhVienOrderBy($sort);
    }
}