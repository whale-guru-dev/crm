<?php

namespace Modules\Platform\Settings\Http\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class CountryForm
 * @package Modules\Platform\Settings\Http\Forms
 */
class CountryForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('settings::country.form.name'),
        ]);
        $this->add('alpha2', 'text', [
            'label' => trans('settings::country.form.alpha2'),
        ]);
        $this->add('alpha3', 'text', [
            'label' => trans('settings::country.form.alpha3'),
        ]);
        $this->add('continent', 'text', [
            'label' => trans('settings::country.form.continent'),
        ]);
        $this->add('is_active', 'checkbox', [
            'label' => trans('settings::country.form.is_active'),
        ]);

        $this->add('submit', 'submit', [
            'label' => trans('settings::language.form.save'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);
    }
}
