<x-layouts.app :title="__('Todo Lists')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <flux:button>Create New Todo List</flux:button>

            @foreach ($lists as $list)
            {{ $list->name() }}
            {{ $list->description() }}
            {{ $list->item_count() }}
            @endforeach
        </div>
    </div>
</x-layouts.app>
