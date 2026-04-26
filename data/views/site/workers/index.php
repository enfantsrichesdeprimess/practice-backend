<h1>Список сотрудников</h1>

<a href="<?= app()->route->getUrl('/workers/create') ?>" class="btn btn-success">Добавить сотрудника</a>

<?php if (!empty($workers) && count($workers) > 0): ?>
<table>
    <thead>
        <tr>
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
            <td><?= htmlspecialchars($worker->surname . ' ' . $worker->name . ' ' . ($worker->last_name ?? '')) ?></td>
            <td><?= $worker->gender === 'male' ? 'М' : 'Ж' ?></td>
            <td><?= date('d.m.Y', strtotime($worker->birthday)) ?></td>
            <td><?= htmlspecialchars($worker->post_name ?? 'Не указана') ?></td>
            <td><?= htmlspecialchars($worker->department_name ?? 'Не назначено') ?></td>
            <td>
                <a href="<?= app()->route->getUrl('/workers/' . $worker->id) ?>" class="btn">Просмотр</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <p style="margin-top: 1rem;">Сотрудники не найдены</p>
<?php endif; ?>