<h1>Добавление подразделения</h1>

<?php if (!empty($message)): ?>
    <div class="alert alert-danger"><?= $message ?></div>
<?php endif; ?>

<form method="post" action="<?= app()->route->getUrl('/departments/create') ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth->generateCSRF() ?>">
    
    <div class="form-group">
        <label>Название подразделения *</label>
        <input type="text" name="name" required>
    </div>
    
    <div class="form-group">
        <label>Тип подразделения *</label>
        <select name="type" required>
            <option value="">Выберите тип</option>
            <option value="teaching">Профессорско-преподавательский состав</option>
            <option value="support">Учебно-вспомогательный состав</option>
            <option value="admin">Административно-хозяйственный состав</option>
            <option value="other">Другое</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-success">Создать</button>
    <a href="<?= app()->route->getUrl('/departments') ?>" class="btn">Отмена</a>
</form>