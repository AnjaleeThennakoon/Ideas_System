@props(['label' => null, 'name'  , 'type' =>'text'])

<div class="space-y-2">
{{--    @if($label)--}}
        <label for="{{ $name }}" class="label">{{ $label }}</label>
{{--    @endif--}}
    <input type="text" class="input" id="{{ $name }}" name="{{ $name }}" {{ $attributes }}>
</div>
