@component('mail::message')

    <div>
        This is test email send from CRM.

        {!! $mailSettings->mail_signature !!}
    </div>


@endcomponent
