<div class="tagPage">
    <div class="homePage-wallpapers wallpapers" data-type_name="tag_id" data-type_value="{{ $tag['id'] }}">
        <div class="container">
            <div class="wallpapers-title">Найдено <?=$wallpapers['count']?> обоев по тегу "<?=$tag['name']?>":</div>
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