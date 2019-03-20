<?php

namespace Modules\Platform\User\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * help - https://laravel-news.com/unique-and-exists-validation
 *
 * Class RoleUpdateRequest
 * @package Modules\Platform\User\Http\Requests
 */
class RoleUpdateRequest extends Request
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

        $id = $this->route()->parameter('role');

        $company = session()->get('currentCompany');

        return [
            'display_name' => [
                'max:255',
                'required',
                Rule::unique('roles')->ignore($id)->where(function($query) use ($company){
                    $query->where('company_id','=',$company->id);
                })
            ],
            'name' => [
                'max:255',
                'required',
                Rule::unique('roles')->ignore($id)->where(function($query) use ($company){
                    $query->where('company_id','=',$company->id);
                })
            ],
            'guard_name' => 'required'
        ];
    }
}
