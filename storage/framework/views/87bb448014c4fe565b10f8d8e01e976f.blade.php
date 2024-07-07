<div class="flex items-center gap-2">
    <div class="avatar">
        <div {{ $attributes->class(["w-7 rounded-full"]) }}>
            <img src="{{ $image }}" />
        </div>
    </div>
    @if($title || $subtitle)
    <div>
        @if($title)
            <div @class(["font-semibold font-lg", is_string($title) ? '' : $title?->attributes->get('class') ]) >
                {{ $title }}
            </div>
        @endif
        @if($subtitle)
            <div @class(["text-sm text-gray-400", is_string($subtitle) ? '' : $subtitle?->attributes->get('class') ]) >
                {{ $subtitle }}
            </div>
        @endif
    </div>
    @endif
</div>