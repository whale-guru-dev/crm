<?php

namespace Modules\Platform\Companies\Http\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class CompanyPlanForm
 * @package Modules\Platform\Companies\Http\Forms
 */
class CompanyPlanForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('companies::companyPlans.form.name'),
        ]);

        $this->add('api_name', 'text', [
            'label' => trans('companies::companyPlans.form.api_name'),
        ]);

        $this->add('description', 'textarea', [
            'label' => trans('companies::companyPlans.form.description'),
        ]);

        $this->add('submit', 'submit', [
            'label' => trans('companies::companyPlans.form.save'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);
    }
}
