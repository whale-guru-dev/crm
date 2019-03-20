<h2>@lang('orders::orders.pdf.company')</h2>
{{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_ADDRESS_)}} <br/>
{{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_CITY)}} {{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_STATE)}} {{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_POSTAL_CODE)}}

{{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_COUNTRY)}} <br/>
@if(!empty(\Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_VAT_ID)))
    @lang('orders::orders.pdf.vat'): {{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_VAT_ID)}} <br/>
@endif
@lang('orders::orders.pdf.phone'): {{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_PHONE)}} <br/>
@lang('orders::orders.pdf.fax'): {{ \Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_COMPANY_FAX)}} <br/>
