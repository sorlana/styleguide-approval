<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>SPA приложение</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="./index.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
      .nav-link.active {
        color: #6978A0 !important;
      }
      .nav-link-2.active {
        padding-left: 40px !important;
        color: #6978A0 !important;
        background-color: #EEF1F8;
      }
      h3[id] {
        scroll-margin-top: 80px !important;
      }
      #nav-container .nav-item > .nav-link {
          position: relative;
          padding-right: 30px !important;
      }

      #nav-container .nav-item > .nav-link::after {
          content: '';
          position: absolute;
          right: 10px;
          top: 50%;
          transform: translateY(-50%);
          
          /* Создание стрелки "вправо" с помощью границ */
          width: 0;
          height: 0;
          border-top: 5px solid transparent;
          border-bottom: 5px solid transparent;
          border-left: 5px solid currentColor;
          
          transition: all 0.3s ease;
      }

      #nav-container .nav-item > .nav-link.active::after {
          /* Меняем стрелку "вправо" на "вниз" */
          border-left: 5px solid transparent;
          border-right: 5px solid transparent;
          border-top: 5px solid currentColor;
          border-bottom: none;
      }
      #nav-container .nav-link-2::after {
          display: none !important;
      }
      
      /* Стиль для наблюдаемых секций */
      .observed-section {
        transition: all 0.3s ease;
      }
      
      /* Скрываем заголовок на главной странице */
      .home-page #page-title-header {
        display: none;
      }
    </style>
</head>
<body>
    <header class="fixed-top bg-white shadow-sm">
        <div class="container">
            <div class="d-flex align-items-end">
                <img
                    src="./img/logo/Logo-styleguide.svg"
                    alt="Логотип"
                    class="mr-3 logo"
                    id="logo"
                    style="height: 30px; cursor: pointer;"
                />
                <h2 id="page-title-header" class="mb-0">
                    <?php
                    // Определяем заголовок страницы
                    $pageTitle = "Главная";
                    if (isset($_GET['page']) && $_GET['page'] === 'crud-simple') {
                        $pageTitle = "Типовые формы CRUD простых сущностей";
                    } elseif (isset($_GET['page']) && $_GET['page'] === 'error') {
                        $pageTitle = "Ошибки и предупреждения";
                    }
                    echo $pageTitle;
                    ?>
                </h2>
            </div>
        </div>
    </header>

    <div id="nav-container">
        <?php include_once('navigation.php'); ?>
    </div>

    <div id="content-container">
        <?php
        // Обработка маршрутов
        $contentFile = 'home.php'; // Страница по умолчанию
        $activeAnchor = isset($_GET['anchor']) ? $_GET['anchor'] : null;

        if (isset($_GET['page'])) {
            $requestedPage = $_GET['page'];
            // Безопасно формируем имя файла, убирая любые нежелательные символы
            $sanitizedPage = preg_replace('/[^a-zA-Z0-9_-]/', '', $requestedPage);
            $potentialFile = $sanitizedPage . '.php';
            
            // Проверяем существование файла перед подключением
            if (file_exists($potentialFile)) {
                $contentFile = $potentialFile;
            } else {
                // Если файл не найден, можно показать страницу 404
                $contentFile = '404.php';
            }
        }

        // Подключаем выбранный контент
        include_once($contentFile);
        ?>
    </div>

    <script>
        // JavaScript для обработки якорных ссылок и плавной прокрутки
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($activeAnchor): ?>
                // Прокрутка к якорю, если он указан в URL
                const anchorElement = document.getElementById('<?php echo $activeAnchor; ?>');
                if (anchorElement) {
                    setTimeout(() => {
                        const headerHeight = document.querySelector('header').offsetHeight;
                        const elementPosition = anchorElement.getBoundingClientRect().top + window.pageYOffset;
                        const offsetPosition = elementPosition - headerHeight - 20;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }, 100);
                }
            <?php endif; ?>

            // Обработчик клика по логотипу
            document.getElementById('logo').addEventListener('click', function() {
                // Переходим на главную страницу
                window.location.href = '?page=home';
            });

            // Добавляем класс к body для главной страницы
            const urlParams = new URLSearchParams(window.location.search);
            const currentPage = urlParams.get('page');
            if (!currentPage || currentPage === 'home') {
                document.body.classList.add('home-page');
            }

            // Обновление активного состояния навигации
            function updateActiveState() {
                // Удаляем активный класс со всех ссылок
                document.querySelectorAll('.nav-link.active').forEach(link => {
                    link.classList.remove('active');
                });
                
                // Получаем текущие параметры из URL
                const urlParams = new URLSearchParams(window.location.search);
                const currentPage = urlParams.get('page') || 'home';
                const currentAnchor = urlParams.get('anchor') || '';
                
                // Обновляем активное состояние для всех ссылок
                document.querySelectorAll('.nav-link').forEach(link => {
                    const href = link.getAttribute('href');
                    if (href && href.includes('?')) {
                        const urlSearchParams = new URLSearchParams(href.split('?')[1]);
                        const linkPage = urlSearchParams.get('page');
                        const linkAnchor = urlSearchParams.get('anchor');
                        
                        if (linkPage === currentPage) {
                            if (!linkAnchor || linkAnchor === currentAnchor) {
                                link.classList.add('active');
                            }
                        }
                    }
                });
                
                // Обновляем класс body для главной страницы
                if (!currentPage || currentPage === 'home') {
                    document.body.classList.add('home-page');
                } else {
                    document.body.classList.remove('home-page');
                }
            }

            // Инициализация Intersection Observer для отслеживания видимости секций
            function initScrollObserver() {
                const sections = document.querySelectorAll('h2[id], h3[id], h4[id], section[id]');
                const headerHeight = document.querySelector('header').offsetHeight;
                
                // Создаем наблюдатель
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Когда секция становится видимой
                            const sectionId = entry.target.getAttribute('id');
                            
                            // Обновляем активные классы у ссылок второго уровня
                            document.querySelectorAll('.nav-link-2').forEach(link => {
                                link.classList.remove('active');
                                const href = link.getAttribute('href');
                                if (href && href.includes('anchor=')) {
                                    const urlSearchParams = new URLSearchParams(href.split('?')[1]);
                                    const linkAnchor = urlSearchParams.get('anchor');
                                    
                                    if (linkAnchor === sectionId) {
                                        link.classList.add('active');
                                    }
                                }
                            });
                        }
                    });
                }, {
                    rootMargin: `-${headerHeight + 20}px 0px -${window.innerHeight - headerHeight - 100}px 0px`,
                    threshold: 0
                });
                
                // Начинаем наблюдение за всеми секциями
                sections.forEach(section => {
                    observer.observe(section);
                });
            }

            updateActiveState();
            
            // Обработка кликов по навигационным ссылкам
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href && href.includes('?')) {
                        const urlSearchParams = new URLSearchParams(href.split('?')[1]);
                        const page = urlSearchParams.get('page');
                        const anchor = urlSearchParams.get('anchor');
                        
                        // Если это переход на ту же страницу с другим якорем
                        if (page === "<?php echo isset($_GET['page']) ? $_GET['page'] : 'home'; ?>") {
                            e.preventDefault();
                            
                            if (anchor) {
                                const targetElement = document.getElementById(anchor);
                                if (targetElement) {
                                    const headerHeight = document.querySelector('header').offsetHeight;
                                    const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                                    const offsetPosition = elementPosition - headerHeight - 20;

                                    window.scrollTo({
                                        top: offsetPosition,
                                        behavior: 'smooth'
                                    });
                                    
                                    // Обновляем URL без перезагрузки страницы
                                    const newUrl = `?page=${page}&anchor=${anchor}`;
                                    history.pushState(null, null, newUrl);
                                    updateActiveState();
                                }
                            }
                        }
                    }
                });
            });

            // Обработка кнопок назад/вперед в браузере
            window.addEventListener('popstate', function() {
                updateActiveState();
                
                // Прокрутка к якорю при навигации по истории
                const urlParams = new URLSearchParams(window.location.search);
                const anchor = urlParams.get('anchor');
                if (anchor) {
                    const anchorElement = document.getElementById(anchor);
                    if (anchorElement) {
                        setTimeout(() => {
                            const headerHeight = document.querySelector('header').offsetHeight;
                            const elementPosition = anchorElement.getBoundingClientRect().top + window.pageYOffset;
                            const offsetPosition = elementPosition - headerHeight - 20;

                            window.scrollTo({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });
                        }, 100);
                    }
                }
            });

            // Инициализация наблюдателя при загрузке
            initScrollObserver();
        });
    </script>
</body>
</html>