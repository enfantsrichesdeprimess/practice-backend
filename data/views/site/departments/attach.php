<h1>Прикрепление сотрудников к подразделению</h1>
<h2><?= htmlspecialchars($department->name) ?></h2>

<form method="post" action="<?= app()->route->getUrl('/departments/' . $department->id . '/attach') ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth->generateCSRF() ?>">
    
    <div class="form-group">
        <label>Выберите сотрудников:</label>
        <?php foreach ($available_workers as $worker): ?>
        <div style="margin: 0.5rem 0;">
            <label>
                <input type="checkbox" name="workers[]" value="<?= $worker->id ?>">
                <?= htmlspecialchars($worker->surname . ' ' . $worker->name . ' ' . ($worker->last_name ?? '')) ?>
            </label>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="submit" class="btn btn-success">Прикрепить</button>
    <a href="<?= app()->route->getUrl('/departments/' . $department->id) ?>" class="btn">Отмена</a>
</form>