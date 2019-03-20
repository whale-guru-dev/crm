<?php
/**
 * Created by PhpStorm.
 * User: jw
 * Date: 10.01.19
 * Time: 15:13
 */

namespace Modules\SentEmails\Service;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\Contacts\Entities\Contact;
use Modules\Leads\Entities\Lead;
use Modules\Platform\Account\Service\UserMailService;
use Modules\Platform\Core\Datatable\Scope\OwnableEntityScope;
use Modules\Platform\Core\Helper\StringHelper;
use Modules\SentEmails\Entities\EmailContext;
use Modules\SentEmails\LaravelDatabaseEmails\Email;

class SendEmailService
{

    private $userMailService;

    public function __construct(UserMailService $mailService)
    {
        $this->userMailService = $mailService;
    }

    /**
     * Store email in database and send via queue
     * @param $data
     */
    public function storeAndSendEmail($data){

        $user = Auth::user();

        $recipient = $data['recipient'];
        $cc        = $data['cc'];
        $bcc       = $data['bcc'];
        $subject   = $data['subject'];
        $body      = $data['body'];

        $entityId  = $data['relatedEntityId'];
        $entitType = $data['relatedEntity'];

        $recipient = array_filter(explode(',',$recipient));
        $cc        = array_filter(explode(',',$cc));
        $bcc       = array_filter(explode(',',$bcc));


        // Related Entity Object

        $entity = App::make($entitType)->find($entityId);

        $mailConfig = $this->userMailService->getSettings();


        $result = Email::compose()
            ->recipient($recipient)
            ->cc($cc)
            ->bcc($bcc)
            ->composedById($user->id)
            ->variables([
             'body' => StringHelper::renderTemplateVariables($body,$entity->toArray()),
            ])->view('sentemails::email')
            ->subject(StringHelper::renderTemplateVariables($subject,$entity->toArray()))
            ->label(StringHelper::renderTemplateVariables($subject,$entity->toArray()))
            ->from($mailConfig->mail_from_address,$mailConfig->mail_from_name)
        ->send();

        // Bind Email with Entity
        $emailContext = new EmailContext();
        $emailContext->email_id = $result->id;
        $emailContext->entity_id = $entity->id;
        $emailContext->entity_type = $entitType;
        $emailContext->save();

    }

    private function getLeadsEmails()
    {

        $user = \Auth::user();

        $leads = Lead::query()->with('leadEmails');

        if (!$user->access_to_all_entity) {
            $leadsScope = new OwnableEntityScope($user, 'leads', Lead::class);

            $leads = $leadsScope->apply($leads);
        }

        $emails = [];

        foreach ($leads->get() as $lead) {
            foreach ($lead->leadEmails as $leadEmail) {
                $emails[] = $leadEmail->email;
            }
        }

        return $emails;

    }

    private function getContactEmails()
    {

        $user = \Auth::user();

        $contacts = Contact::query()->with('contactEmails');

        if (!$user->access_to_all_entity) {
            $leadsScope = new OwnableEntityScope($user, 'contacts', Contact::class);

            $contacts = $leadsScope->apply($contacts);
        }

        $emails = [];

        foreach ($contacts->get() as $contact) {
            foreach ($contact->contactEmails as $contactEmail) {
                $emails[] = $contactEmail->email;
            }
        }

        return $emails;
    }

    public function getEmailTags()
    {

        $user = Auth::user();

        $emails = \Cache::remember('__available_emails_' . $user->id, config('sentemails.email_list_cache_time'), function () {
            return array_merge($this->getContactEmails(), $this->getLeadsEmails());
        });

        return $emails;
    }


}
