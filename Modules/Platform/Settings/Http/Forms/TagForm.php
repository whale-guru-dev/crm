<?php

namespace Modules\Platform\Settings\Http\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class TagForm
 * @package Modules\Platform\Settings\Http\Forms
 */
class TagForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('settings::tags.form.name'),
        ]);

        $this->add('submit', 'submit', [
            'label' => trans('settings::tags.form.save'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);
    }
}
