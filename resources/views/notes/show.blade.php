<x-layouts.app :title="$note->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" wire:navigate />
            <flux:breadcrumbs.item href="{{ route('notes.index') }}" wire:navigate>{{ __('My Notes') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $note->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $note->name }}</h1>
            <div class="flex gap-2">
                <flux:button href="{{ route('notes.edit', $note->id) }}" wire:navigate>
                    {{ __('Edit Note') }}
                </flux:button>
                <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this note?') }}')">
                    @csrf
                    @method('DELETE')
                    <flux:button type="submit" variant="danger">
                        {{ __('Delete Note') }}
                    </flux:button>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-6 w-full">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('Description') }}</h2>
                @if ($note->description)
                    <p class="text-gray-600 dark:text-gray-300">{{ $note->description }}</p>
                @else
                    <p class="text-gray-500 italic">{{ __('No description provided.') }}</p>
                @endif
            </div>

            <div class="border-t border-gray-200 dark:border-zinc-600 pt-6 prose dark:prose-invert">
                {{-- Render content directly as HTML --}}
                {!! $note->content !!}
            </div>
        </div>
    </div>
</x-layouts.app>