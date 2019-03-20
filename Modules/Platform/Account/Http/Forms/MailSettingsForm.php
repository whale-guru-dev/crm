<?php

namespace Modules\Platform\Account\Http\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class MailSettingsForm
 * @package Modules\Platform\Account\Http\Forms
 */
class MailSettingsForm extends Form
{
    public function buildForm()
    {
        $this->add('mail_host', 'text', [
            'label' => trans('account::account.form.mail_host'),
        ]);
        $this->add('mail_port', 'number', [
            'label' => trans('account::account.form.mail_port'),
        ]);
        $this->add('mail_username', 'text', [
            'label' => trans('account::account.form.mail_username'),
        ]);
        $this->add('mail_password', 'text', [
            'label' => trans('account::account.form.mail_password'),
        ]);
        $this->add('mail_encryption', 'text', [
            'label' => trans('account::account.form.mail_encryption'),
        ]);
        $this->add('mail_from_address', 'text', [
            'label' => trans('account::account.form.mail_from_address'),
        ]);
        $this->add('mail_from_name', 'text', [
            'label' => trans('account::account.form.mail_from_name'),
        ]);

        $this->add('mail_signature', 'textarea', [
            'label' => trans('account::account.form.mail_signature'),
            'attr' => ['class' => 'summernote']
        ]);

        $this->add('submit', 'submit', [
            'label' => trans('account::account.form.save'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);

        if ($this->model != null && $this->model->mail_host != null) {
            $this->add('button', 'button', [
                'label' => trans('account::account.form.send_test_email'),
                'attr' => ['class' => 'btn pull-right btn-warning m-t-15 waves-effect', 'id' => 'send_test_email_btn']
            ]);
        }
    }
}
