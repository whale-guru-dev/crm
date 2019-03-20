<?php
/**
 * Created by PhpStorm.
 * User: laravel-bap.com
 * Date: 29.12.18
 * Time: 11:14
 */

namespace Modules\Platform\Settings\Entities;


use HipsterJazzbo\Landlord\BelongsToTenants;
use Modules\Platform\Settings\Tags\Tag;

class BapTags extends Tag
{
    use BelongsToTenants;

    public $table = 'tags';
}