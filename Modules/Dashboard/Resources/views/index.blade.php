@extends('layouts.app')

@section('content')

    <div class="row">

        @can('leads.browse')
            @widget('Modules\Dashboard\Widgets\CountWidget',['title' =>
            trans('dashboard::dashboard.widgets.leads'),'bg_color'=>'bg-pink','icon'=>'search','counter' =>
            $countLeads])
        @endcan

        @can('contacts.browse')
            @widget('Modules\Dashboard\Widgets\CountWidget',['title' =>
            trans('dashboard::dashboard.widgets.contacts'),'bg_color'=>'bg-cyan','icon'=>'contacts','counter' =>
            $countContacts])
        @endcan

        @can('orders.browse')
            @widget('Modules\Dashboard\Widgets\CountWidget',['title' =>
            trans('dashboard::dashboard.widgets.orders'),'bg_color'=>'bg-orange','icon'=>'pageview','counter' =>
            $countOrders])
        @endcan

        @can('invoices.browse')
            @widget('Modules\Dashboard\Widgets\CountWidget',['title' =>
            trans('dashboard::dashboard.widgets.invoices'),'bg_color'=>'bg-green','icon'=>'shopping_cart','counter' =>
            $countInvoices])
        @endcan
    </div>

    <div class="row dashboard-row">

        @can('leads.browse')
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
            <div class="card collapsible">
                <div id="dashboard_leads" class="header card-inside-title">

                    <span class="badge bg-pink pull-right">@lang('core::core.this_month')</span>
                    <h2 class="pointer">

                        @lang('dashboard::dashboard.widgets.leads_chart')

                        <span class="expander">
                            <i class="fa fa-angle-up pointer" aria-hidden="true"></i>
                        </span>
                    </h2>

                </div>
                <div class="body panel-content">
                    <div id="leads_chart" class="dashboard-leads_chart" style="height: 230px">
                        {!! $leadOverview->container() !!}
                    </div>


                </div>
            </div>
        </div>
        @endcan

        @can('payments.browse')
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <div class="card collapsible">
                <div id="dashboard_income_vs_payments" class="header card-inside-title">

                    <span class="badge bg-pink pull-right">@lang('core::core.last_three_months')</span>
                    <span class="badge bg-pink pull-right m-r-5">@lang('core::core.dict.usd')</span>
                    <h2 class="pointer">
                        @lang('dashboard::dashboard.widgets.income_vs_expenses')
                        <span class="expander">
                            <i class="fa fa-angle-up pointer" aria-hidden="true"></i>
                        </span>
                    </h2>
                </div>
                <div class="body panel-content" style="text-align: center">
                    <div id="income_chart" class="dashboard-income_chartt" style="text-align: center; height: 230px">
                        {!! $incomeVsExpense->container() !!}
                    </div>
                </div>
            </div>
        </div>
        @endcan

    </div>

    <div class="row dashboard-row">

        @can('tickets.browse')
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="card collapsible">
                <div id="dashboard_tickets" class="header card-inside-title">

                    <h2 class="pointer">
                        @lang('dashboard::dashboard.widgets.tickets')
                        <span class="expander">
                            <i class="fa fa-angle-up pointer" aria-hidden="true"></i>
                        </span>
                    </h2>
                </div>
                <div class="body panel-content">
                    <div class="table-responsive col-lg-12 col-md-12 col-sm-12">
                        {{ $ticketDatatable->table(['width' => '100%']) }}
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('tickets.browse')
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card collapsible">
                    <div id="dashboard_tickets_overview" class="header card-inside-title">

                        <span class="badge bg-red pull-right">@lang('core::core.this_month')</span>
                        <h2 class="pointer">

                            @lang('dashboard::dashboard.widgets.tickets_overview')
                            <span class="expander">
                            <i class="fa fa-angle-up pointer" aria-hidden="true"></i>
                        </span>
                        </h2>
                    </div>
                    <div class="body panel-content">
                        <h5>@lang('dashboard::dashboard.widgets.tickets_by_status')</h5>
                        <div style="text-align: center; height: 253px">
                            {!! $ticketStatusOverview->container() !!}
                        </div>
                        <br /><br />
                        <h5>@lang('dashboard::dashboard.widgets.tickets_by_priority')</h5>
                        <div style="text-align: center; height: 253px">
                            {!! $ticketPriorityOverview->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endcan

    </div>

@endsection


@push('css-up')

@endpush
@push('scripts')


@push('scripts')

    <script type="text/javascript" src="{{ asset('bap/plugins/chartjs/Chart.bundle.js')}}"></script>
    <script src="{!! Module::asset('dashboard:js/BAP_Dashboard.js') !!}"></script>

    {!! $leadOverview->script() !!}
    {!! $incomeVsExpense->script() !!}
    {!! $ticketStatusOverview->script() !!}
    {!! $ticketPriorityOverview->script() !!}

@endpush

@push('scripts')
{!! $ticketDatatable->scripts() !!}
@endpush


