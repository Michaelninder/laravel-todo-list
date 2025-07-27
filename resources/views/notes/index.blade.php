<x-layouts.app :title="__('My Notes')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" wire:navigate />
            <flux:breadcrumbs.item>{{ __('My Notes') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('My Notes') }}</h1>
            <flux:button href="{{ route('notes.create') }}" wire:navigate>
                {{ __('Create New Note') }}
            </flux:button>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($notes as $note)
                <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            <a href="{{ route('notes.show', $note->id) }}" wire:navigate class="hover:text-primary-600 dark:hover:text-primary-400">
                                {{ $note->name }}
                            </a>
                        </h2>
                        @if ($note->description)
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ Str::limit($note->description, 100) }}</p>
                        @endif
                    </div>
                    <div class="flex items-center justify-end text-gray-500 dark:text-gray-400 text-sm mt-4 pt-4 border-t border-gray-200 dark:border-zinc-600">
                        <div class="flex space-x-2">
                            <a href="{{ route('notes.edit', $note->id) }}" wire:navigate class="text-primary-500 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this note?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger-500 hover:text-danger-700 dark:text-danger-400 dark:hover:text-danger-300">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-600 dark:text-gray-300 py-8">
                    <p>{{ __('No notes found. Create your first one!') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>