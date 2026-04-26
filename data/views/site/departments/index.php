<h1>Подразделения</h1>

<button class="btn btn-success" onclick="document.getElementById('createModal').classList.add('active')">Добавить подразделение</button>

<table style="margin-top: 1rem;">
    <thead>
        <tr>
            <th>Название</th>
            <th>Тип</th>
            <th>Количество сотрудников</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($departments as $dept): ?>
        <tr>
            <td><?= htmlspecialchars($dept->name) ?></td>
            <td><?= htmlspecialchars($dept->type) ?></td>
            <td><?= $dept->worker_count ?? 0 ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/departments/' . $dept->id) ?>" class="btn">Просмотреть</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Модальное окно добавления -->
<div id="createModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Добавление подразделения</h2>
            <span class="close" onclick="document.getElementById('createModal').classList.remove('active')">&times;</span>
        </div>
        <form method="post" action="<?= app()->route->getUrl('/departments/create') ?>">
            <input type="hidden" name="csrf_token" value="<?= app()->auth->generateCSRF() ?>">
            <div class="form-group">
                <label>Название *</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Тип *</label>
                <select name="type" required>
                    <option value="teaching">Профессорско-преподавательский состав</option>
                    <option value="support">Учебно-вспомогательный состав</option>
                    <option value="admin">Административно-хозяйственный состав</option>
                    <option value="other">Другое</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Создать</button>
        </form>
    </div>
</div>