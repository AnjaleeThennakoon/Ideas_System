<x-layout>
    <x-form title="Register an account" description="Start tracking your ideas today.">
        <form action="/register" method="POST" class="mt-10 space-y-4" >
            @csrf
{{--            <div class="space-y-2">--}}
{{--                <label for="name" class="label"> Name</label>--}}
{{--                <input type="text" class="input" id="name" name="name">--}}
{{--            </div>--}}
            <x-form.field name="name" label="Name" />

{{--            <div class="space-y-2">--}}
{{--                <label for="email" class="label" >Email </label>--}}
{{--                <input type="email" class="input" id="name" name="name">--}}
{{--            </div>--}}
            <x-form.field name="email" label="Email" />

{{--            <div class="space-y-2">--}}
{{--                <label for="password" class="label" >password </label>--}}
{{--                <input type="password" class="input" id="password" name="password">--}}
{{--            </div>--}}
            <x-form.field name="password" label="Password" />

            <button type="submit" class="btn mt-2 h-10 w-full " >Create Account </button>

        </form>
    </x-form>
</x-layout>
