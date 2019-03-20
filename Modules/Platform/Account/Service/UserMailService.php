<?php
/**
 * Created by PhpStorm.
 * User: laravel-bap.com
 * Date: 05.01.19
 * Time: 11:30
 */

namespace Modules\Platform\Account\Service;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Modules\Platform\Account\Emails\TestMail;
use Modules\Platform\Account\Dto\EmailSettingsDTO;
use Modules\Platform\Core\Helper\UserSettings;
use Modules\Platform\User\Entities\User;
use Modules\SentEmails\LaravelDatabaseEmails\Email;

class UserMailService
{

    public function userMailerConfigurator($userId = null ){

        if ($mailConfig = $this->getSettings($userId)) {


            if (!empty($mailConfig->mail_host)) {

                Config::set('mail.host', $mailConfig->mail_host);
                Config::set('mail.port', $mailConfig->mail_port);
                Config::set('mail.encryption', $mailConfig->mail_encryption);
                Config::set('mail.username', $mailConfig->mail_username);
                Config::set('mail.password', $mailConfig->mail_password);
                Config::set('mail.from.address', $mailConfig->mail_from_address);
                Config::set('mail.from.name', $mailConfig->mail_from_name);

                $app = App::getInstance();

                $app->singleton('swift.transport', function ($app) {
                    return new \Illuminate\Mail\TransportManager($app);
                });

                $mailer = new \Swift_Mailer($app['swift.transport']->driver());

                Mail::setSwiftMailer($mailer);

                return $mailer;

            }
        }

    }

    /**
     * Send test email via email queue
     * @param null $userId
     * @return Email
     */
    public function sendTest($userId = null){

        $user = \Auth::user();

        if(!empty($userId)){
            $user = User::find($userId);
        }

        $mailConfig = $this->getSettings();

        $result = Email::compose()

            ->mailable(new TestMail("Custom Text"))
            ->composedById($user->id)
            ->subject(trans('account::account.this_is_test_email'))
            ->recipient($user->email)
            ->label(trans('account::account.this_is_test_email'))
            ->from($mailConfig->mail_from_address,$mailConfig->mail_from_name)
            ->send();

        return $result;

    }

    /**
     * @param null $userId
     * @return EmailSettingsDTO
     */
    public function getSettings($userId = null ): EmailSettingsDTO
    {
        $dto = new EmailSettingsDTO();

        $password = UserSettings::get(EmailSettingsDTO::MAIL_PASSWORD,null,$userId);

        $dto->mail_host = UserSettings::get(EmailSettingsDTO::MAIL_HOST);
        $dto->mail_port = UserSettings::get(EmailSettingsDTO::MAIL_PORT);
        $dto->mail_username = UserSettings::get(EmailSettingsDTO::MAIL_USERNAME);
        $dto->mail_password = !empty($password) ? decrypt($password) : null ;
        $dto->mail_encryption = UserSettings::get(EmailSettingsDTO::MAIL_ENCRYPTION);
        $dto->mail_from_address = UserSettings::get(EmailSettingsDTO::MAIL_FROM_ADDRESS);
        $dto->mail_from_name = UserSettings::get(EmailSettingsDTO::MAIL_FROM_NAME);
        $dto->mail_signature = UserSettings::get(EmailSettingsDTO::MAIL_SIGNATURE);

        return $dto;
    }

    /**
     * Save user email settings
     *
     * @param EmailSettingsDTO $dto
     */
    public function saveSettings(EmailSettingsDTO $dto)
    {
        UserSettings::set(EmailSettingsDTO::MAIL_HOST, $dto->mail_host);
        UserSettings::set(EmailSettingsDTO::MAIL_PORT, $dto->mail_port);
        UserSettings::set(EmailSettingsDTO::MAIL_USERNAME, $dto->mail_username);
        UserSettings::set(EmailSettingsDTO::MAIL_PASSWORD, encrypt($dto->mail_password));
        UserSettings::set(EmailSettingsDTO::MAIL_ENCRYPTION, $dto->mail_encryption);
        UserSettings::set(EmailSettingsDTO::MAIL_FROM_ADDRESS, $dto->mail_from_address);
        UserSettings::set(EmailSettingsDTO::MAIL_FROM_NAME, $dto->mail_from_name);
        UserSettings::set(EmailSettingsDTO::MAIL_SIGNATURE, $dto->mail_signature);

    }

}