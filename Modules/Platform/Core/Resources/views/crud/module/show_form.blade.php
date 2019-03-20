
<div class="row">
    @foreach($show_fields as $panelName => $panel)
        <div class="collapsible">

            {{ Html::section($language_file,$panelName) }}

            <div class="panel-content">
                @foreach($panel as $fieldName => $options)

                    {{
                        Html::renderField($entity,$fieldName,$options,$language_file)
                    }}
                @endforeach
            </div>


        </div>

    @endforeach

    @include('core::crud.partial.entity_created_at')

</div>


