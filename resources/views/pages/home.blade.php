<div class="homePage">
    <div class="homePage-intro intro">
        <img class="intro-background" src="/static/images/homeIntroBackground.png" alt="background">
        <div class="container intro-container">
            <div class="intro-info">
                <div class="intro-title">Бесплатные обои для мобильных телефонов</div>
                <div class="intro-desc">Тысячи красивых HD картинок высокого качества, крутые фото и заставки на экран смартфона.</div>
            </div>
            <div class="homePage-search">
                {{ view('components.search') }}
                <div class="homePage-search__tags">
                    <div class="homePage-search__tags__title">Популярное:</div>
                    <div class="homePage-search__tags__content">
                        <div class="homePage-search__tags__elem">Hi-Tech</div>
                        <div class="homePage-search__tags__elem">Абстракции</div>
                        <div class="homePage-search__tags__elem">digital art</div>
                        <div class="homePage-search__tags__elem">Текстуры</div>
                        <div class="homePage-search__tags__elem">minimalism</div>
                        <div class="homePage-search__tags__elem">Технологии</div>
                        <div class="homePage-search__tags__elem">dark</div>
                        <div class="homePage-search__tags__elem">illustration</div>
                        <div class="homePage-search__tags__elem">artwork</div>
                        <div class="homePage-search__tags__elem">Windows 10</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="homePage-wallpapers wallpapers" data-type_name="all" data-type_value="null">
        <div class="container">
            <div class="wallpapers-nav">
                <div class="wallpapers-nav__info">
                    <div class="wallpapers-nav__info__title">Все обои</div>
                    <div class="wallpapers-nav__info__count">найдено {{ $wallpapers['count'] }} обоев</div>
                </div>
                <div class="wallpapers-nav__sort">
                    <div class="wallpapers-nav__sort__elem">
                        <img class="__ICON" src="/static/images/wallpapersTime.svg" alt="time">
                        <span>За всё время</span>
                        <img class="__DROPDOWN" src="/static/images/wallpapersDropdown.svg" alt="wallpapersDropdown">
                    </div>
                    <div class="wallpapers-nav__sort__elem">
                        <img class="__ICON" src="/static/images/wallpapersMenu.svg" alt="menu">
                        <span>По загрузкам</span>
                        <img class="__DROPDOWN" src="/static/images/wallpapersDropdown.svg" alt="wallpapersDropdown">
                    </div>
                </div>
            </div>
            <div class="homePage-wallpapers__content wallpapers-content">
                @foreach ($wallpapers['items'] as $wallpaper)
                    <div class="wallpapers-elem" data-id="{{ $wallpaper['id'] }}">
                        <div class="wallpapers-elem__top">
                            <div class="wallpapers-elem__actionBtn __VIEW">
                                <img src="/static/images/wallpapersView.svg" alt="view">
                            </div>
                            <div class="wallpapers-elem__actionBtn __DOWNLOAD">
                                <img src="/static/images/wallpapersDownload.svg" alt="download">
                            </div>
                        </div>
                        <img class="wallpapers-elem__image" src="{{ config('constants.cdn.url').$wallpaper['url'] }}" alt="wallpaper">
                        <div class="wallpapers-elem__info">
                            <div class="wallpapers-elem__desc">{{ $wallpaper['name'] }}</div>
                            <div class="wallpapers-elem__statistics">
                                <div class="wallpapers-elem__data">
                                    <img src="/static/images/wallpapersViews.svg" alt="views">
                                    <span>{{ $wallpaper['views'] }}</span>
                                </div>
                                <div class="wallpapers-elem__data">
                                    <img src="/static/images/wallpapersDownloads.svg" alt="downloads">
                                    <span>{{ $wallpaper['downloads'] }}</span>
                                </div>
                                <div class="wallpapers-elem__data">
                                    <img src="/static/images/wallpapersLikes.svg" alt="likes">
                                    <span>{{ $wallpaper['likes'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($wallpapers['paginate'])
                <div class="wallpapers-bottom">
                    <div class="wallpapers-more btn __PRIMARY"><span>Показать еще</span></div>
                    <!-- <div class="wallpapers-pagination">
                        <div class="wallpapers-pagination__content">
                            <div class="wallpapers-pagination__elem __ACTIVE">1</div>
                            <div class="wallpapers-pagination__elem">2</div>
                            <div class="wallpapers-pagination__elem">3</div>
                            <div class="wallpapers-pagination__elem">4</div>
                            <div class="wallpapers-pagination__elem">...</div>
                            <div class="wallpapers-pagination__elem">15</div>
                        </div>
                        <div class="wallpapers-pagination__next wallpapers-pagination__elem">
                            Следующая
                            <img src="/static/images/wallpapersArrowRight.svg" alt="arrowRight">
                        </div>
                    </div> -->
                </div>
            @endif
        </div>
    </div>
    <div class="homePage-categories">
        <div class="homePage-categories__container container">
            <div class="homePage-categories__top">
                <div class="homePage-categories__title">Лучшие заставки на телефон в нашем сервисе</div>
                <div class="homePage-categories__desc">Тысячи бесплатных обоев для любого разрешения</div>
            </div>
            <div class="homePage-categories__info">
                <p>
                    Рыбатекст используется дизайнерами, проектировщиками и фронтендерами, когда нужно быстро заполнить макеты или прототипы содержимым.
                </p>
                <p>
                    Это тестовый контент, который не должен нести никакого смысла, лишь показать наличие самого текста или продемонстрировать типографику в деле. 
                </p>
                <p>
                    Это тестовый контент, который не должен нести никакого смысла, лишь показать наличие самого текста или продемонстрировать типографику в деле.
                </p>
            </div>
            <div class="homePage-categories__content __GRADIENT">
                @foreach ($categories['items'] as $category)
                    <a class="homePage-categories__elem" href="/category/{{ $category['link'] }}">
                        <img class="homePage-categories__elem__image" src="{{ config('constants.cdn.url').$category['url'] }}" alt="category">
                        <div class="homePage-categories__elem__info">
                            <div class="homePage-categories__elem__title">{{ $category['name'] }}</div>
                            <div class="homePage-categories__elem__count">{{ $category['count_wallpapers'] }} обоев</div>
                        </div>
                    </a>
                @endforeach
            </div>
            @if ($categories['paginate'])
                <div class="homePage-categories__more btn __PRIMARY">
                    <span>Показать больше категорий</span>
                </div>
            @endif
        </div>
    </div>
</div>