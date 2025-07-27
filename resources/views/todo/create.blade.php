<x-layouts.app :title="__('Create Todo List')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" wire:navigate />
            <flux:breadcrumbs.item href="{{ route('todo.index') }}" wire:navigate>{{ __('Todo Lists') }}</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ __('Create') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Create New Todo List') }}</h1>
        </div>

        <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-6 max-w-lg mx-auto w-full">
            <form action="{{ route('todo.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <flux:input
                        name="name"
                        :label="__('List Name')"
                        type="text"
                        required
                        autofocus
                        value="{{ old('name') }}"
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
                    >{{ old('description') }}</flux:textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    <flux:button variant="outline" href="{{ route('todo.index') }}">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Create List') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>