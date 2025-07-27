<x-layouts.app :title="__('Edit Todo List: ') . $list->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Todo List') }}</h1>
        </div>

        <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-6 max-w-lg mx-auto w-full">
            <form action="{{ route('todo.update', $list) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <flux:input
                        name="name"
                        :label="__('List Name')"
                        type="text"
                        required
                        autofocus
                        value="{{ old('name', $list->name) }}"
                    />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:textarea
                        name="description"
                        :label="__('Description (Optional)')"
                        rows="4"
                    >{{ old('description', $list->description) }}</flux:textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    <flux:button variant="outline" href="{{ route('todo.index') }}">
                        {{ __('Back to Lists') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Update List') }}
                    </flux:button>
                </div>
            </form>

            <div class="mt-8 border-t border-gray-200 dark:border-zinc-600 pt-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('List Items') }}</h2>
                @forelse ($list->items as $item)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-800 rounded-md mb-2">
                        <span class="text-gray-800 dark:text-gray-200">{{ $item->name }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-xs px-2 py-1 rounded-full
                                @if($item->state === 'done') bg-green-200 text-green-800 @elseif($item->state === 'in_progress') bg-blue-200 text-blue-800 @else bg-gray-200 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $item->state)) }}
                            </span>
                            <a href="{{ route('todo.items.edit', ['todo' => $list->id, 'item' => $item->id]) }}" class="text-sm text-primary-500 hover:text-primary-700">{{ __('Edit Item') }}</a>
                            {{-- <button wire:click="deleteItem('{{ $item->id }}')" class="text-red-500 hover:text-red-700 text-sm">Delete</button> --}}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-300">{{ __('No items in this list yet.') }}</p>
                @endforelse

                <div class="mt-4">
                    <flux:button href="{{ route('todo.items.create', $list) }}" variant="secondary">
                        {{ __('Add New Item') }}
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>