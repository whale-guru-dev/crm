<?php

namespace Modules\Platform\Core\Http\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class NameSystemNameDictionaryForm
 * @package Modules\Platform\Core\Http\Forms
 */
class NameSystemNameDictionaryForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('core::core.form.name'),
        ]);

        $this->add('system_name', 'text', [
            'label' => trans('core::core.form.system_name'),
        ]);

        $this->add('submit', 'submit', [
            'label' => trans('core::core.form.save'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);
    }
}
