<?php

namespace Modules\Platform\Account\Emails;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Modules\Platform\Account\Service\UserMailService;

class TestMail extends Mailable
{
    use  SerializesModels;

    public $custom;
    /**
     * SendTestMail constructor.
     */
    public function __construct($custom = null )
    {
        $this->custom = $custom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailService = App::make(UserMailService::class);


        $this->with('mailSettings',$mailService->getSettings());

        return $this->subject(trans('account::account.this_is_test_email'))->markdown('account::mail.test_mail');
    }
}
