<?php
namespace App\Services;

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

    /*public function getList($params = [])
    {
        $builder = $this->db
            ->table('main_categories c')
            ->select('
                c.*,
                (SELECT COUNT(*) FROM main_wallpapers w WHERE w.category_id=c.id) as count_wallpapers,
                (SELECT url FROM main_wallpapers w WHERE w.category_id=c.id ORDER BY id DESC LIMIT 1) as url
            ');
        $count    = $this->getCount();
        $paginate = false;

        if (isset($params['page'])) {
            $limit  = $params['limit'] ?? $this->limit;
            $offset = (($params['page'] ?? 1)-1) * $limit;
            $max    = $offset+$limit;
            if ($max < $count) {
                $paginate = true;
            }
            $categories = $builder->get($limit, $offset)->getResult();
        } else {
            $categories = $builder->get()->getResult();
        }

        $return = [
            'paginate' => $paginate,
            'count'    => $count,
            'limit'    => isset($params['page']) ? $limit : $count,
            'items'    => [],
        ];
        foreach ($categories as $category) {
            $return['items'][] = [
                'id'               => (int)$category->id,
                'name'             => $category->name,
                'link'             => $category->link,
                'count_wallpapers' => (int)$category->count_wallpapers,
                'url'              => $category->url,
            ];
        }

        return $this->output->collection($return);
    }

    public function getCount()
    {
        $count = $this->db->table('main_categories')->countAll();

        return $count;
    }

    public function create($params = [])
    {
        if ( ! isset($params['name'])) {
            return $this->output->error(101);
        }

        $link = getTranslitLink($params['name']);

        $check = $this->db->table('main_categories')->where('link', $link)->get()->getRow();
        if ( ! empty($check)) {
            return $this->output->error(102);
        }

        $insert = [
            'name' => $params['name'],
            'link' => $link,
        ];
        try {
            $this->db->table('main_categories')->insert($insert);
        } catch (\Exception $e) {
            return $this->output->error(400);
        }
        $insert['id'] = $this->db->insertID();

        return $this->output->collection($insert);
    }

    public function delete($params = [])
    {
        if ( ! isset($params['id'])) {
            return $this->output->error(101);
        }

        $builder = $this->db->table('main_categories')->where('id', $params['id']);

        $check = $builder->get()->getRow();
        if (empty($check)) {
            return $this->output->error(404);
        }

        try {
            $builder->delete();
        } catch (\Exception $e) {
            return $this->output->error(400);
        }

        return $this->output->collection(['status' => true]);
    }*/

}