
@if(is_array($entity->$fieldName))
    {!! implode(',',$entity->$fieldName)!!}
@else
    {{ $entity->$fieldName }}
@endif

