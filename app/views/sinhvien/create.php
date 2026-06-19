<?php $data['title'] = 'Them sinh vien'; ?>

<div class="page-card">
<h1>Them sinh vien</h1>

<?php if (!empty($data['errors'])): ?>
    <?php foreach ($data['errors'] as $error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endforeach; ?>
<?php endif; ?>

<form action="../sinhvien/create" method="post">
    <?php $lopHocs = $data['lopHocs'] ?? []; ?>
    <?php foreach (($data['columns'] ?? []) as $column): ?>
        <?php
            $field = $column['Field'];
            $type = stripos($column['Type'] ?? '', 'date') !== false ? 'date' : 'text';
            $required = (($column['Null'] ?? 'YES') === 'NO') ? 'required' : '';
            $value = $_POST[$field] ?? '';
        ?>
        <div class="form-group">
            <label for="<?php echo htmlspecialchars($field); ?>">
                <?php echo htmlspecialchars(ucfirst($field)); ?>
            </label>
            <?php if ($field === 'malop'): ?>
                <select
                    id="<?php echo htmlspecialchars($field); ?>"
                    name="<?php echo htmlspecialchars($field); ?>"
                    <?php echo $required; ?>
                >
                    <option value="">Chon lop hoc</option>
                    <?php foreach ($lopHocs as $lopHoc): ?>
                        <?php $selected = ($value === ($lopHoc['malop'] ?? '')) ? 'selected' : ''; ?>
                        <option value="<?php echo htmlspecialchars($lopHoc['malop']); ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars($lopHoc['malop'] . ' - ' . $lopHoc['tenlop']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input
                    type="<?php echo $type; ?>"
                    id="<?php echo htmlspecialchars($field); ?>"
                    name="<?php echo htmlspecialchars($field); ?>"
                    value="<?php echo htmlspecialchars($value); ?>"
                    <?php echo $required; ?>
                >
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <div class="actions">
        <button type="submit">Them</button>
        <a class="button secondary" href="../sinhvien/index">Quay lai</a>
    </div>
</form>
</div>