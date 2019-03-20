<?php

namespace Modules\Api\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;
/**
 * Contact API Request
 *
 * Class ContactApiRequest
 *
 * @package Modules\Api\Http\Requests
 */
class ContactApiRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $companyId = request()->get('company_id');

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'max:255',
                'email',
                Rule::unique('contacts')->where(function ($query) use ($companyId) {
                    $query->where('company_id', '=', $companyId);
                    $query->whereNull('deleted_at');

                }),
                Rule::unique('contact_email')->where(function ($query) use ($companyId) {
                    $query->where('company_id', '=', $companyId);
                    $query->whereNull('deleted_at');
                }),
            ],
            'company_id' => 'required'
        ];
    }
}
