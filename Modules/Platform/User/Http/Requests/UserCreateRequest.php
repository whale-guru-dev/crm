<?php

namespace Modules\Platform\User\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * Class UserCreateRequest
 * @package Modules\Platform\User\Http\Requests
 */
class UserCreateRequest extends Request
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
        return [
            'first_name' => 'required|max:255',

            'email' => [
                'required',
                'max:255',
                'email',
                Rule::unique('users')->where(function ($query) {
                    $query->whereNull('deleted_at');
                })
            ],
            'language_id'=>'required',
            'date_format_id'=>'required',
            'time_format_id'=>'required',
            'time_zone'=>'required',
            'theme' => 'required',
            'profile_picture' => 'mimes:jpeg,png'
        ];
    }
}
