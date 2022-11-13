<footer class="footer">
    <div class="container">
        <div class="footer-left">
            {{ view('components.logo', ['classname' => 'footer-logo']) }}
            <div class="footer-info">
                <a class="footer-info__elem __LINK" href="/">Пользовательское соглашение</a>
                <a class="footer-info__elem __LINK" href="/">Политика конфиденциальности</a>
                <div class="footer-info__elem" href="/">Copyright © <?= date('Y') ?> | Обои на телефон</div>
            </div>
        </div>
        <div class="footer-right">
            <div class="footer-block __CATEGORIES">
                <div class="footer-block__title">Категории</div>
                <div class="footer-block__content">
                    <div class="footer-menu">
                        <a class="footer-menu__elem" href="/">Все обои</a>
                        <a class="footer-menu__elem" href="/">По фильмам</a>
                        <a class="footer-menu__elem" href="/">По играм</a>
                        <a class="footer-menu__elem" href="/">Автомобили</a>
                    </div>
                    <div class="footer-menu">
                        <a class="footer-menu__elem" href="/">Все обои</a>
                        <a class="footer-menu__elem" href="/">По фильмам</a>
                        <a class="footer-menu__elem" href="/">По играм</a>
                        <a class="footer-menu__elem" href="/">Автомобили</a>
                    </div>
                    <div class="footer-menu">
                        <a class="footer-menu__elem" href="/">Все обои</a>
                        <a class="footer-menu__elem" href="/">По фильмам</a>
                        <a class="footer-menu__elem" href="/">По играм</a>
                        <a class="footer-menu__elem" href="/">Автомобили</a>
                    </div>
                </div>
            </div>
            <div class="footer-block __NAV">
                <div class="footer-block__title">Навигация</div>
                <div class="footer-block__content">
                    <div class="footer-menu">
                        <a class="footer-menu__elem" href="/">Главная</a>
                        <a class="footer-menu__elem" href="/">Категории</a>
                        <a class="footer-menu__elem" href="/">Контакты</a>
                    </div>
                </div>
            </div>
            <div class="footer-block __SEARCH">
                <div class="footer-block__title">Поиск</div>
                <div class="footer-block__content">
                    <div class="footer-input">
                        <input type="text" placeholder="Поиск обоев">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ view('components.wallpaper') }}
</footer>