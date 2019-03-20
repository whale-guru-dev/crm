@extends('layouts.app')

@section('content')

    <div class="block-header">
        <h2>@lang('settings::settings.module')</h2>
    </div>

    <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-vert-padding">
            @include('settings::partial.menu')
        </div>

        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 no-vert-padding">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>

                            <a href="{{ route('settings.company-plans.show',$plan->id) }}" class="btn btn-primary btn-create btn-crud">@lang('companies::companyPlans.back')</a>

                            @lang('companies::companyPlans.assign_permissions_to') - {{ $plan->name }}
                            <small>@lang('companies::companyPlans.module_permissions_description')</small>
                        </h2>
                    </div>
                    <div class="body">

                        <div class="row clearfix">
                            <div class="col-sm-12">

                                {{ Form::open(['route'=>['settings.company-plans.permissions-save',$plan->id],'method'=>'POST']) }}

                                @foreach($permissions as $group => $permission )

                                    @if(!empty($disabledGroups) && in_array(strtolower($group),$disabledGroups))

                                    @else
                                    <div class="col-sm-6">
                                        <h2 class="card-inside-title" style="margin-bottom: 10px">{{ $group }}</h2>

                                        @foreach($permission as $key => $perm)

                                            <div class="switch">
                                                <label>
                                                    {{ Form::checkbox('permissions[]',strtolower($perm['name']),in_array(strtolower($perm['name']),$planPermissions)),['id' => strtolower($perm['name'])] }}
                                                    <span class="lever switch-col-red">
                                                    </span>
                                                    {{ $perm['name'] }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                    @endif
                                @endforeach

                                <div class="col-sm-12">


                                    {!! Form::submit(trans('companies::companyPlans.save_permissions'),['class="btn btn-primary m-t-15 waves-effect"']) !!}
                                </div>

                                {!! Form::close() !!}

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {!! JsValidator::formRequest(\Modules\Platform\Settings\Http\Requests\SaveCompanySettingsRequest::class, '#company_settings_form') !!}
@endpush