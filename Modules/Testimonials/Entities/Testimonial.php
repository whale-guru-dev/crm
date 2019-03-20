<?php

namespace Modules\Testimonials\Entities;

use Bnb\Laravel\Attachments\HasAttachment;
use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Contacts\Entities\Contact;
use Modules\Platform\Core\Traits\Commentable;
use Modules\Products\Entities\Product;

class Testimonial extends Model
{

    use SoftDeletes, BelongsToTenants, Commentable, HasAttachment;

    protected $mustBeApproved = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
    public $table = 'testimonials';

    public $fillable = [
        'product_id',
        'contact_id',
        'comment',
    ];


    protected $dates = ['deleted_at', 'created_at', 'updated_at'];


    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }


}
