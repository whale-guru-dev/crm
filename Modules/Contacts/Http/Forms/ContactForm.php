<?php

namespace Modules\Contacts\Http\Forms;

use Kris\LaravelFormBuilder\Form;
use Modules\Accounts\Entities\Account;
use Modules\Contacts\Entities\ContactSource;
use Modules\Contacts\Entities\ContactStatus;
use Modules\Contacts\Entities\CustomerLanguage;
use Modules\Platform\Core\Helper\FormHelper;
use Modules\Platform\Settings\Entities\Country;

class ContactForm extends Form
{
    public function buildForm()
    {
        $this->add('owned_by', 'select', [
            'choices' => FormHelper::assignedToChoises(),
            'attr' => ['class' => 'select2 pmd-select2 form-control'],
            'label' => trans('core::core.form.assigned_to'),
            'empty_value' => trans('core::core.empty_select'),
            'selected' => FormHelper::assignSelectedFromModel($this->model)
        ]);

        $this->add('tags', 'tags', [
            'id' => 'contact-tags',
            'value' => FormHelper::getAssignedTags($this->model),
            'label' => trans('contacts::contacts.form.tags'),
        ]);

        $this->add('use_profile_image', 'checkbox', [
            'label' => trans('contacts::contacts.form.use_profile_image'),
        ]);
        $this->add('profile_image', 'file', [
            'label_show'=>false,
            'attr'=> ['id'=>'profile_image', 'class' => 'gravatar_type form-control'],
            'label' => trans('contacts::contacts.form.profile_image'),
        ]);


        $this->add('first_name', 'text', [
            'label' => trans('contacts::contacts.form.first_name'),
        ]);

        $this->add('last_name', 'text', [
            'label' => trans('contacts::contacts.form.last_name'),
        ]);

        $this->add('birth_date', 'dateType', [
            'label' => trans('contacts::contacts.form.birth_date'),
        ]);

        $this->add('job_title', 'text', [
            'label' => trans('contacts::contacts.form.job_title'),
        ]);


        $this->add('department', 'text', [
            'label' => trans('contacts::contacts.form.department'),
        ]);

        $this->add('language_id', 'select', [
            'choices' => CustomerLanguage::all()->pluck('name', 'id')->toArray(),
            'attr' => ['class' => 'select2 pmd-select2 form-control'],
            'label' => trans('contacts::contacts.form.language_id'),
            'empty_value' => trans('core::core.empty_select')
        ]);

        $this->add('contact_status_id', 'select', [
            'choices' => ContactStatus::all()->pluck('name', 'id')->toArray(),
            'attr' => ['class' => 'select2 pmd-select2 form-control'],
            'label' => trans('contacts::contacts.form.contact_status_id'),
            'empty_value' => trans('core::core.empty_select')
        ]);

        $this->add('contact_source_id', 'select', [
            'choices' => ContactSource::all()->pluck('name', 'id')->toArray(),
            'attr' => ['class' => 'select2 pmd-select2 form-control'],
            'label' => trans('contacts::contacts.form.contact_source_id'),
            'empty_value' => trans('core::core.empty_select')
        ]);

        $this->add('account_id', 'manyToOne', [
            'search_route' => route('accounts.accounts.index', ['mode'=>'modal']),
            'relation' => 'account',
            'relation_field' => 'name',
            'model' => $this->model,
            'modal_title' => 'accounts::accounts.choose',
            'attr' => ['class' => 'form-control manyToOne'],
            'label' => trans('core::core.form.account_id'),
            'empty_value' => trans('core::core.empty_select')
        ]);

        $this->add('referral_id', 'manyToOne', [
            'search_route' => route('contacts.contacts.index', ['mode'=>'modal']),
            'relation' => 'referral',
            'relation_field' => 'full_name',
            'model' => $this->model,
            'modal_title' => 'contacts::contacts.choose',
            'attr' => ['class' => 'form-control manyToOne'],
            'label' => trans('core::core.form.referral_id'),
            'empty_value' => trans('core::core.empty_select')
        ]);


        $this->add('phone', 'text', [
            'label' => trans('contacts::contacts.form.phone'),
        ]);


        $this->add('mobile', 'text', [
            'label' => trans('contacts::contacts.form.mobile'),
        ]);


        $this->add('email', 'text', [
            'label' => trans('contacts::contacts.form.email'),
        ]);

        $this->add('fax', 'text', [
            'label' => trans('contacts::contacts.form.fax'),
        ]);


        $this->add('assistant_name', 'text', [
            'label' => trans('contacts::contacts.form.assistant_name'),
        ]);


        $this->add('assistant_phone', 'text', [
            'label' => trans('contacts::contacts.form.assistant_phone'),
        ]);


        $this->add('street', 'text', [
            'label' => trans('contacts::contacts.form.street'),
        ]);

        $this->add('city', 'text', [
            'label' => trans('contacts::contacts.form.city'),
        ]);


        $this->add('state', 'text', [
            'label' => trans('contacts::contacts.form.state'),
        ]);

        $this->add('country_id', 'select', [
            'choices' => Country::whereIsActive(1)->pluck('name', 'id')->toArray(),
            'attr' => ['class' => 'select2 pmd-select2 form-control'],
            'label' => trans('contacts::contacts.form.country_id'),
            'empty_value' => trans('core::core.empty_select')
        ]);


        $this->add('zip_code', 'text', [
            'label' => trans('contacts::contacts.form.zip_code'),
        ]);


        $this->add('notes', 'textarea', [
            'label' => trans('contacts::contacts.form.notes'),
        ]);


        $this->add('submit', 'submit', [
            'label' => trans('core::core.form.save'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);
    }
}
