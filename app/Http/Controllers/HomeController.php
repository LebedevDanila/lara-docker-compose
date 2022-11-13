<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WallpaperService;
use App\Services\CategoryService;
use App\Services\TagService;
use App\Libs\Parsers\WallpaperMobOrgParser;
use App\Libs\Utils\Output;
use DB;

class HomeController extends BaseController
{

    public function index(CategoryService $category_service, WallpaperService $wallpaper_service) {
        $this->data['view_file'] = 'home';

        $this->data['categories_all'] = $category_service->getList();

        $wallpapers = $wallpaper_service->getList([
            'type'     => ['name' => 'all'],
            'page'     => 1,
            'order_by' => 'id|desc',
        ]);
        if (isset($wallpapers['error'])) {
            return abort(403, $wallpapers['error']['message']);
        }
        $this->data['wallpapers'] = $wallpapers;

        $categories = $category_service->getList([
            'page' => 1,
        ]);
        if (isset($categories['error'])) {
            return abort(403, $categories['error']['message']);
        }
        $this->data['categories'] = $categories;

        return view('index', ['data' => $this->data]);
    }

    public function search(Request $request)
    {
        if ( ! $request->has('query')) {
            return Output::responseError(101);
        }
        $query = mb_strtolower($request->input('query'));

        $categories = DB::table('main_categories')
            ->select('id', 'name', 'link', DB::raw("'category' as type"))
            ->where('name', 'like', "%{$query}%")
            ->limit(5)->get()->toArray();

        $tags = DB::table('main_tags')
            ->select('id', 'name', 'link', DB::raw("'tag' as type"))
            ->where('name', 'like', "%{$query}%")
            ->limit(5)->get()->toArray();

        $wallpapers = DB::table('main_wallpapers')
            ->select('id', 'name', DB::raw("'wallpaper' as type"))
            ->where('name', 'like', "%{$query}%")
            ->limit(5)->get()->toArray();

        $data = array_merge($categories, $tags, $wallpapers);

        return Output::responseSuccess($data);
    }

    public function parser($tag = '', $max = 10)
    {
        $data = (new WallpaperMobOrgParser(['max' => $max]))->run($tag);
        foreach ($data as $wallpaper_row) {
            $params = [
                'category_id' => mt_rand(1, 11),
                'name'        => implode(', ', $wallpaper_row['tags']),
                'content'     => $wallpaper_row['url'],
            ];
            $wallpaper = (new WallpaperService())->create($params);

            foreach ($wallpaper_row['tags'] as $tag_row) {
                $tags = (new TagService())->create(['name' => $tag_row, 'wallpaper_id' => $wallpaper['id']]);
            }
        }
    }

}
