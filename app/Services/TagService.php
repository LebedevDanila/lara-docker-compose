<?php
namespace App\Services;

use App\Helpers\GeneralHelper;
use \App\Libs\Utils\Output;
use DB;

class TagService
{

    public function get($params = [])
    {
        $where = [];
        if (isset($params['id'])) {
            $where[] = ['id' , '=', $params['id']];
        } else if (isset($params['link'])) {
            $where[] = ['link' , '=', $params['link']];
        } else {
            return Output::error(101);
        }

        $tag = DB::table('main_tags')
            ->where($where)
            ->first();
        if (empty($tag)) {
            return Output::error(404);
        }

        $tag->count_wallpapers = DB::table('main_wallpapers_tags_options')
            ->where('tag_id', $tag->id)
            ->count();

        return Output::collection($tag);
    }

    public function getList($params = [])
    {
        if ( ! isset($params['wallpaper_id'])) {
            return Output::error(101);
        }

        $tags = DB::table('main_wallpapers_tags_options')
            ->select(
                'main_tags.*',
                'main_wallpapers_tags_options.id as option_id',
                'main_wallpapers_tags_options.wallpaper_id',
            )
            ->where('main_wallpapers_tags_options.wallpaper_id', $params['wallpaper_id'])
            ->rightJoin('main_tags', 'main_tags.id', '=', 'main_wallpapers_tags_options.tag_id')
            ->get();

        return Output::collection($tags);
    }

    public function create($params = [])
    {
        if ( ! isset($params['name']) || ! isset($params['wallpaper_id'])) {
            return Output::error(101);
        }

        $link = GeneralHelper::getTranslitLink($params['name']);

        $tag = [
            'name' => $params['name'],
            'link' => $link,
        ];
        $check = DB::table('main_tags')
            ->where('link', $link)
            ->first();
        if (empty($check)) {
            try {
                $tag['id'] = DB::table('main_tags')->insertGetId($tag);
            } catch (\Exception $e) {
                return Output::error(400);
            }
        } else {
            $tag['id'] = (int)$check->id;
        }

        $option = [
            'wallpaper_id' => $params['wallpaper_id'],
            'tag_id'       => $tag['id'],
        ];
        $check = DB::table('main_wallpapers_tags_options')
            ->where($option)
            ->first();
        if (empty($check)) {
            try {
                $option['id'] = DB::table('main_wallpapers_tags_options')->insertGetId($option);
            } catch (\Exception $e) {
                return Output::error(400);
            }
        } else {
            $option['id'] = (int)$check->id;
        }

        $return = [
            'general' => $tag,
            'option'  => $option,
        ];
        return Output::collection($return);
    }

}