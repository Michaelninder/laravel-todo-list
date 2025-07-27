<x-layouts.app :title="$list->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
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

            <div class="border-t border-gray-200 dark:border-zinc-600 pt-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('List Items') }}</h2>
                @forelse ($list->items as $item)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-800 rounded-md mb-2">
                        <div class="flex items-center gap-3">
                            <input type="checkbox"
                                   id="item-{{ $item->id }}"
                                   class="form-checkbox h-5 w-5 text-primary-600 rounded"
                                   @checked($item->state === 'done')
                                   onclick="return false;"
                            >
                            <label for="item-{{ $item->id }}" class="text-gray-800 dark:text-gray-200
                                @if($item->state === 'done') line-through text-gray-500 dark:text-gray-400 @endif">
                                {{ $item->name }}
                            </label>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs px-2 py-1 rounded-full
                                @if($item->state === 'done') bg-green-200 text-green-800 @elseif($item->state === 'in_progress') bg-blue-200 text-blue-800 @elseif($item->state === 'cancelled') bg-red-200 text-red-800 @else bg-gray-200 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $item->state)) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-300">{{ __('No items in this list yet.') }}</p>
                @endforelse

                <div class="mt-4 flex justify-end">
                    <flux:button href="{{ route('todo.items.create', $list->id) }}" variant="primary">
                        {{ __('Add New Item') }}
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>