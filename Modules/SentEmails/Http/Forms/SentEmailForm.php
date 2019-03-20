<?php

namespace Modules\SentEmails\Http\Forms;

use Illuminate\Support\Facades\App;
use Kris\LaravelFormBuilder\Form;

class SentEmailForm extends Form
{
    public function buildForm()
    {

        $this->add('recipient', 'tags', [
            'id' => 'email-recipient',
            'label' => trans('sentemails::sentemails.form.recipient'),
        ]);

        $this->add('cc', 'tags', [
            'label' => trans('sentemails::sentemails.form.cc'),
        ]);

        $this->add('bcc', 'tags', [
            'label' => trans('sentemails::sentemails.form.bcc'),
        ]);

        $this->add('subject', 'text', [
            'label' => trans('sentemails::sentemails.form.subject'),
            'attr' => ['class' => 'form-control email_subject'],
        ]);

        $note = '';

        try {
            if ($this->model != null && is_array($this->model)) {


                $entity = App::make($this->model['relatedEntity'])->find($this->model['relatedEntityId']);
                $array = $entity->toArray();
                unset($array['company_id']);

                $note = implode(", ", array_map(function ($string) {
                    return '"{{' . $string . '}}"';
                }, array_keys($array)));
            }
        } catch (\Exception $exception) {

        }

        $this->add('body', 'wyswig', [
            'label' => trans('sentemails::sentemails.form.body'),
            'attr' => ['class' => 'summernote email_body'],
            'additional_button' => [
                'text' => trans('sentemails::sentemails.choose_template'),
                'options' => [
                    'class' => 'btn btn-primary btn-sm m-b-5 search-relation-button',
                    'type' => 'button',
                    'data-route' => route('settings.email_templates.index',['mode'=>'modal','customTableClass' => 'chooseEmailTemplate']),
                    'data-modal-title' => trans('sentemails::sentemails.choose_template')
                ],
            ],
            'note' => 'You can use "{{variable}} tags to use data from records." ' . $note,
        ]);

        $this->add('submit', 'submit', [
            'label' => trans('sentemails::sentemails.form.send'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);

    }

}
