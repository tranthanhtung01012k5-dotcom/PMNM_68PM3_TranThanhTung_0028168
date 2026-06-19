<?php $data['title'] = 'Dang nhap'; ?>

<h1>Login</h1>

<?php if (!empty($data['error'])): ?>
    <div class="error"><?php echo htmlspecialchars($data['error']); ?></div>
<?php endif; ?>

<form action="" method="POST">
    <div class="form-group">
        <label for="username">UserName:</label>
        <input type="text" id="username" name="username" placeholder="userName">
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="password">
    </div>

    <div class="actions">
        <button type="submit">Login</button>
    </div>
</form>