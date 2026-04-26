<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отдел кадров</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        header { background: #2c3e50; color: white; padding: 1rem 2rem; }
        nav { display: flex; gap: 2rem; align-items: center; }
        nav a { color: white; text-decoration: none; padding: 0.5rem 1rem; }
        nav a:hover { background: #34495e; border-radius: 4px; }
        main { padding: 2rem; max-width: 1200px; margin: 0 auto; }
        .container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 1.5rem; color: #2c3e50; }
        .btn { display: inline-block; padding: 0.5rem 1rem; background: #3498db; color: white; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn:hover { background: #2980b9; }
        .btn-success { background: #27ae60; }
        .btn-success:hover { background: #219a52; }
        .btn-danger { background: #e74c3c; }
        .btn-danger:hover { background: #c0392b; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #34495e; color: white; }
        tr:hover { background: #f5f5f5; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal.active { display: flex; align-items: center; justify-content: center; }
        .modal-content { background: white; padding: 2rem; border-radius: 8px; min-width: 400px; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .close { font-size: 1.5rem; cursor: pointer; }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="<?= app()->route->getUrl('/') ?>">Отдел кадров</a>
            <a href="<?= app()->route->getUrl('/workers') ?>">Сотрудники</a>
            <a href="<?= app()->route->getUrl('/departments') ?>">Подразделения</a>
            <?php if (app()->auth->check()): ?>
                <span style="margin-left: auto;"><?= app()->auth->user()->name ?? 'Пользователь' ?></span>
                <a href="<?= app()->route->getUrl('/logout') ?>" style="margin-left: 1rem;">Выход</a>
            <?php else: ?>
                <a href="<?= app()->route->getUrl('/login') ?>" style="margin-left: auto;">Вход</a>
            <?php endif; ?>
        </nav>
    </header>
    
    <main>
        <div class="container">
            <?= $content ?? '' ?>
        </div>
    </main>
</body>
</html>