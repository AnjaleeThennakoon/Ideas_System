@props(['label', 'name', 'type' => 'text', 'value' => ''])

<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="label">{{ $label }}</label>
    @endif

    @if($type === 'textarea')
        <textarea
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $attributes->merge(['class' => 'textarea']) }}
        >{{ old($name, $value) }}</textarea>
    @else
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            {{ $attributes->merge(['class' => 'input w-flull']) }}>
    @endif

    <x-form.error name="{{ $name }}" />
</div>
