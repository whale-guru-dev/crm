<?php

namespace Modules\Platform\Companies\Http\Forms;

use Kris\LaravelFormBuilder\Form;
use Modules\Platform\Companies\Entities\CompanyPlan;

/**
 * Class CompanyForm
 *
 * @package Modules\Platform\Companies\Http\Forms
 */
class CompanyForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('companies::companies.form.name'),
        ]);

        $this->add('plan_id', 'select', [
            'choices' => CompanyPlan::all()->pluck('name', 'id')->toArray(),
            'attr' => ['class' => 'select2 pmd-select2 form-control'],
            'label' => trans('companies::companies.form.plan_id'),
            'empty_value' => trans('core::core.empty_select')
        ]);

        $this->add('user_limit', 'text', [
            'label' => trans('companies::companies.form.user_limit'),
        ]);
        $this->add('storage_limit', 'text', [
            'label' => trans('companies::companies.form.storage_limit'),
        ]);
        $this->add('is_enabled', 'checkbox', [
            'label' => trans('companies::companies.form.is_enabled'),
        ]);
        $this->add('description', 'textarea', [
            'label' => trans('companies::companies.form.description'),
        ]);

        $this->add('submit', 'submit', [
            'label' => trans('companies::companies.form.save'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);
    }
}
