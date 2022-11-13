<?php
namespace App\Services;

use App\Libs\Utils\Cdn;
use App\Libs\Utils\Output;
use App\Helpers\GeneralHelper;
use DB;

class WallpaperService
{

    public $limit = 10;

    public function get($params = [])
    {
        if ( ! isset($params['id'])) {
            return Output::error(101);
        }

        $wallpaper = DB::table('main_wallpapers')
            ->select(
                'main_wallpapers.*',
                'main_categories.link as category_link',
                'main_categories.name as category_name', 
            )
            ->where('main_wallpapers.id', $params['id'])
            ->leftJoin('main_categories', 'main_categories.id', '=', 'main_wallpapers.category_id')
            ->first();
        if (empty($wallpaper)) {
            return Output::error(404);
        }

        return Output::collection($wallpaper);
    }

    public function getList($params = [])
    {
        if ( ! isset($params['type'])) {
            return Output::error(101);
        }

        $limit  = $params['limit'] ?? $this->limit;
        $offset = (($params['page'] ?? 1)-1) * $limit;
        $max    = $offset+$limit;

        $type_id     = null;
        $type_entity = 'all';
        if ($params['type']['name'] === 'category_id' || $params['type']['name'] === 'category_link') {
            if ($params['type']['name'] === 'category_link') {
                $category = DB::table('main_categories')
                    ->select('id')
                    ->where('link', $params['type']['value'])
                    ->first();
                if (empty($category)) {
                    return Output::error(404);
                }
                $type_id = $category->id;
            } else {
                $type_id = $params['type']['value'];
            }
            $builder     = DB::table('main_wallpapers')->where('category_id', $type_id);
            $type_entity = 'category';
        } elseif ($params['type']['name'] === 'tag_id' || $params['type']['name'] === 'tag_link') {    
            if ($params['type']['name'] === 'tag_link') {
                $tag = DB::table('main_tags')
                    ->select('id')
                    ->where('link', $params['type']['value'])
                    ->first();
                if (empty($tag)) {
                    return Output::error(404);
                }
                $type_id = $tag->id;
            } else {
                $type_id = $params['type']['value'];
            }
            $builder = DB::table('main_wallpapers_tags_options')
                ->select('main_wallpapers.*')
                ->where('main_wallpapers_tags_options.tag_id', $type_id)
                ->leftJoin('main_wallpapers', 'main_wallpapers.id', '=', 'main_wallpapers_tags_options.wallpaper_id');
            $type_entity = 'tag';
        } else if ($params['type']['name'] === 'all') {
            $builder = DB::table('main_wallpapers');
        } else {
            return Output::error(400);
        }

        $count = $this->getCount(['type' => ['entity' => $type_entity, 'id' => $type_id]]);
        if (isset($count['error'])) {
            return Output::error($count['error']['code']);
        }

        if (isset($params['order_by'])) {
            $order_by = explode('|', $params['order_by']);

            if ($order_by[0] === 'id'
                || $order_by[0] === 'views'
                || $order_by[0] === 'downloads'
                || $order_by[0] === 'likes'
                || $order_by[0] === 'date_create'
            ) {
                $direction = strtolower($order_by[1]);
                if ($direction === 'asc' || $direction === 'desc') {
                    $builder = $builder->orderBy($order_by[0], $direction);
                } else if ($direction === 'random') {
                    $builder = $builder->inRandomOrder();
                } else {
                    return Output::error(101);
                }
            } else {
                return Output::error(101);
            }
        }

        $wallpapers = $builder->offset($offset)->limit($limit)->get();

        $paginate = true;
        if ($max >= $count) {
            $paginate = false;
        }

        $return = [
            'paginate' => $paginate,
            'count'    => $count,
            'limit'    => $limit,
            'items'    => $wallpapers,
        ];

        return Output::collection($return);
    }

    public function getCount($params = [])
    {
        switch ($params['type']['entity']) {
            case 'category':
                $builder = DB::table('main_wallpapers')->where('category_id', $params['type']['id']);
                break;
            case 'tag':
                $builder = DB::table('main_wallpapers_tags_options')->where('tag_id', $params['type']['id']);
                break;
            case 'all':
                $builder = DB::table('main_wallpapers');
                break;
            default:
                return Output::error(400);
        }

        $count = $builder->count();

        return $count;
    }

    public function getPaginateCount($params = [])
    {
        $count = $this->getCount($params);

        return ceil($count / $this->limit);
    }

    public function create($params = [])
    {
        if ( ! isset($params['category_id']) || ! isset($params['name']) || ! isset($params['content'])) {
            return Output::error(11);
        }

        $path = config('constants.cdn.path.wallpapers') . GeneralHelper::generateHash(20);
        if (is_string($params['content'])) {
            $explode = explode('.', $params['content']);
            $format  = '.' . $explode[count($explode)-1];
            $url     = $path . $format;
        } else {
            $url = $path . ($params['format'] ?? '.jpeg');
        }
        try {
            (new Cdn())->put($url, file_get_contents($params['content']));
        } catch (\Exception $e) {
            return Output::error(409);
        }

        $insert = [
            'category_id' => (int)$params['category_id'],
            'user_id'     => isset($params['user_id']) ? (int)$params['user_id'] : null,
            'name'        => $params['name'],
            'url'         => $url,
            'date_create' => time(),
        ];
        try {
            $insert['id'] = DB::table('main_wallpapers')->insertGetId($insert);
        } catch (\Exception $e) {
            return Output::error(400);
        }

        return Output::collection($insert);
    }

    public function updateStatistics($params = [])
    {
        if ( ! isset($params['name'])
            && $params['name'] !== 'downloads'
            && $params['name'] !== 'views'
            && $params['name'] !== 'likes'
        ) {
            return Output::error(101);
        }

        DB::table('main_wallpapers')
            ->where('id', $params['id'])
            ->update([$params['name'] => DB::raw("{$params['name']}+1")]);

        return Output::collection(['status' => true]);
    }

}