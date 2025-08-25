<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use Filterable;

    protected $keyType = 'integer';

    protected $fillable = ['name', 'name_kana', 'sortno'];

    public function prefectures(): HasMany
    {
        return $this->hasMany('App\Models\Prefecture')->orderBy('prefectures.sortno');
    }

    public function prefectureWithPosts(): HasMany
    {
        return $this->hasMany('App\Models\Prefecture')
            ->leftJoin('locations', 'prefectures.id', '=', 'locations.prefecture_id')
            ->leftJoin('fulltime_posts', function ($join) {
                // ensure that the post is published
                $join->on('locations.id', '=', 'fulltime_posts.location_id')->where('fulltime_posts.post_publish_status', '=', 1);
            })
            ->leftJoin('parttime_posts', function ($join) {
                // ensure that the post is published
                $join->on('locations.id', '=', 'parttime_posts.location_id')->where('parttime_posts.post_publish_status', '=', 1);
            })
            ->selectRaw('prefectures.id, prefectures.area_id, prefectures.name, prefectures.name_kana,
            prefectures.name_en, prefectures.sortno, prefectures.created_at, prefectures.updated_at,
            count(DISTINCT(fulltime_posts.id)) as count_fulltime_post,
            count(DISTINCT(parttime_posts.id)) as count_parttime_post')
            ->groupByRaw('prefectures.id, prefectures.area_id')
            ->orderBy('prefectures.sortno');
    }
}
