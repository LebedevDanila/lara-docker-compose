<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WallpaperService;
use App\Services\CategoryService;
use App\Libs\Utils\Output;

class CategoryController extends BaseController
{

    public function __construct(WallpaperService $wallpaper_service, CategoryService $category_service)
    {
        $this->wallpaper_service = $wallpaper_service;
        $this->category_service  = $category_service;
    }

    public function index($link = '')
    {
        $this->data['view_file'] = 'category';

        $this->data['categories_all'] = $this->category_service->getList();

        $category = $this->category_service->get([
            'link' => $link,
        ]);
        if (isset($category['error'])) {
            return abort(403, $category['error']['message']);
        }
        $this->data['category'] = $category;

        $wallpapers = $this->wallpaper_service->getList([
            'type'     => ['name' => 'category_id', 'value' => $category['id']],
            'page'     => 1,
            'order_by' => 'id|desc',
        ]);
        if (isset($wallpapers['error'])) {
            return abort(403, $wallpapers['error']['message']);
        }
        $this->data['wallpapers'] = $wallpapers;

        return view('index', ['data' => $this->data]);
    }

    public function getList(Request $request)
    {
        if ( ! $request->has('page')) {
            return Output::responseError(101);
        }

        $page = (int)$request->input('page');

        $categories = $this->category_service->getList([
            'page' => $page,
        ]);
        if (isset($categories['error'])) {
            return Output::responseError($categories['error']['code']);
        }

        return Output::responseSuccess($categories);
    }

}
