<h1>Список сотрудников</h1>

<div style="display:flex; justify-content:space-between; gap:1rem; align-items:flex-end; flex-wrap:wrap; margin-bottom:1rem;">
    <form method="get" action="<?= app()->route->getUrl('/workers') ?>" style="display:flex; gap:0.75rem; flex-wrap:wrap; align-items:flex-end;">
        <div class="form-group" style="margin-bottom:0; min-width:220px;">
            <label>Поиск по ФИО</label>
            <input type="text" name="q" value="<?= htmlspecialchars($filters['q'] ?? '') ?>" placeholder="Фамилия, имя или отчество">
        </div>
        <div class="form-group" style="margin-bottom:0; min-width:220px;">
            <label>Подразделение</label>
            <select name="department_id">
                <option value="">Все подразделения</option>
                <?php foreach ($departments as $department): ?>
                    <option value="<?= $department->id ?>" <?= (string)$department->id === ($filters['department_id'] ?? '') ? 'selected' : '' ?>>
                        <?= htmlspecialchars($department->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn">Найти</button>
    </form>

    <a href="<?= app()->route->getUrl('/workers/create') ?>" class="btn btn-success">Добавить сотрудника</a>
</div>

<?php if (!empty($workers) && count($workers) > 0): ?>
<table>
    <thead>
        <tr>
            <th>Фото</th>
            <th>ФИО</th>
            <th>Пол</th>
            <th>Дата рождения</th>
            <th>Должность</th>
            <th>Подразделение</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($workers as $worker): ?>
        <tr>
            <td>
                <?php if ($worker->photoUrl()): ?>
                    <img src="<?= htmlspecialchars($worker->photoUrl()) ?>" alt="Фото сотрудника" style="width:56px; height:56px; object-fit:cover; border-radius:6px;">
                <?php else: ?>
                    <div style="width:56px; height:56px; background:#ecf0f1; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#7f8c8d;">-</div>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($worker->fullName()) ?></td>
            <td><?= $worker->gender === 'male' ? 'М' : 'Ж' ?></td>
            <td><?= date('d.m.Y', strtotime($worker->birthday)) ?></td>
            <td><?= htmlspecialchars($worker->post->name ?? 'Не указана') ?></td>
            <td><?= htmlspecialchars($worker->departments->pluck('name')->implode(', ') ?: 'Не назначено') ?></td>
            <td><a href="<?= app()->route->getUrl('/workers/' . $worker->id) ?>" class="btn">Открыть</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <p style="margin-top: 1rem;">Сотрудники не найдены</p>
<?php endif; ?>
