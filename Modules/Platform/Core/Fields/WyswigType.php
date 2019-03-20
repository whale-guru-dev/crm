<?php

namespace Modules\Platform\Core\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

/**
 * Class WyswigType
 * @package Modules\Platform\Core\Fields
 */
class WyswigType extends FormField
{

    protected function getTemplate()
    {
        return 'vendor.laravel-form-builder.wyswig';
    }


    /**
     * @inheritdoc
     */
    public function getDefaults()
    {
        return [
            'note' => null,
            'additional_button' => null,
            'attr' => ['class' => 'summernote', 'id' => $this->getName()],
        ];
    }


}
