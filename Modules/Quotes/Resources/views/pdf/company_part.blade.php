<b>@lang('quotes::quotes.pdf.address')</b><br/>
{{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_ADDRESS_)}} <br/>
{{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_CITY)}}
{{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_POSTAL_CODE)}}
{{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_STATE)}}

@if(\Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_COUNTRY))

    @php
    try{
     echo \Modules\Platform\Settings\Entities\Country::where('id',\Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_COUNTRY))->first()->name;
    }catch(\Exception $e){
    }
    @endphp
@endif
<br/>
@if(!empty(\Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_VAT_ID)))
    @lang('quotes::quotes.pdf.vat'): {{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_VAT_ID)}} <br/>
@endif
@lang('quotes::quotes.pdf.phone'): {{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_PHONE)}} <br/>
@lang('quotes::quotes.pdf.fax'): {{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_FAX)}} <br/>
