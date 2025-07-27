<?php

namespace App\Livewire;

use App\Models\TodoList;
use App\Models\TodoItem;
use Livewire\Component;

class ShowTodoListItems extends Component
{
    public TodoList $list;
    public $items;
    public ?string $editingItemId = null;
    public array $editingItemName = [];

    protected $listeners = ['itemCreated' => 'loadItems']; // Refresh on item creation
    protected array $rules = [
        'editingItemName.*' => 'required|string|max:255',
    ];

    public function mount(TodoList $list): void
    {
        $this->list = $list;
        $this->loadItems();
    }

    public function loadItems(): void
    {
        $this->items = $this->list->items()->orderBy('created_at')->get();
    }

    public function toggleState(string $itemId): void
    {
        $item = TodoItem::find($itemId);

        if (!$item || $item->list_id !== $this->list->id) {
            return;
        }

        if ($item->state === 'cancelled') {
            return; // Cannot change state of cancelled items via toggle
        } elseif ($item->state === 'done') {
            $item->state = 'open';
        } elseif ($item->state === 'in_progress') {
            $item->state = 'done';
        } else { // 'open'
            $item->state = 'in_progress';
        }

        $item->save();
        $this->loadItems();
    }

    public function startEdit(string $itemId): void
    {
        $item = TodoItem::find($itemId);

        if (!$item || $item->list_id !== $this->list->id) {
            return;
        }

        $this->editingItemId = $itemId;
        $this->editingItemName[$itemId] = $item->name;
    }

    public function saveName(string $itemId): void
    {
        $item = TodoItem::find($itemId);

        if (!$item || $item->list_id !== $this->list->id) {
            return;
        }

        // Validate the specific item's name being edited
        $this->validateOnly("editingItemName.{$itemId}");

        $item->name = $this->editingItemName[$itemId];
        $item->save();

        $this->editingItemId = null;
        unset($this->editingItemName[$itemId]);
        $this->loadItems();
    }

    public function cancelEdit(): void
    {
        $this->editingItemId = null;
        $this->editingItemName = [];
    }

    public function render()
    {
        return view('livewire.show-todo-list-items');
    }
}