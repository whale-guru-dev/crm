<div class="header">
    <h2>
        <div class="header-buttons">



            @if(!$disableNextPrev)
                <div class="btn-group next-prev-btn-group" role="group">

                    @if($prev_record)
                        <a href="{{ route($routes['show'],$prev_record) }}"
                           title="@lang('core::core.crud.prev')"
                           class="btn btn-primary waves-effect btn-crud btn-prev">@lang('core::core.crud.prev')</a>
                    @endif

                    @if($next_record)
                        <a href="{{ route($routes['show'],$next_record) }}"
                           title="@lang('core::core.crud.next')"
                           class="btn btn-primary waves-effect btn-crud btn-next">@lang('core::core.crud.next')</a>
                    @endif
                </div>
            @endif

            <div class="btn-group btn-crud pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('core::core.more') <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    @foreach($actionButtons as $link)
                        <li>
                            {{ Html::link($link['href'],$link['label'],$link['attr']) }}
                        </li>
                    @endforeach

                    @if($permissions['destroy'] == '' or Auth::user()->hasPermissionTo($permissions['destroy']))
                        <li>
                            {!! Form::open(['route' => [$routes['destroy'], $entity], 'method' => 'delete']) !!}

                            {!! Form::button(trans('core::core.crud.delete'), [ 'type' => 'submit', 'class' => '"btn btn-block btn-link  waves-effect waves-block', 'onclick' => "return confirm($.i18n._('are_you_sure'))" ]) !!}

                            {!! Form::close() !!}

                        </li>
                    @endif

                </ul>
            </div>

            <a href="{{ route($routes['index']) }}"
               class="btn btn-primary waves-effect btn-back btn-crud">@lang('core::core.crud.back')</a>

            @if($permissions['update'] == '' or Auth::user()->hasPermissionTo($permissions['update']))
                <a href="{{ route($routes['edit'],$entity) }}"
                   class="btn btn-primary waves-effect btn-edit btn-crud">@lang('core::core.crud.edit')</a>
            @endif

        </div>

        @if($moduleDictionary || $settingsMode)
            @include('core::crud.partial.card.card-title')
        @else
            @includeFirst([$moduleName.'::card-title', 'core::crud.partial.card.card-title'])
        @endif


    </h2>
</div>