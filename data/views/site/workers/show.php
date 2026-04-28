<h1><?= htmlspecialchars($worker->fullName()) ?></h1>

<div style="display:grid; grid-template-columns:minmax(220px, 280px) 1fr; gap:1.5rem; align-items:start;">
    <div>
        <?php if (!empty($photo_url)): ?>
            <img src="<?= htmlspecialchars($photo_url) ?>" alt="Фото сотрудника" style="width:100%; max-width:280px; border-radius:8px; object-fit:cover;">
        <?php else: ?>
            <div style="width:100%; max-width:280px; aspect-ratio:1/1; background:#ecf0f1; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#7f8c8d;">
                Фото не загружено
            </div>
        <?php endif; ?>
    </div>

    <div>
        <p><strong>Пол:</strong> <?= $worker->gender === 'male' ? 'Мужской' : 'Женский' ?></p>
        <p style="margin-top:0.75rem;"><strong>Дата рождения:</strong> <?= date('d.m.Y', strtotime($worker->birthday)) ?></p>
        <p style="margin-top:0.75rem;"><strong>Возраст:</strong> <?= $age ?> лет</p>
        <p style="margin-top:0.75rem;"><strong>Должность:</strong> <?= htmlspecialchars($worker->post->name ?? 'Не указана') ?></p>
        <p style="margin-top:0.75rem;"><strong>Подразделения:</strong> <?= htmlspecialchars($worker->departments->pluck('name')->implode(', ') ?: 'Не назначены') ?></p>
        <p style="margin-top:0.75rem;"><strong>Адрес:</strong>
            <?= htmlspecialchars(implode(', ', array_filter([
                $worker->address->town ?? null,
                $worker->address->home ?? null,
                $worker->address->home_number ?? null,
                $worker->address->flat ? 'кв. ' . $worker->address->flat : null,
            ]))) ?: 'Не указан' ?>
        </p>

        <div style="margin-top:1.5rem;">
            <a href="<?= app()->route->getUrl('/workers') ?>" class="btn">Назад к списку</a>
        </div>
    </div>
</div>
