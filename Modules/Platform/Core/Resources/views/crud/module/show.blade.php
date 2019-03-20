@extends('layouts.app')

@section('content')

    @if($settingsMode)
        <div class="block-header">
            <h2>@lang('settings::settings.module')</h2>
        </div>
    @endif

    <div class="row">

        @if($settingsMode)
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-vert-padding" >
                @include('settings::partial.menu')
            </div>
        @endif

        @if($settingsMode)
            <div  class="col-lg-9 col-md-9 col-sm-9 col-xs-12 no-vert-padding">
        @endif

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">


                    @includeFirst([$moduleName.'::card-header', 'core::crud.partial.card.card-header'])


                <div class="body">
                    <div class="row">


                        @if(!$disableTabs)
                        @if($relationTabs || $hasExtensions)

                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <ul class="nav nav-tabs tab-nav-right tabs-left" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#tab_details" data-toggle="tab"
                                           title="@lang('core::core.tabs.details')">
                                            @issetbap($baseIcons,'details_icon')
                                                <i class="material-icons">folder</i>
                                            @endissetbap
                                            @issetbap($baseIcons,'details_label')
                                                @lang('core::core.tabs.details')
                                            @endissetbap
                                        </a>
                                    </li>



                                        @foreach($relationTabs as $tabKey => $tab)

                                            @if(Auth::user()->hasPermissionTo($tab['permissions']['browse']))
                                                <li role="presentation">

                                                    <a href="#tab_{{$tabKey}}" data-toggle="tab" title="@lang($language_file.'.tabs.'.$tabKey)">

                                                        <i class="material-icons">{{$tab['icon']}}</i>

                                                        @lang($language_file.'.tabs.'.$tabKey)
                                                    </a>
                                                </li>
                                            @endif

                                        @endforeach


                                    @if($commentableExtension)
                                        <li role="presentation">
                                            <a href="#tab_comments" data-toggle="tab"
                                               title="@lang('core::core.tabs.comments')">
                                                @issetbap($baseIcons,'comments_icon')
                                                    <i class="material-icons">chat</i>
                                                @endissetbap
                                                @issetbap($baseIcons,'comments_label')
                                                    @lang('core::core.tabs.comments')
                                                @endissetbap
                                            </a>
                                        </li>
                                    @endif
                                    @if($attachmentsExtension)
                                        <li role="presentation">
                                            <a href="#tab_attachments" data-toggle="tab"
                                               title="@lang('core::core.tabs.attachments')">
                                                @issetbap($baseIcons,'attachments_icon')
                                                    <i class="material-icons">attach_file</i>
                                                @endissetbap
                                                @issetbap($baseIcons,'attachments_label')
                                                    @lang('core::core.tabs.attachments')
                                                @endissetbap
                                            </a>
                                        </li>
                                    @endif
                                    @if($actityLogDatatable != null )
                                        <li role="presentation">
                                            <a href="#tab_updates" data-toggle="tab"
                                               title="@lang('core::core.tabs.updates')">
                                                @issetbap($baseIcons,'activity_log_icon')
                                                    <i class="material-icons">change_history</i>
                                                @endissetbap
                                                @issetbap($baseIcons,'activity_log_label')
                                                    @lang('core::core.tabs.updates')
                                                @endissetbap
                                            </a>
                                        </li>
                                    @endif
                                </ul>

                            </div>

                        @endif
                        @endif

                        <div class="@if($disableTabs) col-lg-12 col-md-12 col-sm-12 col-xs-12 @else col-lg-10 col-md-10 col-sm-10 col-xs-10 @endif ">

                            <div class="tab-content">


                                <div role="tabpanel" class="tab-pane active" id="tab_details">



                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        @foreach($customShowButtons as $btn)
                                            {!! Html::customButton($btn) !!}
                                        @endforeach

                                    </div>

                                    @include('core::crud.module.show_form')

                                </div>

                                @include('core::crud.module.quick_edit')
                                @include('core::crud.module.quick_show')


                            @foreach($relationTabs as $tabKey => $tab)
                                    @if(Auth::user()->hasPermissionTo($tab['permissions']['browse']))
                                        <div role="tabpanel" class="tab-pane" id="tab_{{$tabKey}}">

                                            <div class="related_module_wrapper">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                        @if($tab['select']['allow'])

                                                            @if(Auth::user()->hasPermissionTo($tab['permissions']['update']))
                                                                <div class="select_relation_wrapper">
                                                                    <a href="#" class="select btn btn-primary waves-effect modal-relation">@lang('core::core.btn.select')</a>

                                                                    <div id="modal_{{$tabKey}}" class="modal fade" role="dialog">
                                                                        <div class="modal-dialog modal-xl">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                    @if(isset($tab['select']['modal_title']))
                                                                                        <h4 class="modal-title">@lang($tab['select']['modal_title'])</h4>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="modal-body linked-records">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 query-builder-filters">
                                                                                        @include('core::crud.partial.query_filter_builder_in_tab',['datatable' => $tab['newRecordsTable'],'entity'=>$entity,'tab'=>$tab])
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 linked-records">
                                                                                        @include('core::crud.relation.relation',['datatable' => $tab['newRecordsTable'],'entity'=>$entity,'tab'=>$tab])
                                                                                    </div>

                                                                                </div>
                                                                                <div class="modal-footer">

                                                                                    @include('core::crud.relation.link',['tabkey'=>$tabKey,'entityId' => $entityIdentifier,'route'=>$tab['route']['bind_selected']])

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            @endif
                                                        @endif

                                                        @if($tab['create']['allow'])
                                                            @if(Auth::user()->hasPermissionTo($tab['permissions']['create']))
                                                                <div class="create_new_relation_wrapper">



                                                                    <a href="#" class="select btn btn-primary waves-effect modal-new-relation">@if(isset($tab['create']['label'])) @lang($tab['create']['label']) @else @lang('core::core.btn.new') @endif</a>

                                                                        <div data-create-route="{{ route($tab['route']['create'],$tab['create']['post_create_bind']) }}" id="modal_create_{{$tabKey}}" class="modal fade" role="dialog">
                                                                            <div class="modal-dialog modal-xl">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                        @if(isset($tab['create']['modal_title']))
                                                                                            <h4 class="modal-title">@lang($tab['create']['modal_title'])</h4>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="modal-body">

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 linked-records"  id="linked_{{$tabKey}}">
                                                        @include('core::crud.relation.relation',['datatable' => $tab['htmlTable'],'entity'=>$entity,'tab'=>$tab])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach


                                @if($commentableExtension)
                                    <div role="tabpanel" class="tab-pane" id="tab_comments">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            @include('core::extension.comments.list',['entity'=>$entity])
                                        </div>
                                    </div>
                                @endif

                                @if($attachmentsExtension)
                                    <div role="tabpanel" class="tab-pane" id="tab_attachments">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            @include('core::extension.attachments.list',['entity'=>$entity,'permissions'=>$permissions])
                                        </div>

                                    </div>
                                @endif


                                @if($actityLogDatatable !=  null )
                                    <div role="tabpanel" class="tab-pane" id="tab_updates">

                                        <div class="table-responsive col-lg-12 col-md-12">
                                            @include('core::extension.activity_log.table')
                                        </div>
                                    </div>
                                @endif
                            </div>


                        </div>


                    </div>

                </div>
            </div>
        </div>

                @if($settingsMode)
            </div>
            @endif
    </div>
    </div>

    @foreach($includeViews as $v)
        @include($v)
    @endforeach


@endsection

@push('css')
    @foreach($cssFiles as $file)
        <link rel="stylesheet" href="{!! Module::asset($moduleName.':css/'.$file) !!}"></link>
    @endforeach
@endpush

@push('scripts')

@foreach($jsFiles as $jsFile)
    <script src="{!! Module::asset($moduleName.':js/'.$jsFile) !!}"></script>
@endforeach

@endpush


