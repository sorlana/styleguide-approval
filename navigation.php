<nav class="nav flex-column">
    <!-- Первый пункт меню -->
    <div class="nav-item">
        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'crud-simple') ? 'active' : ''; ?>" href="?page=crud-simple">
            Типовые формы CRUD простых сущностей
        </a>
        <?php if (isset($_GET['page']) && $_GET['page'] === 'crud-simple'): ?>
            <a class="nav-link nav-link-2 <?php echo (isset($_GET['anchor']) && $_GET['anchor'] === 'section1') ? 'active' : ''; ?>" href="?page=crud-simple&anchor=section1">Создание</a>
            <a class="nav-link nav-link-2 <?php echo (isset($_GET['anchor']) && $_GET['anchor'] === 'section2') ? 'active' : ''; ?>" href="?page=crud-simple&anchor=section2">Редактирование</a>
            <a class="nav-link nav-link-2 <?php echo (isset($_GET['anchor']) && $_GET['anchor'] === 'section3') ? 'active' : ''; ?>" href="?page=crud-simple&anchor=section3">Удаление</a>
        <?php endif; ?>
    </div>
    
    <!-- Второй пункт меню -->
    <div class="nav-item">
        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'error') ? 'active' : ''; ?>" href="?page=error">
            Ошибки и предупреждения
        </a>
        <?php if (isset($_GET['page']) && $_GET['page'] === 'error'): ?>
            <a class="nav-link nav-link-2 <?php echo (isset($_GET['anchor']) && $_GET['anchor'] === 'section1') ? 'active' : ''; ?>" href="?page=error&anchor=section1">Системные ошибки</a>
            <a class="nav-link nav-link-2 <?php echo (isset($_GET['anchor']) && $_GET['anchor'] === 'section2') ? 'active' : ''; ?>" href="?page=error&anchor=section2">Ошибки валидации</a>
            <a class="nav-link nav-link-2 <?php echo (isset($_GET['anchor']) && $_GET['anchor'] === 'section3') ? 'active' : ''; ?>" href="?page=error&anchor=section3">Серверные ошибки и предупреждения</a>
            <a class="nav-link nav-link-2 <?php echo (isset($_GET['anchor']) && $_GET['anchor'] === 'section4') ? 'active' : ''; ?>" href="?page=error&anchor=section4">Бизнес-уведомления</a>
        <?php endif; ?>
    </div>
</nav>