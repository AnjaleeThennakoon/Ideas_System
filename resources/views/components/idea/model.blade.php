@props(['idea' => new App\Models\Idea()])

<x-modal
    name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}"
    title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}"
>
    <form
        x-data="{
            status: '{{ old('status', $idea->status?->value ?? \App\Models\IdeaStatus::PENDING->value) }}',
            newLink: '',
            links: {{ Js::from(old('links', $idea->links ?? [])) }},
            newStep: '',
            steps: {{ Js::from(old('steps', $idea->steps->pluck('description')->all())) }}
        }"
        method="POST"
        action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        enctype="multipart/form-data"
    >
        @csrf
        @if($idea->exists)
            @method('PUT')
        @endif

        <div class="space-y-6">
            {{-- Title --}}
            <x-form.field
                label="Title"
                name="title"
                dusk="title"
                placeholder="Enter a title for your idea"
                :value="old('title', $idea->title ?? '')"
                autofocus
                required
            />

            {{-- Status --}}
            <div class="space-y-2">
                <label for="status" class="label">Status</label>
                <div class="flex gap-3">
                    @foreach(\App\Models\IdeaStatus::cases() as $status)
                        <button
                            type="button"
                            x-on:click="status = '{{ $status->value }}'"
                            dusk="button-status-{{ $status->value }}"
                            class="btn flex-1 h-10"
                            :class="status === '{{ $status->value }}' ? '' : 'btn-outlined'"
                        >
                            {{ $status->label() }}
                        </button>
                    @endforeach
                    <input type="hidden" name="status" :value="status">
                </div>
                <x-form.error name="status"/>
            </div>

            {{-- Description --}}
            <x-form.field
                label="Description"
                name="description"
                type="textarea"
                dusk="description"
                placeholder="Enter a description for your idea..."
                :value="old('description', $idea->description ?? '')"
            />

            {{-- Image --}}
            <div class="space-y-2">
                <label for="image" class="label">Featured Image</label>

                @if($idea->exists && $idea->image_path)
                    <div class="mb-3">
                        <img src="{{ Storage::url($idea->image_path) }}"
                             alt="Current image"
                             class="w-32 h-32 object-cover rounded-lg border border-gray-700">
                        <p class="text-xs text-gray-500 mt-1">Current image</p>
                    </div>
                @endif

                <div x-data="{ fileName: '', previewUrl: null }" class="space-y-3">
                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept="image/*"
                        class="hidden"
                        x-ref="fileInput"
                        dusk="image-input"
                        @change="
                            const file = $event.target.files[0];
                            fileName = file?.name ?? '';
                            previewUrl = file ? URL.createObjectURL(file) : null;
                        "
                    >

                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            @click="$refs.fileInput.click()"
                            class="px-5 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-black font-semibold transition"
                        >
                            Choose File
                        </button>

                        <span
                            class="text-sm text-gray-400 truncate max-w-xs"
                            x-text="fileName || 'No file chosen'"
                        ></span>
                    </div>

                    <template x-if="previewUrl">
                        <div>
                            <img :src="previewUrl"
                                 alt="Preview"
                                 class="w-32 h-32 object-cover rounded-lg border border-gray-700">
                            <p class="text-xs text-gray-500 mt-1">New image preview</p>
                        </div>
                    </template>
                </div>

                <x-form.error name="image"/>
            </div>

            {{-- Steps --}}
            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Actionable Steps</legend>

                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex gap-x-2 items-center">
                            <input name="steps[]" x-model="steps[index]" class="input">

                            <button
                                type="button"
                                aria-label="Remove step"
                                x-on:click="steps.splice(index, 1)"
                                class="form-muted-icon"
                            >
                                <x-icons.close/>
                            </button>
                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center">
                        <input
                            x-model="newStep"
                            id="new-step"
                            dusk="new-step"
                            placeholder="What needs to be done?"
                            class="input flex-1"
                            spellcheck="false"
                        >
                        <button
                            type="button"
                            x-on:click="if (newStep.trim()) { steps.push(newStep.trim()); newStep = ''; }"
                            dusk="submit-new-step-button"
                            :disabled="newStep.trim().length === 0"
                            aria-label="Add a new step"
                            class="form-muted-icon"
                        >
                            <x-icons.close class="rotate-45"/>
                        </button>
                    </div>
                </fieldset>
            </div>

            {{-- Links --}}
            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Links</legend>

                    <template x-for="(link, index) in links" :key="index">
                        <div class="flex gap-x-2 items-center">
                            <label class="sr-only">Link</label>
                            <input name="links[]" x-model="links[index]" class="input">
                            <button
                                type="button"
                                aria-label="Remove Link"
                                x-on:click="links.splice(index, 1)"
                                class="form-muted-icon"
                            >
                                <x-icons.close/>
                            </button>
                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center">
                        <input
                            x-model="newLink"
                            type="url"
                            id="new-link"
                            dusk="new-link"
                            placeholder="https://example.com"
                            autocomplete="url"
                            class="input flex-1"
                            spellcheck="false"
                        >
                        <button
                            type="button"
                            x-on:click="if (newLink.trim()) { links.push(newLink.trim()); newLink = ''; }"
                            dusk="submit-new-link-button"
                            :disabled="newLink.trim().length === 0"
                            aria-label="Add a new link"
                            class="form-muted-icon"
                        >
                            <x-icons.close class="rotate-45"/>
                        </button>
                    </div>
                </fieldset>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-x-5">
                <button type="button" x-on:click="$dispatch('close-modal')">Cancel</button>
                <button type="submit" class="btn" dusk="submit-idea">
                    {{ $idea->exists ? 'Update' : 'Create' }}
                </button>
            </div>
        </div>
    </form>
</x-modal>
