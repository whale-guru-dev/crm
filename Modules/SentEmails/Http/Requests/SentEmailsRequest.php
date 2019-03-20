<?php

namespace Modules\SentEmails\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class SentEmailsRequest
 * @package Modules\SentEmails\Http\Requests
 */
class SentEmailsRequest extends Request
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
            'recipient' => 'sometimes|nullable|multi_email',
            'cc' =>  'sometimes|nullable|multi_email',
            'bcc' => 'sometimes|nullable|multi_email',
            'subject' => 'required',
            'body' => 'required'
        ];
    }

}
