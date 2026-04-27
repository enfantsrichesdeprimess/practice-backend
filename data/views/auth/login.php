<h2>Авторизация</h2>
<?php if (!empty($message)): ?><p style="color:red"><?= $message ?></p><?php endif; ?>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?= app()->auth->generateCSRF() ?>">
    <div class="form-group"><label>Логин</label><input type="text" name="login" required></div>
    <div class="form-group"><label>Пароль</label><input type="password" name="password" required></div>
    <button type="submit" class="btn">Войти</button>
</form>