<?php

namespace Modules\Testimonials\Http\Forms;


use Kris\LaravelFormBuilder\Form;

class TestimonialsForm extends Form
{
    public function buildForm()
    {

        $this->add('product_id', 'manyToOne', [
            'search_route' => route('products.products.index', ['mode' => 'modal']),
            'relation' => 'product',
            'relation_field' => 'name',
            'model' => $this->model,
            'attr' => ['class' => 'form-control manyToOne'],
            'label' => trans('testimonials::testimonials.form.product_id'),
            'empty_value' => trans('core::core.empty_select')
        ]);

        $this->add('contact_id', 'manyToOne', [
            'search_route' => route('contacts.contacts.index', ['mode' => 'modal']),
            'relation' => 'contact',
            'relation_field' => 'full_name',
            'model' => $this->model,
            'attr' => ['class' => 'form-control manyToOne'],
            'label' => trans('testimonials::testimonials.form.contact_id'),
            'empty_value' => trans('core::core.empty_select')
        ]);

        $this->add('comment', 'textarea', [
            'label' => trans('testimonials::testimonials.form.comment'),
        ]);


        $this->add('submit', 'submit', [
            'label' => trans('core::core.form.save'),
            'attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']
        ]);

    }

}