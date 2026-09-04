<x-layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between items-center">
            <a href="{{ route('idea.index') }}" class="flex items-center gap-x-2 text-sm font-medium">
                <x-icons.arrow-back/>
                Back to ideas</a>

            <div class="gap-x-3 flex items-center">
                <button class=" btn btn-outlined ">
{{--                    <x-icons.external />--}}

                    Edit Idea
                </button>

                <form method="Post" action="{{ route('idea.destroy',$idea) }}">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-outlined !text-rose-500">Delete</button>

                </form>

            </div>
        </div>

        <div class="mt-8 space-y-6">
            <h1 class="font-bold text-4xl">{{ $idea->title }}</h1>

            <div class="mt-2 flex gap-x-3 items-center">
                <x-idea.status-label :status="$idea->status->value">
                    {{ $idea->status->label() }}
                </x-idea.status-label>

                <div class="text-muted-foreground text-sm">{{ $idea->created_at ->diffForHumans() }}</div>
            </div>
        </div>

        <div class="mt-8 space-y-6">
            <div class="border border-border rounded-lg bg-card p-4">
                <div class="text-foreground max-w-none cursor-pointer">
                    {{ $idea->description }}
                </div>
            </div>
        </div>


        @if($idea->links)
            <h3 class="font-bold text-xl mt-6">Link</h3>

            <div class="mt-3 space-y-2">
                <x-card :href="$idea->links" class="text-primary font-medium flex gap-x-3 items-center">
                    <x-icons.external class="w-5 h-5 shrink-0" />
                    {{ $idea->links }}
                </x-card>
            </div>
        @endif
    </div>
</x-layout>
