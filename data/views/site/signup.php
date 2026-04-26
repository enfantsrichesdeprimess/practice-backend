<h2>Регистрация нового пользователя</h2>

<?php if (!empty($message)): ?>
    <div class="alert alert-danger"><?= $message ?></div>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="csrf_token" value="<?= app()->auth->generateCSRF() ?>">
    <div class="form-group">
        <label>Имя</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label>Логин</label>
        <input type="text" name="login" required>
    </div>
    <div class="form-group">
        <label>Пароль</label>
        <input type="password" name="password" required>
    </div>
    <div class="form-group">
        <label>Роль</label>
        <select name="role">
            <option value="hr">HR-сотрудник</option>
            <option value="admin">Администратор</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Зарегистрироваться</button>
</form>

<p style="margin-top: 1rem;">
    <a href="<?= app()->route->getUrl('/login') ?>">Уже есть аккаунт? Войти</a>
</p>