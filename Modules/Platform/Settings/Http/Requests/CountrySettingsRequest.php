<?php

namespace Modules\Platform\Settings\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class CountrySettingsRequest
 * @package Modules\Platform\Settings\Http\Requests
 */
class CountrySettingsRequest extends Request
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
            'name' => 'required',
            'alpha2' => 'required',
            'alpha3' => 'required',
            'continent' => 'required'
        ];
    }
}
