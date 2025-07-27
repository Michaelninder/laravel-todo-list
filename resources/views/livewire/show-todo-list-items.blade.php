<div class="mt-8 border-t border-gray-200 dark:border-zinc-600 pt-6">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('List Items') }}</h2>
    @forelse ($items as $item)
        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-800 rounded-md mb-2">
            <div class="flex items-center gap-3 w-full">
                <input type="checkbox"
                       id="item-checkbox-{{ $item->id }}"
                       class="form-checkbox h-5 w-5 text-primary-600 rounded cursor-pointer
                           @if($item->state === 'cancelled') disabled opacity-50 @endif"
                       @checked($item->state === 'done')
                       @if($item->state === 'cancelled') disabled @endif
                       wire:click="toggleState('{{ $item->id }}')"
                >

                @if ($editingItemId === $item->id)
                    <input type="text"
                           class="flex-1 rounded-md text-gray-800 dark:text-gray-200
                                  border-transparent bg-transparent focus:border-transparent focus:ring-0
                                  p-0 m-0" {{-- REMOVED BORDER, BG, PADDING --}}
                           wire:model.live="editingItemName.{{ $item->id }}"
                           wire:keydown.enter="saveName('{{ $item->id }}')"
                           wire:keydown.escape="cancelEdit"
                           x-ref="editInput{{ $item->id }}"
                           x-init="$nextTick(() => $refs.editInput{{ $item->id }}.focus())"
                    >
                @else
                    <label for="item-checkbox-{{ $item->id }}"
                           class="flex-1 text-gray-800 dark:text-gray-200 cursor-pointer
                           @if($item->state === 'done') line-through text-gray-500 dark:text-gray-400 @endif
                           @if($item->state === 'cancelled') line-through text-red-500 dark:text-red-400 @endif"
                           wire:dblclick="startEdit('{{ $item->id }}')"
                    >
                        {{ $item->name }}
                    </label>
                @endif
            </div>

            <div class="flex items-center gap-2 min-w-[100px] justify-end">
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
        <flux:button href="{{ route('todo.items.create', $list->id) }}" variant="primary"> {{-- Changed to variant="primary" --}}
            {{ __('Add New Item') }}
        </flux:button>
    </div>
</div>