<button {{$attributes->merge(['class' => "px-3 py-1 rounded-sm cursor-pointer $buttonClass", 'id' => $id, 'type' => $type])}}>
    @if ($icon)
        <x-icon type="{{$icon}}"/>
    @endif
        {{$slot}}
</button>