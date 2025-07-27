<x-layouts.app :title="__('Edit Item: ') . $item->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" wire:navigate />
            <flux:breadcrumbs.item href="{{ route('todo.index') }}" wire:navigate>{{ __('Todo Lists') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('todo.show', $list->id) }}" wire:navigate>{{ $list->name }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Edit Item') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Item: ') . $item->name }}</h1>
        </div>

        <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-6 max-w-lg mx-auto w-full">
            <form action="{{ route('todo.items.update', ['todo' => $list->id, 'item' => $item->id]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <flux:input
                        name="name"
                        :label="__('Item Name')"
                        type="text"
                        required
                        autofocus
                        value="{{ old('name', $item->name) }}"
                    />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:label for="state">{{ __('Status') }}</flux:label>
                    <select id="state" name="state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                        <option value="open" {{ old('state', $item->state) === 'open' ? 'selected' : '' }}>{{ __('Open') }}</option>
                        <option value="in_progress" {{ old('state', $item->state) === 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                        <option value="done" {{ old('state', $item->state) === 'done' ? 'selected' : '' }}>{{ __('Done') }}</option>
                        <option value="cancelled" {{ old('state', $item->state) === 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                    </select>
                    @error('state')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    <flux:button variant="outline" href="{{ route('todo.show', $list->id) }}">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Update Item') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>