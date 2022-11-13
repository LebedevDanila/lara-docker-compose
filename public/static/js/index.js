$(function () {

    /*
    * Header
    **/
    (function () {
        $('.header-burgerMenu').click(function() {
            $('.header-mobileMenu').toggleClass('__ACTIVATED');
        })
    })();

    /*
    * Search
    **/
    (function () {
        const input  = $('.search-input');
        const submit = $('.search-submit');

        function search() {
            const data = {
                query: input.val(),
            };
            $.ajax({
                type: 'POST',
                url: `/search`,
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (response.error) {
                        return alert(response.error.text);
                    }
                    const data = response.data;

                    if ( ! data.length) {
                        return false;
                    }

                    let html = '';
                    $.each(data, (key, row) => {
                        const tag = row.link ? 'a' : 'div';
                        html += `
                            <${tag} class="search-tooltip__item" ${tag === 'a' ? `href="/${row.type}/${row.link}"` : `data-wallpaper_id="${row.id}"`}>
                                <div class="search-tooltip__item__info">
                                    <div class="search-tooltip__item__type">${row.type}</div>
                                    <div class="search-tooltip__item__text">${row.name}</div>
                                </div>
                                <div class="search-tooltip__item__btn"><img src="/static/images/searchArrowRight.svg" alt="searchArrowRight"></div>
                            </${tag}>
                        `;
                    });
                    $('.search-tooltip').empty().append(html).css('display', 'block');
                },
            });
        }

        submit.click(function() {
            if (input.val() === '') {
                return alert('Введите текст запроса');
            }
            search();
        });
        input.on('propertychange input', function() {
            if (input.val() === '') {
                return false;
            }
            search();
        });

    })();
    /*
    * Wallpapers
    **/
    (function () {
        const component  = $('.wallpapers');
        const type_name  = component.data('type_name');
        const type_value = component.data('type_value');
        const content    = $(component.find('.wallpapers-content'));
        let page         = 1;


        $('.wallpapers-more').click(function() {
            const _this = this;

            page++;

            const data = {
                type_name: type_name,
                type_value: type_value,
                page: page,
                order_by: 'id|desc'
            };
            $.ajax({
                type: 'POST',
                url: `/wallpaper/getList`,
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (response.error) {
                        return false;
                    }

                    const paginate = response.data.paginate;
                    const items    = response.data.items;

                    let html = '';
                    $.each(items, (key, row) => {
                        html += `
                            <div class="wallpapers-elem" data-id="${row.id}">
                                <div class="wallpapers-elem__top">
                                    <div class="wallpapers-elem__actionBtn __VIEW">
                                        <img src="/static/images/wallpapersView.svg" alt="view">
                                    </div>
                                    <div class="wallpapers-elem__actionBtn __DOWNLOAD">
                                        <img src="/static/images/wallpapersDownload.svg" alt="download">
                                    </div>
                                </div>
                                <img class="wallpapers-elem__image" src="${APP.cdn + row.url}" alt="wallpaper">
                                <div class="wallpapers-elem__info">
                                    <div class="wallpapers-elem__desc">${row.name}</div>
                                    <div class="wallpapers-elem__statistics">
                                        <div class="wallpapers-elem__data">
                                            <img src="/static/images/wallpapersViews.svg" alt="views">
                                            <span>${row.views}</span>
                                        </div>
                                        <div class="wallpapers-elem__data">
                                            <img src="/static/images/wallpapersDownloads.svg" alt="downloads">
                                            <span>${row.downloads}</span>
                                        </div>
                                        <div class="wallpapers-elem__data">
                                            <img src="/static/images/wallpapersLikes.svg" alt="likes">
                                            <span>${row.likes}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    content.append(html);

                    if (paginate === false) {
                        return $(_this).css('display', 'none');
                    }
                },
            });
        });
    })();

    /*
    * Categories
    **/
    (function () {
        const component = $('.homePage-categories');
        const content   = $(component.find('.homePage-categories__content'));
        let page        = 1;


        $('.homePage-categories__more').click(function() {
            const _this = this;

            page++;

            const data = {
                page: page,
            };
            $.ajax({
                type: 'POST',
                url: `/category/getList`,
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (response.error) {
                        return false;
                    }

                    const paginate = response.data.paginate;
                    const items    = response.data.items;

                    let html = '';
                    $.each(items, (key, row) => {
                        html += `
                            <a class="homePage-categories__elem" href="/category/${row.link}">
                                <img class="homePage-categories__elem__image" src="${APP.cdn + row.url}" alt="category">
                                <div class="homePage-categories__elem__info">
                                    <div class="homePage-categories__elem__title">${row.name}</div>
                                    <div class="homePage-categories__elem__count">${row.count_wallpapers} обоев</div>
                                </div>
                            </a>
                        `;
                    });
                    content.append(html);

                    if (paginate === false) {
                        return $(_this).css('display', 'none');
                    }
                },
            });
        });
    })();

    /*
    * WallpaperModal
    **/
    (function () {
        const component = $('.wallpaperModal');

        $('.wallpapers-content').on('click', '.wallpapers-elem', function() {
            const data = {
                id:  $(this).data('id'),
            };
            $.ajax({
                type: 'POST',
                url: `/wallpaper/get`,
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (response.error) {
                        return alert(response.error.text);
                    }
                    const data = response.data;

                    $('.wallpaperModal-image').empty().append(`<img src="${APP.cdn + data.url}">`);
                    $('.wallpaperModal-text').empty().text(data.name);
                    $('.wallpaperModal-date').text(`Загружено ${getTextFormatDate(data.date_create)}`);
                    $('.wallpaperModal-category').empty().text(data.category_name).attr('href', `/category/${data.category_link}`);
                    $('.wallpaperModal-viewsCount').empty().text(data.views);
                    $('.wallpaperModal-downloadsCount').empty().text(data.downloads);
                    $('.wallpaperModal-likesCount').empty().text(data.likes);
                    $('.wallpaperModal-actions__btn, .wallpaperModal-mobileDownloadBtn').attr('href', `/wallpaper/download?id=${data.id}`);
                    $('.wallpaper-download').attr('href', `/wallpaper/download?id=${data.id}`);

                    let tags_html = '';
                    $.each(data.tags, (key, row) => {
                        tags_html += `
                            <a class="wallpapers-tags__elem" href="/tag/${row.link}"><span>${row.name}</span></a>
                        `;
                    });
                    $('.wallpapers-tags__content').empty().append(tags_html);

                    const similars = $('.wallpaperModal-wallpapers__content');

                    let similars_html = '';
                    $.each(data.similars, (key, row) => {
                        similars_html += `
                            <div class="wallpapers-elem" data-id="${row.id}">
                                <div class="wallpapers-elem__top">
                                    <div class="wallpapers-elem__actionBtn __VIEW">
                                        <img src="/static/images/wallpapersView.svg" alt="view">
                                    </div>
                                    <div class="wallpapers-elem__actionBtn __DOWNLOAD">
                                        <img src="/static/images/wallpapersDownload.svg" alt="download">
                                    </div>
                                </div>
                                <img class="wallpapers-elem__image" src="${APP.cdn + row.url}" alt="wallpaper">
                                <div class="wallpapers-elem__info">
                                    <div class="wallpapers-elem__desc">${row.name}</div>
                                    <div class="wallpapers-elem__statistics">
                                        <div class="wallpapers-elem__data">
                                            <img src="/static/images/wallpapersViews.svg" alt="views">
                                            <span>${row.views}</span>
                                        </div>
                                        <div class="wallpapers-elem__data">
                                            <img src="/static/images/wallpapersDownloads.svg" alt="downloads">
                                            <span>${row.downloads}</span>
                                        </div>
                                        <div class="wallpapers-elem__data">
                                            <img src="/static/images/wallpapersLikes.svg" alt="likes">
                                            <span>${row.likes}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    similars.empty().append(similars_html);
                },
            });
            component.css('display', 'block');
        });

        $('.wallpaperModal-close').click(function(argument) {
            component.css('display', 'none');
        })

        function getTextFormatDate(date_create) {
            const ms     = parseInt(new Date().getTime()/1000);
            const pass   = ms - date_create;
            const months = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
            const time   = new Date(date_create * 1000);
            let date     = time.getDate() + ' ' + months[time.getMonth()] + ' ' + time.getFullYear();
            return date;
        }
    })();
});
