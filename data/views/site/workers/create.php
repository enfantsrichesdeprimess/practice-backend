<h1>Добавление нового сотрудника</h1>

<?php if (!empty($message)): ?>
    <div class="alert alert-danger"><?= $message ?></div>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="csrf_token" value="<?= app()->auth->generateCSRF() ?>">
    
    <div class="form-group">
        <label>Фамилия *</label>
        <input type="text" name="surname" required>
    </div>
    
    <div class="form-group">
        <label>Имя *</label>
        <input type="text" name="name" required>
    </div>
    
    <div class="form-group">
        <label>Отчество</label>
        <input type="text" name="last_name">
    </div>
    
    <div class="form-group">
        <label>Пол *</label>
        <select name="gender" required>
            <option value="">Выберите пол</option>
            <option value="male">Мужской</option>
            <option value="female">Женский</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Дата рождения *</label>
        <input type="date" name="birthday" required>
    </div>
    
    <div class="form-group">
        <label>Должность</label>
        <select name="post_id">
            <option value="">Не указана</option>
            <?php foreach ($posts as $post): ?>
                <option value="<?= $post->id ?>"><?= htmlspecialchars($post->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label>Подразделение</label>
        <select name="department_id">
            <option value="">Не назначено</option>
            <?php foreach ($departments as $dept): ?>
                <option value="<?= $dept->id ?>"><?= htmlspecialchars($dept->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <h3>Адрес</h3>
    <div class="form-group">
        <label>Город</label>
        <input type="text" name="town">
    </div>
    <div class="form-group">
        <label>Улица</label>
        <input type="text" name="home">
    </div>
    <div class="form-group">
        <label>Дом</label>
        <input type="text" name="home_number">
    </div>
    <div class="form-group">
        <label>Квартира</label>
        <input type="text" name="flat">
    </div>
    
    <button type="submit" class="btn btn-success">Сохранить</button>
    <a href="<?= app()->route->getUrl('/workers') ?>" class="btn">Отмена</a>
</form>