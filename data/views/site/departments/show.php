<h1>Подразделение: <?= htmlspecialchars($department->name ?? 'Не найдено') ?></h1>

<p><strong>Тип:</strong> <?= htmlspecialchars($department->type ?? '') ?></p>

<?php if (!empty($avg_age)): ?>
    <div class="alert alert-success">
        <strong>Средний возраст сотрудников:</strong> <?= round($avg_age, 1) ?> лет
    </div>
<?php endif; ?>

<div style="margin: 1rem 0;">
    <a href="<?= app()->route->getUrl('/departments/' . $department->id . '/attach') ?>" class="btn btn-success">
        Прикрепить сотрудника
    </a>
    <a href="<?= app()->route->getUrl('/departments') ?>" class="btn">
        Назад к списку
    </a>
</div>

<?php if (!empty($workers) && count($workers) > 0): ?>
<table>
    <thead>
        <tr>
            <th>ФИО</th>
            <th>Дата рождения</th>
            <th>Возраст</th>
            <th>Должность</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($workers as $worker): ?>
        <tr>
            <td><?= htmlspecialchars($worker->surname . ' ' . $worker->name . ' ' . ($worker->last_name ?? '')) ?></td>
            <td><?= date('d.m.Y', strtotime($worker->birthday)) ?></td>
            <td><?= floor((time() - strtotime($worker->birthday)) / 31556926) ?> лет</td>
            <td><?= htmlspecialchars($worker->post_name ?? 'Не указана') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <p style="margin-top: 1rem;">В этом подразделении нет сотрудников</p>
<?php endif; ?>