<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h2 id="{{ \Stringy\Stringy::create($language_file.'.panel.'.$panelName)->slugify('_') }}" class="card-inside-title">


        <span class="pointer">
            @lang($language_file.'.panel.'.$panelName)

            <span class="expander">
                <i class="fa fa-angle-up pointer" aria-hidden="true"></i>
            </span>
        </span>

        <div class="section-buttons">
        @if(isset($sectionButtons))
            @foreach($sectionButtons as $button)

                @if($button['section'] == $panelName)
                    <a title="@if(isset($button['title']) && $button['title']) @lang($language_file.'.'.$button['title']) @endif" id="{{ $button['id'] }}" class="normal-text {{ $button['class'] }}" href="{{ $button['href'] }}">
                        @if(isset($button['icon']) && $button['icon'])
                            <i class="{{ $button['icon'] }}"></i>
                        @endif
                        @if(isset($button['label']) && $button['label'])
                            @lang($language_file.'.'.$button['label'])
                        @endif
                    </a>
                @endif
            @endforeach
        @endif
        </div>


    </h2>


</div>
