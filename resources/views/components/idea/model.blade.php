@props(['idea' =>new App\Models\Idea()])

<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}" title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}">
    <form
        x-data="{
            status: @js(old('status', $idea->status?->value ?? 'pending')),
            newLink: '',
            links: @js(old('links', $idea->links ?? [])),
            newStep: '',
            steps: @js(old('steps', $idea->steps->pluck('description')->all()))
        }"
        method="POST"
        action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        enctype="multipart/form-data" >


    @csrf
    @if($idea->exists)
        @method('PATCH')
    @endif
        <div class="space-y-6  ">
            <x-form.field
                label="Title"
                name="title"
                placeholder="Enter an idea for you title"
                autofocus
                required
                :value="$idea->title"
            />

            {{--Status cases 3--}}
            <div class="space-y-2">
                <label for="status" class="label">Status </label>
                <div class="flex gap-3">
                    @foreach( \App\Models\IdeaStatus::cases() as $status)
                        <button type="button"
                                x-on:click="status = '{{ $status->value }}'"
                                data-test="button-status-{{ $status->value }}"
                                class ="btn flex-1 h-10"
                                :class="{'btn-outlined': status !== @js($status->value)} ">
                            {{ $status->label() }}
                        </button>
                    @endforeach
                    <input type="hidden" name="status"  :value="status" class="input">
                </div>
                <x-form.error name="status"/>
            </div>

            {{--description--}}
            <x-form.field
                label="description"
                name="description"
                type="textarea"
                placeholder="Enter an idea for you idea..."
                :value="$idea->description"
            />

            {{--choose file--}}
            <div class="space-y-2">
                <label for="image" class="label">Featured Image</label>
                @if($idea->image_path)
                    <div class="mb-4 mx-4 mt-4 overflow-hidden rounded-t-lg">
                        <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}"
                             class="h-48 w-full object-cover rounded-lg">
                    </div>

                @endif
                <input type="file" name="image" accept="image/*">
                <x-form.error name="image"/>

            </div>

            <div>
                <fieldset  class="space-y-3">
                    <legend class="label">Actionable Steps</legend>


                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex gap-x-2 items-center">
                            <input name="steps[]" x-model="steps[index]" class="input">
                            <button
                                type="button"
                                aria-label="Remove step"
                                x-on:click="steps.splice(index, 1)"
                                class="form-muted-icon">
                                <x-icons.close />
                            </button>
                        </div>
                    </template>




                    <div class="flex gap-x-2 items-center">
                        <input
                            x-model="newStep"
                            id="new-step"
                            data-test="new-step"
                            placeholder="what needs to be done?"
                            class="input flex-1"
                            spellcheck="false">
                        <button
                            type="button"
                            x-on:click="steps.push(newStep.trim()); newStep = '';"
                            data-test="submit-new-step-button"
                            :disabled="newStep.trim().length === 0"
                            aria-label="Add a new step"
                            class="form-muted-icon">
                            <x-icons.close class="rotate-45"/>
                        </button>
                    </div>
                </fieldset>
            </div>


            <div>
                <fieldset  class="space-y-3">
                    <legend class="label">Links</legend>


                    <template x-for="(link,index) in links" :key="link">
                        <div class="flex gap-x-2 items-center">
                            <label for="" class="sr-only" >Link</label>
                            <input  name="links[]" x-model="link" class="input">
                            <button
                                type="button"
                                aria-label="Remove Link"
                                x-on:click="links.splice(index, 1)"
                                class="form-muted-icon">
                                <x-icons.close />
                            </button>
                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center">
                        <input
                            x-model="newLink"
                            type="url"
                            id="new-link"
                            data-test="new-link"
                            placeholder="http:example.com"
                            autocomplete="url"
                            class="input flex-1"
                            spellcheck="false">
                        <button
                            type="button"
                            x-on:click="links.push(newLink.trim()); newLink = '';"
                            data-test="submit-new-link-button"
                            :disabled="newLink.trim().length === 0"
                            aria-label="Add a new Link"
                            class="form-muted-icon">
                            <x-icons.close class="rotate-45"/>
                        </button>
                    </div>
                </fieldset>
            </div>

            <div class="flex justify-end gap-x-5">
                <button type="button" x-on:click="$dispatch('close-modal')">Cancel</button>
                <button type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>

            </div>

        </div>
    </form>
</x-modal>
