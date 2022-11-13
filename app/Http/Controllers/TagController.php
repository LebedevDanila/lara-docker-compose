<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WallpaperService;
use App\Services\CategoryService;
use App\Services\TagService;

class TagController extends BaseController
{

    public function __construct(WallpaperService $wallpaper_service, CategoryService $category_service, TagService $tag_service)
    {
        $this->wallpaper_service = $wallpaper_service;
        $this->category_service  = $category_service;
        $this->tag_service       = $tag_service;
    }

    public function index($link = '')
    {
        $this->data['view_file'] = 'tag';

        $this->data['categories_all'] = $this->category_service->getList();

        $tag = $this->tag_service->get([
            'link' => $link,
        ]);
        if (isset($tag['error'])) {
            return abort(403, $tag['error']['message']);
        }
        $this->data['tag'] = $tag;

        $wallpapers = $this->wallpaper_service->getList([
            'type'     => ['name' => 'tag_id', 'value' => $tag['id']],
            'page'     => 1,
            'order_by' => 'id|desc',
        ]);
        if (isset($wallpapers['error'])) {
            return abort(403, $wallpapers['error']['message']);
        }
        $this->data['wallpapers'] = $wallpapers;

        return view('index', ['data' => $this->data]);
    }

}
