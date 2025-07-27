<x-layouts.app :title="__('Edit Note: ') . $note->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" wire:navigate />
            <flux:breadcrumbs.item href="{{ route('notes.index') }}" wire:navigate>{{ __('My Notes') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('notes.show', $note->id) }}" wire:navigate>{{ $note->name }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edit Note') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Note: ') . $note->name }}</h1>
        </div>

        <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-6 max-w-2xl mx-auto w-full">
            <form action="{{ route('notes.update', $note->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <flux:input
                        name="name"
                        :label="__('Note Title')"
                        type="text"
                        required
                        autofocus
                        value="{{ old('name', $note->name) }}"
                    />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:textarea
                        name="description"
                        :label="__('Description (Optional)')"
                        rows="3"
                    >{{ old('description', $note->description) }}</flux:textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:label for="content">{{ __('Content') }}</flux:label>
                    @livewire('note-editor-wrapper', ['noteId' => $note->id, 'initialContent' => old('content', $note->content)])
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    <flux:button variant="outline" href="{{ route('notes.index') }}">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Update Note') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>