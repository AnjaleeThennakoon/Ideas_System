<x-layout>
    <div >
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">
                Idea
            </h1>
            <p class="text-muted-foreground">Capture your thoughts</p>
        </header>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6" >
                @forelse($ideas as $idea)
                    <x-card href="{{ route('idea.show',$idea) }}">
                        <h3 class=" text-foreground text-lg "> {{ $idea-> title }}</h3>

                        <div class="mt-5 line-clamp-3"> {{ $idea->description }}</div>
                        <div class="mt-4">{{ $idea->created_at ->diffForHumans() }}</div>
                    </x-card>

                @empty
                    <x-card>
                        <p>No ideas at the time</p>
                    </x-card>
                @endforelse
            </div>

        </div>

    </div>
</x-layout>
