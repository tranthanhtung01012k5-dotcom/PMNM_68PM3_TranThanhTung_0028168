<?php $sinhviens = $data['sinhviens'] ?? []; ?>
<?php $primaryKey = $data['primaryKey'] ?? ''; ?>
<?php $currentPage = $data['currentPage'] ?? 1; ?>
<?php $columns = $data['columns'] ?? []; ?>
<?php $lopHocs = $data['lopHocs'] ?? []; ?>
<?php $lopHocRows = $data['lopHocRows'] ?? []; ?>
<?php $currentLopHocPage = $data['currentLopHocPage'] ?? 1; ?>
<?php $totalLopHocPages = $data['totalLopHocPages'] ?? 1; ?>
<?php $filters = $data['filters'] ?? ['mssv' => '', 'hoten' => '', 'lop' => '']; ?>
<?php $lopHocFilters = $data['lopHocFilters'] ?? ['malop' => '']; ?>
<?php $sort = $data['sort'] ?? ['field' => 'mssv', 'direction' => 'asc']; ?>
<?php $activePanel = ($_GET['panel'] ?? 'sinhvien') === 'lophoc' ? 'lophoc' : 'sinhvien'; ?>
<?php
    $labels = [
        'mssv' => 'Ma sinh vien',
        'hoten' => 'Ho ten',
        'malop' => 'Ma lop',
        'tenlop' => 'Ten lop',
        'ngaysinh' => 'Ngay sinh',
    ];
?>
<?php $data['title'] = $activePanel === 'lophoc' ? 'Danh sach lop hoc' : 'Danh sach sinh vien'; ?>

<style>
    .dashboard-shell {
        display: grid;
        grid-template-columns: 132px minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }

    .control-panel {
        width: 132px;
        min-height: 240px;
        padding: 10px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
    }

    .control-panel a {
        display: block;
        width: 100%;
        padding: 11px 8px;
        margin-bottom: 8px;
        border: 1px solid transparent;
        border-radius: 6px;
        color: #475569;
        background: transparent;
        text-align: left;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.25;
    }

    .control-panel a.active,
    .control-panel a:hover {
        color: #0f766e;
        border-color: #ccfbf1;
        background: #ecfdf5;
    }

    .dashboard-main {
        min-width: 0;
        padding: 24px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
    }

    .search-form {
        max-width: none;
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 10px;
        align-items: end;
        margin: 0 0 18px;
        padding: 14px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #f8fafc;
    }

    .search-form .form-group {
        margin-bottom: 0;
    }

    .search-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        grid-column: span 1;
    }

    .dashboard-main > h1 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e5eaf2;
    }

    .toolbar {
        justify-content: flex-end;
        margin: 0 0 16px;
    }

    @media (max-width: 640px) {
        .dashboard-shell {
            grid-template-columns: 1fr;
        }

        .control-panel {
            width: 100%;
            min-height: 0;
            display: flex;
            gap: 8px;
        }

        .control-panel a {
            margin-bottom: 0;
            text-align: center;
        }

        .search-form {
            grid-template-columns: 1fr;
        }

        .dashboard-main {
            padding: 16px;
        }
    }
</style>

<div class="dashboard-shell">
    <aside class="control-panel">
        <a class="<?php echo $activePanel === 'sinhvien' ? 'active' : ''; ?>" href="../sinhvien/index?panel=sinhvien">Sinh vien</a>
        <a class="<?php echo $activePanel === 'lophoc' ? 'active' : ''; ?>" href="../sinhvien/index?panel=lophoc">Lop hoc</a>
    </aside>

    <section class="dashboard-main">
        <h1><?php echo $activePanel === 'lophoc' ? 'Danh sach lop hoc' : 'Danh sach sinh vien'; ?></h1>

<?php if (!empty($data['dbError'])): ?>
    <div class="notice"><?php echo htmlspecialchars($data['dbError']); ?></div>
<?php endif; ?>
<?php if (!empty($_GET['error'])): ?>
    <?php
        $errorMessages = [
            'create_lophoc' => 'Khong the them lop hoc. Vui long kiem tra lai ma lop.',
            'update_lophoc' => 'Khong the cap nhat lop hoc. Vui long kiem tra lai du lieu.',
            'delete_lophoc' => 'Khong the xoa lop hoc. Lop nay co the dang co sinh vien.',
        ];
    ?>
    <?php if (isset($errorMessages[$_GET['error']])): ?>
        <div class="error"><?php echo htmlspecialchars($errorMessages[$_GET['error']]); ?></div>
    <?php endif; ?>
<?php endif; ?>

<?php if ($activePanel === 'lophoc'): ?>
    <form class="search-form" action="../sinhvien/index" method="get">
        <input type="hidden" name="panel" value="lophoc">
        <div class="form-group">
            <label for="search-lophoc-malop">Ma lop</label>
            <input
                type="text"
                id="search-lophoc-malop"
                name="lophoc_malop"
                value="<?php echo htmlspecialchars($lopHocFilters['malop'] ?? ''); ?>">
        </div>
        <div class="search-actions">
            <button type="submit">Tim</button>
            <a class="button secondary" href="../sinhvien/index?panel=lophoc">Xoa loc</a>
        </div>
    </form>

    <div class="toolbar">
        <button class="button" type="button" id="openCreateLopHocModal">Them moi</button>
    </div>

    <?php if (!empty($lopHocRows)): ?>
        <table>
            <thead>
                <tr>
                    <th>Ma lop</th>
                    <th>Ten lop</th>
                    <th>Nam hoc</th>
                    <th>Thao tac</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lopHocRows as $lopHoc): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($lopHoc['malop']); ?></td>
                        <td>
                            <a href="../sinhvien/index?panel=sinhvien&lop=<?php echo urlencode($lopHoc['malop']); ?>">
                                <?php echo htmlspecialchars($lopHoc['tenlop']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($lopHoc['namhoc']); ?></td>
                        <td class="action-cell">
                            <button
                                class="button secondary edit-lophoc-button"
                                type="button"
                                data-lophoc="<?php echo htmlspecialchars(json_encode($lopHoc), ENT_QUOTES, 'UTF-8'); ?>">
                                Sua
                            </button>
                            <form class="delete-form" action="../sinhvien/deleteLopHoc" method="post" onsubmit="return confirm('Ban co chac muon xoa lop hoc nay?');">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($lopHoc['malop']); ?>">
                                <input type="hidden" name="lophoc_page" value="<?php echo htmlspecialchars($currentLopHocPage); ?>">
                                <input type="hidden" name="lophoc_malop" value="<?php echo htmlspecialchars($lopHocFilters['malop'] ?? ''); ?>">
                                <button class="button danger" type="submit">Xoa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($totalLopHocPages > 1): ?>
            <?php
                $lopHocQuery = array_filter([
                    'panel' => 'lophoc',
                    'lophoc_malop' => $lopHocFilters['malop'] ?? '',
                ], function ($value) {
                    return $value !== '';
                });
            ?>
            <div class="pagination">
                <?php if ($currentLopHocPage > 1): ?>
                    <?php $lopHocQuery['lophoc_page'] = $currentLopHocPage - 1; ?>
                    <a href="../sinhvien/index?<?php echo htmlspecialchars(http_build_query($lopHocQuery)); ?>">Truoc</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalLopHocPages; $i++): ?>
                    <?php $lopHocQuery['lophoc_page'] = $i; ?>
                    <a class="<?php echo $i === $currentLopHocPage ? 'active' : ''; ?>" href="../sinhvien/index?<?php echo htmlspecialchars(http_build_query($lopHocQuery)); ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentLopHocPage < $totalLopHocPages): ?>
                    <?php $lopHocQuery['lophoc_page'] = $currentLopHocPage + 1; ?>
                    <a href="../sinhvien/index?<?php echo htmlspecialchars(http_build_query($lopHocQuery)); ?>">Sau</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Chua co du lieu lop hoc.</p>
    <?php endif; ?>

    <div class="modal-backdrop" id="createLopHocModal">
        <div class="modal-box">
            <div class="modal-header">
                <h2>Them lop hoc</h2>
                <button class="modal-close" type="button" id="closeCreateLopHocModal">x</button>
            </div>

            <form action="../sinhvien/createLopHoc" method="post">
                <div class="form-group">
                    <label for="create-malop">Ma lop</label>
                    <input type="text" id="create-malop" name="malop" required>
                </div>
                <div class="form-group">
                    <label for="create-tenlop">Ten lop</label>
                    <input type="text" id="create-tenlop" name="tenlop" required>
                </div>
                <div class="form-group">
                    <label for="create-namhoc">Nam hoc</label>
                    <input type="text" id="create-namhoc" name="namhoc">
                </div>

                <div class="actions">
                    <button type="submit">Them</button>
                    <button class="button secondary" type="button" id="cancelCreateLopHocModal">Huy</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-backdrop" id="editLopHocModal">
        <div class="modal-box">
            <div class="modal-header">
                <h2>Chinh sua lop hoc</h2>
                <button class="modal-close" type="button" id="closeEditLopHocModal">x</button>
            </div>

            <form action="../sinhvien/updateLopHoc" method="post">
                <input type="hidden" name="id" id="edit-lophoc-id">
                <input type="hidden" name="lophoc_page" value="<?php echo htmlspecialchars($currentLopHocPage); ?>">
                <input type="hidden" name="lophoc_malop" value="<?php echo htmlspecialchars($lopHocFilters['malop'] ?? ''); ?>">
                <div class="form-group">
                    <label for="edit-lophoc-malop">Ma lop</label>
                    <input type="text" id="edit-lophoc-malop" data-lophoc-field="malop" readonly>
                </div>
                <div class="form-group">
                    <label for="edit-lophoc-tenlop">Ten lop</label>
                    <input type="text" id="edit-lophoc-tenlop" name="tenlop" data-lophoc-field="tenlop" required>
                </div>
                <div class="form-group">
                    <label for="edit-lophoc-namhoc">Nam hoc</label>
                    <input type="text" id="edit-lophoc-namhoc" name="namhoc" data-lophoc-field="namhoc">
                </div>

                <div class="actions">
                    <button type="submit">Luu</button>
                    <button class="button secondary" type="button" id="cancelEditLopHocModal">Huy</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var createModal = document.getElementById('createLopHocModal');
            var editModal = document.getElementById('editLopHocModal');
            var openCreateButton = document.getElementById('openCreateLopHocModal');
            var closeCreateButton = document.getElementById('closeCreateLopHocModal');
            var cancelCreateButton = document.getElementById('cancelCreateLopHocModal');
            var closeEditButton = document.getElementById('closeEditLopHocModal');
            var cancelEditButton = document.getElementById('cancelEditLopHocModal');
            var editId = document.getElementById('edit-lophoc-id');

            function closeCreateModal() {
                createModal.classList.remove('show');
            }

            function closeEditModal() {
                editModal.classList.remove('show');
            }

            openCreateButton.addEventListener('click', function () {
                createModal.classList.add('show');
            });

            closeCreateButton.addEventListener('click', closeCreateModal);
            cancelCreateButton.addEventListener('click', closeCreateModal);
            closeEditButton.addEventListener('click', closeEditModal);
            cancelEditButton.addEventListener('click', closeEditModal);

            document.querySelectorAll('.edit-lophoc-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    var lopHoc = JSON.parse(button.getAttribute('data-lophoc'));
                    editId.value = lopHoc.malop || '';

                    editModal.querySelectorAll('[data-lophoc-field]').forEach(function (input) {
                        var field = input.getAttribute('data-lophoc-field');
                        input.value = lopHoc[field] || '';
                    });

                    editModal.classList.add('show');
                });
            });

            createModal.addEventListener('click', function (event) {
                if (event.target === createModal) {
                    closeCreateModal();
                }
            });

            editModal.addEventListener('click', function (event) {
                if (event.target === editModal) {
                    closeEditModal();
                }
            });
        })();
    </script>
<?php else: ?>
    <form class="search-form" action="../sinhvien/index" method="get">
        <input type="hidden" name="panel" value="sinhvien">
        <div class="form-group">
            <label for="search-mssv">MSSV</label>
            <input
                type="text"
                id="search-mssv"
                name="mssv"
                value="<?php echo htmlspecialchars($filters['mssv'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="search-hoten">Ho ten</label>
            <input
                type="text"
                id="search-hoten"
                name="hoten"
                value="<?php echo htmlspecialchars($filters['hoten'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="search-lop">Lop</label>
            <input
                type="text"
                id="search-lop"
                name="lop"
                value="<?php echo htmlspecialchars($filters['lop'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="sort-field">Sap xep</label>
            <select id="sort-field" name="sort_field">
                <option value="mssv" <?php echo (($sort['field'] ?? '') === 'mssv') ? 'selected' : ''; ?>>Theo MSSV</option>
                <option value="hoten" <?php echo (($sort['field'] ?? '') === 'hoten') ? 'selected' : ''; ?>>Theo ho ten</option>
            </select>
        </div>
        <div class="form-group">
            <label for="sort-direction">Thu tu</label>
            <select id="sort-direction" name="sort_direction">
                <option value="asc" <?php echo (($sort['direction'] ?? '') === 'asc') ? 'selected' : ''; ?>>Tu tren xuong</option>
                <option value="desc" <?php echo (($sort['direction'] ?? '') === 'desc') ? 'selected' : ''; ?>>Tu duoi len</option>
            </select>
        </div>
        <div class="search-actions">
            <button type="submit">Tim</button>
            <a class="button secondary" href="../sinhvien/index?panel=sinhvien">Xoa loc</a>
        </div>
    </form>

    <div class="toolbar">
        <a class="button" href="../sinhvien/create">Them moi</a>
    </div>

<?php if (!empty($sinhviens)): ?>
    <table>
        <thead>
            <tr>
                <?php foreach (array_keys($sinhviens[0]) as $column): ?>
                    <th><?php echo htmlspecialchars($labels[$column] ?? ucfirst($column)); ?></th>
                <?php endforeach; ?>
                <th>Thao tac</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sinhviens as $sinhvien): ?>
                <tr>
                    <?php foreach ($sinhvien as $value): ?>
                        <td><?php echo htmlspecialchars($value); ?></td>
                    <?php endforeach; ?>
                    <td class="action-cell">
                        <?php if ($primaryKey !== '' && isset($sinhvien[$primaryKey])): ?>
                            <button
                                class="button secondary edit-button"
                                type="button"
                                data-sinhvien="<?php echo htmlspecialchars(json_encode($sinhvien), ENT_QUOTES, 'UTF-8'); ?>">
                                Sua
                            </button>
                            <form class="delete-form" action="../sinhvien/delete" method="post" onsubmit="return confirm('Ban co chac muon xoa sinh vien nay?');">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($sinhvien[$primaryKey]); ?>">
                                <input type="hidden" name="page" value="<?php echo htmlspecialchars($currentPage); ?>">
                                <button class="button danger" type="submit">Xoa</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
        $totalPages = $data['totalPages'] ?? 1;
        $searchQuery = array_filter([
            'panel' => 'sinhvien',
            'mssv' => $filters['mssv'] ?? '',
            'hoten' => $filters['hoten'] ?? '',
            'lop' => $filters['lop'] ?? '',
            'sort_field' => $sort['field'] ?? 'mssv',
            'sort_direction' => $sort['direction'] ?? 'asc',
        ], function ($value) {
            return $value !== '';
        });
    ?>
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <?php $searchQuery['page'] = $currentPage - 1; ?>
                <a href="../sinhvien/index?<?php echo htmlspecialchars(http_build_query($searchQuery)); ?>">Truoc</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php $searchQuery['page'] = $i; ?>
                <a class="<?php echo $i === $currentPage ? 'active' : ''; ?>" href="../sinhvien/index?<?php echo htmlspecialchars(http_build_query($searchQuery)); ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <?php $searchQuery['page'] = $currentPage + 1; ?>
                <a href="../sinhvien/index?<?php echo htmlspecialchars(http_build_query($searchQuery)); ?>">Sau</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="modal-backdrop" id="editModal">
        <div class="modal-box">
            <div class="modal-header">
                <h2>Chinh sua sinh vien</h2>
                <button class="modal-close" type="button" id="closeEditModal">x</button>
            </div>

            <form action="../sinhvien/update" method="post">
                <input type="hidden" name="id" id="edit-id">
                <input type="hidden" name="page" value="<?php echo htmlspecialchars($currentPage); ?>">

                <?php foreach ($columns as $columnInfo): ?>
                    <?php $column = $columnInfo['Field']; ?>
                    <?php $isLocked = $column === $primaryKey || strtolower($column) === 'msv'; ?>
                    <div class="form-group">
                        <label for="edit-<?php echo htmlspecialchars($column); ?>"><?php echo htmlspecialchars($labels[$column] ?? ucfirst($column)); ?></label>
                        <?php if ($column === 'malop'): ?>
                            <select
                                id="edit-<?php echo htmlspecialchars($column); ?>"
                                name="<?php echo htmlspecialchars($column); ?>"
                                data-field="<?php echo htmlspecialchars($column); ?>">
                                <option value="">Chon lop hoc</option>
                                <?php foreach ($lopHocs as $lopHoc): ?>
                                    <option value="<?php echo htmlspecialchars($lopHoc['malop']); ?>">
                                        <?php echo htmlspecialchars($lopHoc['malop'] . ' - ' . $lopHoc['tenlop']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <input
                                type="text"
                                id="edit-<?php echo htmlspecialchars($column); ?>"
                                name="<?php echo htmlspecialchars($column); ?>"
                                data-field="<?php echo htmlspecialchars($column); ?>"
                                <?php echo $isLocked ? 'readonly' : ''; ?>>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <div class="actions">
                    <button type="submit">Luu</button>
                    <button class="button secondary" type="button" id="cancelEditModal">Huy</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var modal = document.getElementById('editModal');
            var editId = document.getElementById('edit-id');
            var closeButton = document.getElementById('closeEditModal');
            var cancelButton = document.getElementById('cancelEditModal');
            var primaryKey = <?php echo json_encode($primaryKey); ?>;

            function closeModal() {
                modal.classList.remove('show');
            }

            document.querySelectorAll('.edit-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    var sinhvien = JSON.parse(button.getAttribute('data-sinhvien'));

                    editId.value = sinhvien[primaryKey] || '';

                    modal.querySelectorAll('[data-field]').forEach(function (input) {
                        var field = input.getAttribute('data-field');
                        input.value = sinhvien[field] || '';
                    });

                    modal.classList.add('show');
                });
            });

            closeButton.addEventListener('click', closeModal);
            cancelButton.addEventListener('click', closeModal);

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        })();
    </script>
<?php else: ?>
    <p>Chua co du lieu sinh vien.</p>
<?php endif; ?>
<?php endif; ?>
    </section>
</div>