<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WallpaperService;
use App\Services\TagService;
use App\Libs\Utils\Output;
use App\Helpers\GeneralHelper;

class WallpaperController extends BaseController
{

    public function __construct(WallpaperService $wallpaper_service, TagService $tag_service)
    {
        $this->wallpaper_service = $wallpaper_service;
        $this->tag_service       = $tag_service;
    }

    public function get(Request $request)
    {
        if ( ! $request->has('id')) {
            return Output::responseError(101);
        }

        $id = (int)$request->input('id');

        $wallpaper = $this->wallpaper_service->get([
            'id' => $id
        ]);
        if (isset($wallpaper['error'])) {
            return Output::responseError($wallpaper['error']['code']);
        }

        $tags = $this->tag_service->getList(['wallpaper_id' => $id]);
        if (isset($tags['error'])) {
            return Output::responseError($tags['error']['code']);
        }
        $wallpaper['tags'] = $tags;

        $similars = $this->wallpaper_service->getList([
            'type'     => ['name' => 'category_id', 'value' => $wallpaper['category_id']],
            'page'     => 1,
            'order_by' => 'id|random',
        ]);
        if (isset($similars['error'])) {
            return Output::responseError($similars['error']['code']);
        }
        $similars = $similars['items'];
        foreach ($similars as $key => $similar) {
            if ($similar['id'] === $wallpaper['id']) {
                unset($similars[$key]);
            }
        }
        $wallpaper['similars'] = $similars;

        $this->wallpaper_service->updateStatistics([
            'name' => 'views',
            'id'   => $wallpaper['id'],
        ]);

        return Output::responseSuccess($wallpaper);
    }

    public function getList(Request $request)
    {
        if ( ! $request->has('type_name')
            || ! $request->has('type_value')
            || ! $request->has('order_by')
            || ! $request->has('page')
        ) {
            return Output::responseError(101);
        }

        $type_name  = $request->input('type_name');
        $type_value = $request->input('type_value');
        $order_by   = $request->input('order_by');
        $page       = (int)$request->input('page');

        $data = $this->wallpaper_service->getList([
            'type'     => ['name' => $type_name, 'value' => $type_value],
            'page'     => $page,
            'order_by' => $order_by,
        ]);
        if (isset($data['error'])) {
            return Output::responseError($data['error']['code']);
        }

        return Output::responseSuccess($data);
    }

    public function download(Request $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('upload_max_size', '999M');
        ini_set('post_max_size', '999M');
        ini_set('max_execution_time', '300');

        if ( ! $request->has('id')) {
            return Output::responseError(101);
        }

        $id = (int)$request->input('id');

        $wallpaper = $this->wallpaper_service->get([
            'id' => $id
        ]);
        if (isset($wallpaper['error'])) {
            return Output::responseError($wallpaper['error']['code']);
        }

        $this->wallpaper_service->updateStatistics([
            'name' => 'downloads',
            'id'   => $id,
        ]);

        $explode_url = explode('.', $wallpaper['url']);
        $type        = $explode_url[count($explode_url)-1];
        $filename    = GeneralHelper::generateHash(10) . '.' . $type;
        $url         = config('constants.cdn.url') . $wallpaper['url'];

        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        die(file_get_contents($url));
    }

}
