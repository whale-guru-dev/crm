<?php

namespace Modules\Platform\Settings\Http\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class EmailTemplateForm
 * @package Modules\Platform\Settings\Http\Forms
 */
class EmailTemplateForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('settings::email_templates.form.name'),
        ]);

        $this->add('subject', 'text', [
            'label' => trans('settings::email_templates.form.subject'),

        ]);
        $this->add('message', 'wyswig', [
            'label' => trans('settings::email_templates.form.message'),
            'note' => 'You can use "{{variable}} tags to use data from records."',
        ]);

        $this->add('submit', 'submit', [
            'label' => trans('settings::email_templates.form.save'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);
    }
}
