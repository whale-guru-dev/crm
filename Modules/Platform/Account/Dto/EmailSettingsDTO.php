<?php
/**
 * Created by PhpStorm.
 * User: laravel-bap.com
 * Date: 05.01.19
 * Time: 15:41
 */

namespace Modules\Platform\Account\Dto;


use Modules\Platform\Core\Traits\DtoTrail;

/**
 * Class EmailSettingsDTO
 * @package Modules\Platform\Account\Dto
 */
class EmailSettingsDTO
{
    use DtoTrail;

    const MAIL_HOST = 'mail_host';
    const MAIL_PORT = 'mail_port';
    const MAIL_USERNAME = 'mail_username';
    const MAIL_PASSWORD = 'mail_password';
    const MAIL_ENCRYPTION = 'mail_encryption';
    const MAIL_FROM_ADDRESS = 'mail_from_address';
    const MAIL_FROM_NAME = 'mail_from_name';
    const MAIL_SIGNATURE = 'mail_signature';

    public $mail_host;

    public $mail_port;

    public $mail_username;

    public $mail_password;

    public $mail_encryption;

    public $mail_from_address;

    public $mail_from_name;

    public $mail_signature;

}