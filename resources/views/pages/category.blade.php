<div class="categoryPage">
    <div class="categoryPage-intro intro">
        <img class="intro-background" src="{{ config('constants.cdn.url').$category['url'] }}" alt="background">
        <div class="container intro-container">
            <div class="intro-info">
                {{
                    view('components.breadcrumbs', ['classname' => 'intro-breadcrumbs', 'data' => [
                        [
                            'name' => 'Главная',
                            'link' => '/',
                        ],
                        [
                            'name' => "Категория “{$category['name']}”",
                            'link' => "/category/{$category['link']}",
                        ],
                    ]]);
                }}
                <div class="intro-title">Обои на тему «{{ $category['name'] }} — бесплатные картинки, фото, фоны</div>
                <div class="intro-desc">Тысячи красивых HD картинок высокого качества, крутые фото и заставки на экран смартфона.</div>
            </div>
        </div>
    </div>
    <div class="homePage-wallpapers wallpapers" data-type_name="category_id" data-type_value="{{ $category['id'] }}">
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
</div>