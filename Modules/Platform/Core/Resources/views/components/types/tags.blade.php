
@foreach($entity->tags()->get() as $tag)
    <span class="label label-info">{{$tag->name}}</span>
@endforeach
