<?php
/**
 * Created by PhpStorm.
 * User: laravel-bap.com
 * Date: 05.01.19
 * Time: 15:54
 */

namespace Modules\Platform\Core\Traits;


trait DtoTrail
{

    public function map(array $values)
    {
        foreach ($values as $key =>  $val){
            $this->{$key} = $val;
        }
        return $this;
    }


}