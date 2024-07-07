<div>
    <!-- STANDARD LABEL -->
    @if($label && !$inline)
        <label for="{{ $uuid }}" class="pt-0 label label-text font-semibold">
            <span>
                {{ $label }}

                @if($attributes->get('required'))
                    <span class="text-error">*</span>
                @endif
            </span>
        </label>
    @endif

    <div class="flex-1 relative">
        <!-- INPUT -->
        <textarea
            placeholder = "{{ $attributes->whereStartsWith('placeholder')->first() }} "

            {{
                $attributes
                ->class([
                    'textarea textarea-primary w-full peer',
                    'pt-5' => ($inline && $label),
                    'border border-dashed' => $attributes->has('readonly') && $attributes->get('readonly') == true,
                    'textarea-error' => $errors->has($errorFieldName())
                ])
            }}
        >{{ $slot }}</textarea>

        <!-- INLINE LABEL -->
        @if($label && $inline)
            <label for="{{ $uuid }}" class="absolute text-gray-400 duration-300 transform -translate-y-3 scale-75 top-4 bg-white rounded dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2  peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                {{ $label }}
            </label>
        @endif
    </div>

    <!-- ERROR -->
    @if(!$omitError && $errors->has($errorFieldName()))
        @foreach($errors->get($errorFieldName()) as $message)
            @foreach(Arr::wrap($message) as $line)
                <div class="{{ $errorClass }}" x-classes="text-red-500 label-text-alt p-1">{{ $line }}</div>
                @break($firstErrorOnly)
            @endforeach
            @break($firstErrorOnly)
        @endforeach
    @endif

    <!-- HINT -->
    @if($hint)
        <div class="label-text-alt text-gray-400 p-1 pb-0">{{ $hint }}</div>
    @endif
</div>