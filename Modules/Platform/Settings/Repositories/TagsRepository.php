<?php

namespace Modules\Platform\Settings\Repositories;

use Modules\Platform\Core\Repositories\PlatformRepository;
use Modules\Platform\Settings\Entities\BapTags;
use Modules\Platform\Settings\Entities\Currency;
use Modules\Platform\Settings\Entities\Language;
use Modules\Platform\Settings\Entities\Tax;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\Tags\Tag;

/**
 * Class TagsRepository
 * @package Modules\Platform\Settings\Repositories
 */
class TagsRepository extends PlatformRepository
{
    public function model()
    {
        return BapTags::class;
    }

    /**
     * Custom implementation of tag repository
     *
     * @param $attributes
     * @param $entity
     * @return Tag|static
     */
    public function createEntity($attributes, $entity)
    {
        $tag = BapTags::findOrCreate($attributes['name']);
        $tag->save();

        return $tag;
    }

    /**
     * Custom impl of tag repository
     * @param $attributes
     * @param $entity
     * @return mixed
     */
    public function updateEntity($attributes, $entity)
    {

        $entity->name = $attributes['name'];
        $entity->save();

        return $entity;
    }
}
