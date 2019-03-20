<?php

namespace Modules\Platform\Account\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class MailSettingsRequest
 * @package Modules\Platform\Account\Http\Requests
 */
class MailSettingsRequest extends Request
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
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
        ];
    }
}
