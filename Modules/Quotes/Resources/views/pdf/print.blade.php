<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $entity->name }}</title>

    <!-- Invoice styling -->
    <style>
        table, tr, td, th, tbody, thead, tfoot {
            page-break-inside: avoid !important;
        }

        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06F;
        }

        .invoice-box {

            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.top table td.title .logo {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .title .logo img {
            max-width: 300px;
            max-height: 300px;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding-left: 10px;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;

        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
            text-align: left;
            padding-left: 10px;

        }

        .invoice-box table tr.summary td {
            border-bottom: 1px solid #eee;
            text-align: left;
            padding-left: 10px;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .text-center{
            text-align: center;
        }
        .text-right {
            text-align: right !important;
        }
        .width-50-percent{
            width: 50%;;
        }

        .image_path_size{
            max-width: 150px;
        }

    </style>
</head>

<body>

<div class="invoice-box">


    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="4">
                <table>
                    <tr>
                        <td class="title">

                                @if(\Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_DISPLAY_SHOW_LOGO_IN_PDF))
                                <div class="logo">
                                    {!!   \Modules\Platform\Core\Helper\SettingsHelper::pdfLogoPath() !!}
                                </div>
                                @else
                                    @include('quotes::pdf.company_part')
                                @endif


                        </td>
                        <td class="text-right">
                            @lang('quotes::quotes.pdf.quote') #: {{ $entity->id }}<br>
                            @lang('quotes::quotes.pdf.created'): {{ \Modules\Platform\Core\Helper\UserHelper::formatUserDate($entity->created_at) }}<br>
                            @lang('quotes::quotes.pdf.valid_until'): {{ \Modules\Platform\Core\Helper\UserHelper::formatUserDate($entity->valid_unitl) }}<br>

                            @if(\Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_DISPLAY_SHOW_LOGO_IN_PDF))
                                @include('quotes::pdf.company_part')
                            @endif

                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="4">
                <table>
                    <tr>
                        <td class="width-50-percent">
                            <h2>@lang('quotes::quotes.pdf.quotation_for')</h2>
                            @if(!empty($entity->account))
                                {{ $entity->account->name }} <br/>
                            @endif
                            {{ $entity->street }}<br/>
                            {{ $entity->city }} {{ $entity->state }} {{ $entity->zip_code }}<br />
                            {{ optional($entity->country)->name }} <br/>

                            @if(!empty($entity->contact)) <br/>
                            <b>@lang('quotes::quotes.pdf.contact')</b> <br/>
                            {{ $entity->contact->full_name }} <br/>
                            @lang('quotes::quotes.pdf.email'): {{ $entity->contact->mobile }} <br/>
                            @lang('quotes::quotes.pdf.mobile'): {{ $entity->contact->email }} <br/>
                            @lang('quotes::quotes.pdf.office_phone'): {{ $entity->contact->phpne }}
                            @endif
                        </td>

                        <td class="width-50-percent">
                            @if(!empty($entity->owner))
                                <h2>@lang('quotes::quotes.pdf.sales_representative')</h2>

                                {{ $entity->owner->name }} <br/>
                                @lang('quotes::quotes.pdf.email'): {{ $entity->owner->email }} <br/>
                                @lang('quotes::quotes.pdf.mobile'): {{ $entity->owner->mobile_phone }} <br/>
                                @lang('quotes::quotes.pdf.office_phone'): {{ $entity->owner->office_phone }}

                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>
                @lang('quotes::quotes.pdf.product_service')
            </td>

            <td class="text-right">
                @lang('quotes::quotes.pdf.unit_cost')
            </td>
            <td class="text-right">
                @lang('quotes::quotes.pdf.quantity')
            </td>
            <td class="text-right">
                @lang('quotes::quotes.pdf.line_total')
            </td>
        </tr>

        @foreach($entity->rows as $row)
            <tr class="item">
                <td>
                    {{ $row->product_name }}

                    @if(config('quotes.show_product_image') && !empty($row->product))
                        <br />
                        <img src="{{ public_path($row->product->image_path) }}" class="image_path_size" />
                    @endif

                </td>
                <td class="text-right">
                    {{ number_format($row->price,2) }}
                    @if(!empty($entity->currency))
                        {{ $entity->currency->code }}
                    @endif
                </td>
                <td class="text-right">
                    {{ $row->quantity }}
                </td>
                <td class="text-right">
                    {{ number_format($row->lineTotal,2) }}
                    @if(!empty($entity->currency))
                        {{ $entity->currency->code }}
                    @endif
                </td>
            </tr>
        @endforeach
        <tr class="summary">
            <td colspan="2" rowspan="7">
            </td>
            <td class="text-right">
                @lang('quotes::quotes.pdf.subtotal')

            </td>
            <td class="text-right">
                {{ number_format($entity->subtotal,2) }}
                @if(!empty($entity->currency))
                    {{ $entity->currency->code }}
                @endif
            </td>
        </tr>
        <tr class="summary">
            <td class="text-right">
                <label>
                    @lang('quotes::quotes.pdf.discount')
                </label>
            </td>
            <td class="text-right">
                {{ number_format($entity->discount,2) }}
                @if(!empty($entity->currency))
                    {{ $entity->currency->code }}
                @endif
            </td>
        </tr>
        <tr class="summary">
            <td class="text-right">
                <label class=" text-right">
                    @lang('quotes::quotes.pdf.delivery_cost')
                </label>
            </td>
            <td class="text-right">
                {{ number_format($entity->delivery_cost,2) }}
                @if(!empty($entity->currency))
                    {{ $entity->currency->code }}
                @endif
            </td>
        </tr>
        <tr class="summary">
            <td class="text-right">
                <label class=" text-right">
                    @lang('quotes::quotes.pdf.tax')
                    @if(!empty($entity->tax))
                        ({{ $entity->tax->name }})
                    @endif
                </label>
            </td>
            <td class="text-right">
                {{ number_format($entity->taxValue,2) }}
                @if(!empty($entity->currency))
                    {{ $entity->currency->code }}
                @endif
            </td>
        </tr>
        <tr class="summary">
            <td class="text-right">
                <label class=" text-right">
                    @lang('quotes::quotes.pdf.gross_value')
                </label>
            </td>
            <td class="text-right">
                <strong>
                    {{ number_format($entity->grossValue,2) }}
                    @if(!empty($entity->currency))
                        {{ $entity->currency->code }}
                    @endif
                </strong>
            </td>
        </tr>

    </table>
    @if($entity->shipping)
        <br/><br/>
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    @lang('quotes::quotes.pdf.shipping')
                </td>
            </tr>
            <tr class="item">
                <td>
                    @if(!empty($entity->quoteCarrier))
                        @lang('quotes::quotes.pdf.carrier'): {{$entity->quoteCarrier->name}}  <br/>
                    @endif
                    {{ $entity->shipping }}
                </td>
            </tr>
        </table>
    @endif
    @if($entity->notes)
        <br/><br/>
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    @lang('quotes::quotes.pdf.notes')
                </td>
            </tr>
            <tr class="item">
                <td>
                    {{ $entity->notes }}
                </td>
            </tr>
        </table>
    @endif
</div>

</html>
