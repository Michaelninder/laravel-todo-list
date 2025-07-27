<x-layouts.app :title="$list->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" wire:navigate />
            <flux:breadcrumbs.item href="{{ route('todo.index') }}" wire:navigate>{{ __('Todo Lists') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $list->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $list->name }}</h1>
            <div class="flex gap-2">
                <flux:button href="{{ route('todo.edit', $list->id) }}" wire:navigate>
                    {{ __('Edit List') }}
                </flux:button>
                <form action="{{ route('todo.destroy', $list->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <flux:button type="submit" variant="danger" onclick="return confirm('{{ __('Are you sure you want to delete this todo list?') }}')">
                        {{ __('Delete List') }}
                    </flux:button>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-6 w-full">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('Description') }}</h2>
                @if ($list->description)
                    <p class="text-gray-600 dark:text-gray-300">{{ $list->description }}</p>
                @else
                    <p class="text-gray-500 italic">{{ __('No description provided.') }}</p>
                @endif
            </div>

            @livewire('show-todo-list-items', ['list' => $list])
        </div>
    </div>
</x-layouts.app>