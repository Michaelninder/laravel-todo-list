<x-layouts.app :title="__('Todo Lists')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Your Todo Lists') }}</h1>
            <flux:button href="{{ route('todo.create') }}" wire:navigate>
                {{ __('Create New Todo List') }}
            </flux:button>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($lists as $list)
                <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            <a href="{{ route('todo.show', $list) }}" wire:navigate class="hover:text-primary-600 dark:hover:text-primary-400">
                                {{ $list->name }}
                            </a>
                        </h2>
                        @if ($list->description)
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ Str::limit($list->description, 100) }}</p>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-gray-500 dark:text-gray-400 text-sm mt-4 pt-4 border-t border-gray-200 dark:border-zinc-600">
                        <span>
                            {{ trans_choice('{0} No items|{1} 1 item|[2,*] :count items', $list->items_count, ['count' => $list->items_count]) }}
                        </span>
                        <div class="flex space-x-2">
                            <a href="{{ route('todo.edit', $list) }}" wire:navigate class="text-primary-500 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                {{ __('Edit') }}
                            </a>
                            {{-- <button wire:click="deleteList('{{ $list->id }}')" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                {{ __('Delete') }}
                            </button> --}}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-600 dark:text-gray-300 py-8">
                    <p>{{ __('No todo lists found. Create your first one!') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>