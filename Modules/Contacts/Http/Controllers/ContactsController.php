<?php

namespace Modules\Contacts\Http\Controllers;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Modules\Contacts\Datatables\ContactDatatable;
use Modules\Contacts\Datatables\Tabs\ContactAssetsDatatable;
use Modules\Contacts\Datatables\Tabs\ContactCallsDatatable;
use Modules\Contacts\Datatables\Tabs\ContactCamapginsDatatable;
use Modules\Contacts\Datatables\Tabs\ContactDealsDatatable;
use Modules\Contacts\Datatables\Tabs\ContactDocumentsDatatable;
use Modules\Contacts\Datatables\Tabs\ContactEmailDatatable;
use Modules\Contacts\Datatables\Tabs\ContactInvoicesDatatable;
use Modules\Contacts\Datatables\Tabs\ContactOrdersDatatable;
use Modules\Contacts\Datatables\Tabs\ContactProductsDatatable;
use Modules\Contacts\Datatables\Tabs\ContactPurchasedProductsDatatable;
use Modules\Contacts\Datatables\Tabs\ContactQuotesDatatable;
use Modules\Contacts\Datatables\Tabs\ContactSentEmailsDatatable;
use Modules\Contacts\Datatables\Tabs\ContactTestimonialsDatatable;
use Modules\Contacts\Datatables\Tabs\ContactTicketsDatatable;
use Modules\Contacts\Entities\Contact;
use Modules\Contacts\Http\Forms\ContactForm;
use Modules\Contacts\Http\Requests\CreateContactRequest;
use Modules\Contacts\Http\Requests\UpdateContactRequest;
use Modules\Platform\Core\Http\Controllers\ModuleCrudController;

class ContactsController extends ModuleCrudController
{
    protected $datatable = ContactDatatable::class;
    protected $formClass = ContactForm::class;
    protected $storeRequest = CreateContactRequest::class;
    protected $updateRequest = UpdateContactRequest::class;
    protected $entityClass = Contact::class;

    protected $moduleName = 'contacts';

    protected $permissions = [
        'browse' => 'contacts.browse',
        'create' => 'contacts.create',
        'update' => 'contacts.update',
        'destroy' => 'contacts.destroy',

    ];

    protected $moduleSettingsLinks = [

        ['route' => 'contacts.status.index', 'label' => 'settings.status'],
        ['route' => 'contacts.source.index', 'label' => 'settings.source'],
        ['route' => 'contacts.language.index', 'label' => 'settings.language'],

    ];

    protected $settingsPermission = 'contacts.settings';

    protected $showFields = [

        'information' => [

            'full_name' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6',
                'hide_in_form' => true
            ],

            'first_name' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6',
                'hide_in_show' => true
            ],
            'last_name' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6',
                'hide_in_show' => true
            ],
            'use_profile_image' => [
                'type' => 'checkbox',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6',
                'hide_in_show' => true
            ],

            'profile_image' => [
                'type' => 'gravatar',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6',
                'hide_label' => true
            ],

            'phone' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

            'owned_by' => [
                'type' => 'assigned_to',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

            'mobile' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

            'contact_status_id' => [
                'type' => 'manyToOne',
                'relation' => 'contactStatus',
                'column' => 'name',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],


            'email' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

            'account_id' => [
                'type' => 'manyToOne',
                'relation' => 'account',
                'column' => 'name',
                'dont_translate' => true,
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],






        ],


        'additional_information' => [
            'fax' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],


            'contact_source_id' => [
                'type' => 'manyToOne',
                'relation' => 'contactSource',
                'column' => 'name',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

            'tags' => [
                'type' => 'tags',
                'col-class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12'
            ],


            'job_title' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

            'assistant_name' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],


            'department' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

            'assistant_phone' => [
                'type' => 'text',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],


            'referral_id' => [
                'type' => 'manyToOne',
                'relation' => 'referral',
                'column' => 'full_name',
                'dont_translate' => true,
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

            'birth_date' => [
                'type' => 'date',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

            'language_id' => [
                'type' => 'manyToOne',
                'relation' => 'language',
                'column' => 'name',
                'col-class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6'
            ],

        ],


        'address_information' => [

            'street' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],

            'city' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],

            'zip_code' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],

            'state' => [
                'type' => 'text',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],

            'country_id' => [
                'type' => 'manyToOne',
                'relation' => 'country',
                'column' => 'name',
                'col-class' => 'col-lg-4 col-md-4 col-sm-6 col-xs-6'
            ],

        ],


        'notes' => [

            'notes' => [
                'type' => 'text',
                'col-class' => 'col-lg-12 col-sm-12 col-md-12'
            ],

        ],

    ];


    protected $relationTabs = [

        'multi_email' => [
            'icon' => 'contact_mail',
            'permissions' => [
                'browse' => 'contacts.browse',
                'update' => 'contacts.update',
                'create' => 'contacts.create'
            ],
            'datatable' => [
                'datatable' => ContactEmailDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.contactemails.linked',
                'create' => 'contactemails.contactemails.create',
                'select' => 'contacts.contactemails.selection',
                'bind_selected' => 'contacts.contactemails.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'contactemails::contactemails.create_new',
                'post_create_bind' => [
                    'relationType' => 'oneToMany',
                    'relatedField' => 'contact_id',
                ]
            ],

            'select' => [
                'allow' => false,
                'modal_title' => 'contactemails::contactemails.module'
            ],
        ],

        'contact_sent_emails' => [
            'icon' => 'mail',
            'permissions' => [
                'browse' => 'contacts.browse',
                'update' => 'contacts.update',
                'create' => 'contacts.create'
            ],
            'datatable' => [
                'datatable' => ContactSentEmailsDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.sentemails.linked',
                'create' => 'sentemails.sentemails.create',
                'select' => 'contacts.sentemails.selection',
                'bind_selected' => 'contacts.sentemails.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'sentemails::sentemails.create_new',
                'label' => 'sentemails::sentemails.compose',
                'post_create_bind' => [
                    'relationType' => 'oneToMany',
                    'relatedField' => 'id', //TODO Fix this
                ],

            ],

            'select' => [
                'allow' => false,
                'modal_title' => 'sentemails::sentemails.module'
            ],
        ],

        'campaigns' => [
            'icon' => 'show_chart',
            'permissions' => [
                'browse' => 'campaigns.browse',
                'update' => 'campaigns.update',
                'create' => 'campaigns.create'
            ],
            'datatable' => [
                'datatable' => ContactCamapginsDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.campaigns.linked',
                'create' => 'campaigns.campaigns.create',
                'select' => 'contacts.campaigns.selection',
                'bind_selected' => 'contacts.campaigns.link'
            ],
            'create' => [
                'allow' => false,
                'modal_title' => 'campaigns::campaigns.create_new',
                'post_create_bind' => [
                    'relationType' => 'manyToMany',
                    'relatedField' => 'contacts',
                ]
            ],

            'select' => [
                'allow' => true,
                'modal_title' => 'campaigns::campaigns.module'
            ],
        ],
        'calls' => [
            'icon' => 'phone',
            'permissions' => [
                'browse' => 'calls.browse',
                'update' => 'calls.update',
                'create' => 'calls.create'
            ],
            'datatable' => [
                'datatable' => ContactCallsDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.calls.linked',
                'create' => 'calls.calls.create',
                'select' => 'contacts.calls.selection',
                'bind_selected' => 'contacts.calls.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'calls::calls.create_new',
                'post_create_bind' => [
                    'relationType' => 'oneToMany',
                    'relatedField' => 'contact_id',
                ]
            ],

            'select' => [
                'allow' => false,
                'modal_title' => 'calls::calls.module'
            ],
        ],
        'deals' => [
            'icon' => 'monetization_on',
            'permissions' => [
                'browse' => 'deals.browse',
                'update' => 'deals.update',
                'create' => 'deals.create'
            ],
            'datatable' => [
                'datatable' => ContactDealsDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.deals.linked',
                'create' => 'deals.deals.create',
                'select' => 'contacts.deals.selection',
                'bind_selected' => 'contacts.deals.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'deals::deals.create_new',
                'post_create_bind' => [
                    'relationType' => 'manyToMany',
                    'relatedField' => 'contacts',
                ]
            ],

            'select' => [
                'allow' => true,
                'modal_title' => 'deals::deals.module'
            ],
        ],

        'tickets' => [
            'icon' => 'report_problem',
            'permissions' => [
                'browse' => 'tickets.browse',
                'update' => 'tickets.update',
                'create' => 'tickets.create'
            ],
            'datatable' => [
                'datatable' => ContactTicketsDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.tickets.linked',
                'create' => 'tickets.tickets.create',
                'select' => 'contacts.tickets.selection',
                'bind_selected' => 'contacts.tickets.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'tickets::tickets.create_new',
                'post_create_bind' => [
                    'relationType' => 'oneToMany',
                    'relatedField' => 'contact_id',

                ]
            ],

            'select' => [
                'allow' => false,
                'modal_title' => 'tickets::tickets.module'
            ],
        ],

        'orders' => [
            'icon' => 'pageview',
            'permissions' => [
                'browse' => 'orders.browse',
                'update' => 'orders.update',
                'create' => 'orders.create'
            ],
            'datatable' => [
                'datatable' => ContactOrdersDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.orders.linked',
                'create' => 'orders.orders.create',
                'select' => 'contacts.orders.selection',
                'bind_selected' => 'contacts.orders.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'orders::orders.create_new',
                'post_create_bind' => [
                    'relationType' => 'oneToMany',
                    'relatedField' => 'contact_id',

                ]
            ],

            'select' => [
                'allow' => false,
                'modal_title' => 'orders::orders.module'
            ],
        ],

        'invoices' => [
            'icon' => 'shopping_cart',
            'permissions' => [
                'browse' => 'invoices.browse',
                'update' => 'invoices.update',
                'create' => 'invoices.create'
            ],
            'datatable' => [
                'datatable' => ContactInvoicesDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.invoices.linked',
                'create' => 'invoices.invoices.create',
                'select' => 'contacts.invoices.selection',
                'bind_selected' => 'contacts.invoices.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'invoices::invoices.create_new',
                'post_create_bind' => [
                    'relationType' => 'oneToMany',
                    'relatedField' => 'contact_id',

                ]
            ],

            'select' => [
                'allow' => false,
                'modal_title' => 'invoices::invoices.module'
            ],
        ],

        'assets' => [
            'icon' => 'laptop_chromebook',
            'permissions' => [
                'browse' => 'assets.browse',
                'update' => 'assets.update',
                'create' => 'assets.create'
            ],
            'datatable' => [
                'datatable' => ContactAssetsDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.assets.linked',
                'create' => 'assets.assets.create',
                'select' => 'contacts.assets.selection',
                'bind_selected' => 'contacts.assets.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'assets::assets.create_new',
                'post_create_bind' => [
                    'relationType' => 'oneToMany',
                    'relatedField' => 'contact_id',

                ]
            ],

            'select' => [
                'allow' => false,
                'modal_title' => 'assets::assets.module'
            ],
        ],

        'quotes' => [
            'icon' => 'chat',
            'permissions' => [
                'browse' => 'quotes.browse',
                'update' => 'quotes.update',
                'create' => 'quotes.create'
            ],
            'datatable' => [
                'datatable' => ContactQuotesDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.quotes.linked',
                'create' => 'quotes.quotes.create',
                'select' => 'contacts.quotes.selection',
                'bind_selected' => 'contacts.quotes.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'quotes::quotes.create_new',
                'post_create_bind' => [
                    'relationType' => 'oneToMany',
                    'relatedField' => 'contact_id',

                ]
            ],

            'select' => [
                'allow' => false,
                'modal_title' => 'quotes::quotes.module'
            ],
        ],

        'products' => [
            'icon' => 'pageview',
            'permissions' => [
                'browse' => 'products.browse',
                'update' => 'products.update',
                'create' => 'products.create'
            ],
            'datatable' => [
                'datatable' => ContactProductsDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.products.linked',
                'create' => 'products.products.create',
                'select' => 'contacts.products.selection',
                'bind_selected' => 'contacts.products.link'
            ],
            'create' => [
                'allow' => false,
                'modal_title' => 'products::products.create_new',
                'post_create_bind' => [
                    'relationType' => 'manyToMany',
                    'relatedField' => 'contacts',
                ]
            ],

            'select' => [
                'allow' => true,
                'modal_title' => 'products::products.module'
            ],
        ],

        'purchased_products' => [
            'icon' => 'pageview',
            'permissions' => [
                'browse' => 'products.browse',
                'update' => 'products.update',
                'create' => 'products.create'
            ],
            'datatable' => [
                'datatable' => ContactPurchasedProductsDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.purchased_products.linked',
                'create' => 'products.purchased_products.create',
                'select' => 'contacts.purchased_products.selection',
                'bind_selected' => 'contacts.purchased_products.link'
            ],
            'create' => [
                'allow' => false,
                'modal_title' => 'products::products.create_new',
                'post_create_bind' => [
                    'relationType' => 'manyToMany',
                    'relatedField' => 'contacts',
                ]
            ],

            'select' => [
                'allow' => false,
                'modal_title' => 'products::products.module'
            ],
        ],

        'testimonials' => [
            'icon' => 'thumb_up',
            'permissions' => [
                'browse' => 'testimonials.browse',
                'update' => 'testimonials.update',
                'create' => 'testimonials.create'
            ],
            'datatable' => [
                'datatable' => ContactTestimonialsDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.testimonials.linked',
                'create' => 'testimonials.testimonials.create',
                'select' => 'contacts.testimonials.selection',
                'bind_selected' => 'contacts.testimonials.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'testimonials::testimonials.create_new',
                'post_create_bind' => [
                    'relationType' => 'oneToMany',
                    'relatedField' => 'contact_id',

                ]
            ],

            'select' => [
                'allow' => false,
                'modal_title' => 'testimonials::testimonials.module'
            ],
        ],

        'documents' => [
            'icon' => 'storage',
            'permissions' => [
                'browse' => 'documents.browse',
                'update' => 'documents.update',
                'create' => 'documents.create'
            ],
            'datatable' => [
                'datatable' => ContactDocumentsDatatable::class
            ],
            'route' => [
                'linked' => 'contacts.documents.linked',
                'create' => 'documents.documents.create',
                'select' => 'contacts.documents.selection',
                'bind_selected' => 'contacts.documents.link'
            ],
            'create' => [
                'allow' => true,
                'modal_title' => 'documents::documents.create_new',
                'post_create_bind' => [
                    'relationType' => 'manyToMany',
                    'relatedField' => 'contacts',
                ]
            ],

            'select' => [
                'allow' => true,
                'modal_title' => 'documents::documents.module'
            ],
        ],
    ];


    protected $languageFile = 'contacts::contacts';

    protected $routes = [
        'index' => 'contacts.contacts.index',
        'create' => 'contacts.contacts.create',
        'show' => 'contacts.contacts.show',
        'edit' => 'contacts.contacts.edit',
        'store' => 'contacts.contacts.store',
        'destroy' => 'contacts.contacts.destroy',
        'update' => 'contacts.contacts.update',
        'import' => 'contacts.contacts.import',
        'import_process' => 'contacts.contacts.import.process'
    ];

    public function __construct()
    {
        parent::__construct();

    }

    /**
     *
     * @param $request
     * @param $entity
     * @param $input
     */
    public function beforeUpdate($request, &$entity, &$input)
    {

        /**
         * If there is no profile_image in input. Remove this field and don't process.
         * Why? If there was image before update it will be removed because all variables from input are processed even null values.
         */
        if (!isset($input['profile_image'])) {
            unset($input['profile_image']);
        }
    }



    /**
     * After entity store
     * @param $request
     * @param $entity
     * @return bool
     */
    public function afterStore($request, &$entity)
    {

        $tags = $request->get('tags',[]);

        $tags = explode(',',$tags);

        $entity->syncTags($tags);

        if (config('bap.demo')) {
            return false;
        }

        /**
         * Avatar upload
         */
        $profilePicturePath = config('contacts.public_profile_picture_path');

        $profilePicture = $request->file('profile_image');

        if (config('bap.gravatar_local_cache') && !$entity->use_profile_image) {

            $fileName = 'gravatar_contact_profile_picture_' . md5('__'.$entity->id) . '_.png';

            $size = config('bap.gravatar_display_size');
            $image = md5(strtolower($entity->email));
            $imageUrl = "https://www.gravatar.com/avatar/" . $image . "?s=" . $size . "&d=" . config('bap.gravatar_default_preview') . "&r=PG";

            $content = file_get_contents($imageUrl);

            $uploadSuccess = Storage::disk('local')->put('tmp/' . $fileName,$content);

            if ($uploadSuccess) {

                Image::make(storage_path('app/tmp/'.$fileName))->save(base_path() . '/public/storage/' . $profilePicturePath . $fileName);

                $entity = $this->getRepository()->update([
                    'profile_image' => $fileName
                ], $entity->id);
            }
        }


        if ($profilePicture != null && $entity->use_profile_image) {

            $image = 'contact_profile_picture_' . md5('__'.$entity->id) . '_.' . $profilePicture->getClientOriginalExtension();

            $uploadSuccess = $profilePicture->move($profilePicturePath, $image);

            if ($uploadSuccess) {

                // Resize uploaded image to 200x200
                $img = Image::make(base_path() . '/public/' . $profilePicturePath . $image)->resize(
                    config('bap.gravatar_resize_width'),
                    config('bap.gravatar_resize_height')
                );
                $img->save(base_path() . '/public/storage/' . $profilePicturePath . $image);

                $entity = $this->getRepository()->update([
                    'profile_image' => $image
                ], $entity->id);

            }
        }
    }

    /**
     * After entity update
     * @param $request
     * @param $entity
     */
    public function afterUpdate($request, &$entity)
    {
        /**
         * Avatar upload
         */
        $this->afterStore($request, $entity);

    }

}
