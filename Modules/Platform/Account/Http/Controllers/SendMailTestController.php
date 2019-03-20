<?php
/**
 * Created by PhpStorm.
 * User: laravel-bap.com
 * Date: 05.01.19
 * Time: 16:17
 */

namespace Modules\Platform\Account\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Modules\Platform\Account\Service\UserMailService;
use Modules\Platform\Core\Http\Controllers\AppBaseController;
use Modules\Platform\Core\Traits\JsonRespondTrait;

class SendMailTestController extends AppBaseController
{
    use JsonRespondTrait;

    private $mailService;

    public function __construct(UserMailService $mailService)
    {
        parent::__construct();

        $this->mailService = $mailService;
    }

    public function send()
    {

        $user = \Auth::user();

        if(config('bap.demo')){
            return $this->respond(trans('core::core.you_cant_do_that_its_demo'),false);
        }

        try {
            $result = $this->mailService->sendTest();

            if(count(Mail::failures()) > 0 ){
                return $this->respond('account::account.bad_email_configuration',false);
            }

            return $this->respond(trans('account::account.test_email_sent',['email' => $user->email]));

        } catch (\Exception $exception) {
            dd($exception);
            return $this->respond(trans('account::account.bad_email_configuration').' '.$exception,false);
        }


    }

}