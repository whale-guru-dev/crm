<?php

namespace Modules\Platform\Settings\Http\Forms;

use Kris\LaravelFormBuilder\Form;
use Modules\Platform\Settings\Entities\Country;

/**
 * Class CompanySettingsForm
 * @package Modules\Platform\Settings\Http\Forms
 */
class CompanySettingsForm extends Form
{
    public function buildForm()
    {
        $this->add('company_name', 'text', [
            'label' => trans('settings::company_settings.company_name'),
        ]);
        $this->add('address', 'text', [
            'label' => trans('settings::company_settings.address'),
        ]);
        $this->add('city', 'text', [
            'label' => trans('settings::company_settings.city'),
        ]);
        $this->add('state', 'text', [
            'label' => trans('settings::company_settings.state'),
        ]);
        $this->add('postal_code', 'text', [
            'label' => trans('settings::company_settings.postal_code'),
        ]);
        $this->add('country_id', 'select', [
            'choices' => Country::whereIsActive(1)->pluck('name', 'id')->toArray(),
            'attr' => ['class' => 'select2 pmd-select2 form-control'],
            'label' => trans('settings::company_settings.country'),
            'empty_value' => trans('core::core.empty_select')
        ]);

        $this->add('phone', 'text', [
            'label' => trans('settings::company_settings.phone'),
        ]);
        $this->add('fax', 'text', [
            'label' => trans('settings::company_settings.fax'),
        ]);
        $this->add('website', 'text', [
            'label' => trans('settings::company_settings.website'),
        ]);
        $this->add('vat_id', 'text', [
            'label' => trans('settings::company_settings.vat_id'),
        ]);

        $this->add('submit', 'submit', [
            'label' => trans('settings::company_settings.update_settings'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);
    }
}
