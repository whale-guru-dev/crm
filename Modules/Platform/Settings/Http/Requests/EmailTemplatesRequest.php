<?php

namespace Modules\Platform\Settings\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class EmailTemplatesRequest
 * @package Modules\Platform\Settings\Http\Requests
 */
class EmailTemplatesRequest extends Request
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
            'subject' => 'required',
            'message' => 'required',
        ];
    }
}
