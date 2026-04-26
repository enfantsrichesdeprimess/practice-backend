<h2>Авторизация</h2>

<?php if (!empty($message)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if (!app()->auth->check()): ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?= app()->auth->generateCSRF() ?>">
    <div class="form-group">
        <label>Логин</label>
        <input type="text" name="login" required>
    </div>
    <div class="form-group">
        <label>Пароль</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit" class="btn">Войти</button>
</form>
<?php else: ?>
    <p>Вы уже авторизованы как <?= htmlspecialchars(app()->auth->user()->name) ?></p>
    <a href="<?= app()->route->getUrl('/logout') ?>" class="btn btn-danger">Выйти</a>
<?php endif; ?>
