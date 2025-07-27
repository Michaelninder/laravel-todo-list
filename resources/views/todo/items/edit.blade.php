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
                    <flux:select name="state" id="state" placeholder="{{ __('Choose state...') }}" class="mt-1 block w-full"
                        value="{{ old('state', $item->state) }}"
                    >
                        <flux:select.option value="open">{{ __('Open') }}</flux:select.option>
                        <flux:select.option value="in_progress">{{ __('In Progress') }}</flux:select.option>
                        <flux:select.option value="done">{{ __('Done') }}</flux:select.option>
                        <flux:select.option value="cancelled">{{ __('Cancelled') }}</flux:select.option>
                    </flux:select>
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