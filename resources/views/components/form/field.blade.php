@props(['label' => null, 'name'  , 'type' =>'text'])

<div class="space-y-2">
{{--    @if($label)--}}
        <label for="{{ $name }}" class="label">{{ $label }}</label>
{{--    @endif--}}
    <input type= {{ $type }} class="input" id="{{ $name }}" name="{{ $name }}" value=" {{ old($name) }}" {{ $attributes }}>

    @error($name)
        <p class="error" > {{ $message }}</p>
    @enderror

</div>

