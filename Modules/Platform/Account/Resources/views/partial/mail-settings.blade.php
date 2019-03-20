{!! form_start($mailSettingsForm) !!}


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        {!! form_row($mailSettingsForm->mail_host) !!}
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        {!! form_row($mailSettingsForm->mail_port) !!}
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        {!! form_row($mailSettingsForm->mail_username) !!}
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        {!! form_row($mailSettingsForm->mail_password) !!}
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        {!! form_row($mailSettingsForm->mail_encryption) !!}
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        {!! form_row($mailSettingsForm->mail_from_address) !!}
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        {!! form_row($mailSettingsForm->mail_from_name) !!}
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        {!! form_row($mailSettingsForm->mail_signature) !!}
    </div>

</div>

{!! form_end($mailSettingsForm, $renderRest = true) !!}


@push('scripts')
    {!! JsValidator::formRequest(\Modules\Platform\Account\Http\Requests\MailSettingsRequest::class, '#mail_settings_form') !!}
@endpush