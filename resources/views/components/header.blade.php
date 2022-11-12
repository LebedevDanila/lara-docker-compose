<header class="header">
    <div class="header-top">
        <div class="container">
            {{ view('components.logo', ['classname' => 'header-logo']) }}
            <div class="header-search">
                <input type="text" class="header-search__input" placeholder="Поиск обоев">
            </div>
            <div class="header-burgerMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="header-nav">
                <li class="header-nav__elem">
                    <a class="header-text" href="/">
                        По категориям <img class="__DROPDOWN" src="/static/images/headerDropdown.svg" alt="dropdown">
                    </a>
                </li>
                <li class="header-nav__elem">
                    <a class="header-text" href="/">
                        По размеру <img class="__DROPDOWN" src="/static/images/headerDropdown.svg" alt="dropdown">
                    </a>
                </li>
                <li class="header-nav__elem">
                    <a class="header-text" href="/">
                        <img class="__CROWN" src="/static/images/headerCrown.svg" alt="crown"> Топ новинок
                    </a>
                </li>
            </ul>
            <div class="header-languages">
                <div class="header-languages__main header-text">Русский <img class="__DROPDOWN" src="/static/images/headerDropdown.svg" alt="dropdown"></div>
            </div>
            <div class="header-auth">
                <a class="header-auth__elem header-text" href="/">Войти</a>
                <div class="header-auth__separator header-text">|</div>
                <a class="header-auth__elem header-text" href="/">Регистрация</a>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-categories">
                <div class="header-categories__content">
                    @foreach ($data['categories_all']['items'] as $category)
                        <a class="header-categories__elem header-text" href="/category/{{ $category['link'] }}">{{ $category['name'] }}</a>
                    @endforeach
                </div>
                <div class="header-categories__scroll">
                    <img class="header-categories__scroll__icon" src="/static/images/headerArrowRight.svg" alt="arrowRight">
                </div>
            </div>
        </div>
    </div>
    <div class="header-mobileMenu">
        <div class="header-mobileMenu__nav">
            <div class="header-mobileMenu__nav__elem">
                <div class="header-mobileMenu__nav__elem__top">
                    <img class="header-mobileMenu__nav__elem__img" src="/static/images/headerMobileMenuNav1.svg" alt="headerMobileMenuNav1">
                    <div class="header-mobileMenu__nav__elem__text">
                        <span>Главная</span>
                    </div>
                </div>
            </div>
            <div class="header-mobileMenu__nav__elem __ACTIVATED">
                <div class="header-mobileMenu__nav__elem__top">
                    <img class="header-mobileMenu__nav__elem__img" src="/static/images/headerMobileMenuNav2.svg" alt="headerMobileMenuNav1">
                    <div class="header-mobileMenu__nav__elem__text">
                        <span>По категориям</span>
                        <svg class="header-mobileMenu__nav__elem__arrow">
                            <use xlink:href="/static/images/sprites.svg#headerMobileMenuNavArrowRight"></use>
                        </svg>
                    </div>
                </div>
                <div class="header-mobileMenu__nav __SUB">
                    <div class="header-mobileMenu__nav__elem">
                        <div class="header-mobileMenu__nav__elem__top">
                            <div class="header-mobileMenu__nav__elem__text">
                                <span>Главная</span>
                            </div>
                        </div>
                    </div>
                    <div class="header-mobileMenu__nav__elem">
                        <div class="header-mobileMenu__nav__elem__top">
                            <div class="header-mobileMenu__nav__elem__text">
                                <span>По категориям</span>
                            </div>
                        </div>
                    </div>
                    <div class="header-mobileMenu__nav__elem">
                        <div class="header-mobileMenu__nav__elem__top">
                            <div class="header-mobileMenu__nav__elem__text">
                                <span>По размеру</span>
                            </div>
                        </div>
                    </div>
                    <div class="header-mobileMenu__nav__elem">
                        <div class="header-mobileMenu__nav__elem__top">
                            <div class="header-mobileMenu__nav__elem__text">
                                <span>Топ новинок</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-mobileMenu__nav__elem">
                <div class="header-mobileMenu__nav__elem__top">
                    <img class="header-mobileMenu__nav__elem__img" src="/static/images/headerMobileMenuNav3.svg" alt="headerMobileMenuNav1">
                    <div class="header-mobileMenu__nav__elem__text">
                        <span>По размеру</span>
                    </div>
                </div>
            </div>
            <div class="header-mobileMenu__nav__elem">
                <div class="header-mobileMenu__nav__elem__top">
                    <img class="header-mobileMenu__nav__elem__img" src="/static/images/headerMobileMenuNav4.svg" alt="headerMobileMenuNav1">
                    <div class="header-mobileMenu__nav__elem__text">
                        <span>Топ новинок</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-mobileMenu__actions">
            <div class="header-mobileMenu__auth">
                <a class="header-mobileMenu__auth__registration btn __PRIMARY" href="javascript:(void)">
                    <span>Регистрация</span>
                </a>
                <div class="header-mobileMenu__auth__login">
                    У вас уже имеется аккаунт? <a href="javascript:(void)">Войти</a>
                </div>
            </div>
        </div>
    </div>
</header>