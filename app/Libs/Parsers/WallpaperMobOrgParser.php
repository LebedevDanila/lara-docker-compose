<?php

namespace App\Libs\Parsers;

use App\Libs\Utils\Output;
use App\Libs\Utils\Curl;
use App\Helpers\GeneralHelper;
use PHPHtmlParser\Dom;

class WallpaperMobOrgParser
{
    public function __construct($params = [])
    {
        $this->global = [
            'tag'   => null,
            'page'  => null,
            'count' => 0,
            'max'   => isset($params['max']) ? $params['max'] : null,
        ];
    }

    public function run($tag = '')
    {
        $response = [];
        $html     = (new Curl())->send("https://ru.wallpaper.mob.org/gallery/tag={$tag}/");
        $dom      = (new Dom)->loadStr($html);

        // получаем данные для пагинации в дальнейшем
        $container            = $dom->find('#page-images-gallery');
        $this->global['tag']  = (int)$container->getAttribute('data-tag');
        $this->global['page'] = (int)$container->getAttribute('data-page');

        // получаем элементы на первой странице
        $response = array_merge($response, $this->getImages($dom));

        // проходим пагинацию
        while (true) {
            $this->global['page'] += 1;

            if ($this->global['max'] !== null && $this->global['count'] >= $this->global['max']) {
                break;
            }

            $post = [
                'page' => $this->global['page'],
                'tag'  => $this->global['tag'],
            ];
            $html = (new Curl())->send("https://ru.wallpaper.mob.org/getGallery/", $post);
            if ($html === '') {
                break;
            }
            $dom = (new Dom)->loadStr($html);
            $response = array_merge($response, $this->getImages($dom));
        }

        return Output::collection($response);
    }

    private function getImages($dom)
    {
        $response = [];

        $images = $dom->find('.image-gallery-image__image');
        foreach ($images as $image) {
            if ($this->global['max'] !== null && $this->global['count'] >= $this->global['max']) {
                break;
            }
            $this->global['count']++;

            $url = $image->getAttribute('src') !== null ? $image->getAttribute('src') : $image->getAttribute('data-src');

            $alt = $image->getAttribute('alt');
            preg_match('#\.\sСкачать\s(.*)\sкартинки\sбесплатно#Us', $alt, $matches);
            $tags = explode(', ', $matches[1]);
            shuffle($tags);

            $response[] = [
                'url'   => $url,
                'tags'  => $tags,
            ];
        }

        return Output::collection($response);
    }
}
