<?php
namespace App\Services;

use App\Helpers\GeneralHelper;
use \App\Libs\Utils\Output;
use DB;

class CategoryService
{

    public $limit = 8;

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

        $category = DB::table('main_categories as c')
            ->select(
                'c.*',
                DB::raw('(SELECT COUNT(*) FROM main_wallpapers w WHERE w.category_id=c.id) as count_wallpapers'),
                DB::raw('(SELECT url FROM main_wallpapers w WHERE w.category_id=c.id ORDER BY id DESC LIMIT 1) as url')
            )
            ->where($where)
            ->first();
        if (empty($category)) {
            return Output::error(404);
        }

        return Output::collection($category);
    }

    public function getList($params = [])
    {
        $builder = DB::table('main_categories as c')
            ->select(
                'c.*',
                DB::raw('(SELECT COUNT(*) FROM main_wallpapers w WHERE w.category_id=c.id) as count_wallpapers'),
                DB::raw('(SELECT url FROM main_wallpapers w WHERE w.category_id=c.id ORDER BY id DESC LIMIT 1) as url')
            );
        $count    = $this->getCount();
        $paginate = false;

        if (isset($params['page'])) {
            $limit  = $params['limit'] ?? $this->limit;
            $offset = (($params['page'] ?? 1)-1) * $limit;
            $max    = $offset+$limit;
            if ($max < $count) {
                $paginate = true;
            }
            $categories = $builder->offset($offset)->limit($limit)->get();
        } else {
            $categories = $builder->get();
        }

        $return = [
            'paginate' => $paginate,
            'count'    => $count,
            'limit'    => isset($params['page']) ? $limit : $count,
            'items'    => $categories,
        ];

        return Output::collection($return);
    }

    public function getCount()
    {
        $count = DB::table('main_categories')->count();

        return $count;
    }

    public function create($params = [])
    {
        if ( ! isset($params['name'])) {
            return Output::error(101);
        }

        $link = GeneralHelper::getTranslitLink($params['name']);

        $check = DB::table('main_categories')->where('link', $link)->first();
        if ( ! empty($check)) {
            return Output::error(102);
        }

        $insert = [
            'name' => $params['name'],
            'link' => $link,
        ];
        try {
            $insert['id'] = DB::table('main_categories')->insertGetId($insert);
        } catch (\Exception $e) {
            return Output::error(400);
        }

        return Output::collection($insert);
    }

    public function delete($params = [])
    {
        if ( ! isset($params['id'])) {
            return Output::error(101);
        }

        $builder = DB::table('main_categories')->where('id', $params['id']);

        $check = $builder->first();
        if (empty($check)) {
            return Output::error(404);
        }

        try {
            $builder->delete();
        } catch (\Exception $e) {
            return Output::error(400);
        }

        return Output::collection(['status' => true]);
    }

}