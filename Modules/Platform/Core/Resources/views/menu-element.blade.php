<a href="{{ $url }}" title="{{ $name }}" class="{{ isset($cssClass) ? $cssClass : '' }}">
    @if(isset($icon))
        @if(\Stringy\Stringy::create($icon)->startsWith('fa'))
            <div class="menu-fa-icon">
                <i class="{{ $icon  }}"></i>
            </div>

            <span>{{ $name  }}</span>
        @else
            <i class="material-icons">{{ $icon  }}</i>
            <span>{{ $name  }}</span>
        @endif

    @else
        {{ $name  }}
    @endif
</a>