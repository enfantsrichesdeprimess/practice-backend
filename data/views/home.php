<h1>Система "Отдел кадров"</h1>

<p>Добро пожаловать в систему учета сотрудников!</p>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 2rem;">
    <div style="background: #ecf0f1; padding: 1.5rem; border-radius: 8px; text-align: center;">
        <h3>Сотрудники</h3>
        <p>Управление кадрами</p>
        <a href="<?= app()->route->getUrl('/workers') ?>" class="btn">Перейти</a>
    </div>
    
    <div style="background: #ecf0f1; padding: 1.5rem; border-radius: 8px; text-align: center;">
        <h3>Подразделения</h3>
        <p>Структура организации</p>
        <a href="<?= app()->route->getUrl('/departments') ?>" class="btn">Перейти</a>
    </div>
</div>