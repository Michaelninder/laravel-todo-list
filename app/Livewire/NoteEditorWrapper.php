<?php

namespace App\Livewire;

use Livewire\Component;

class NoteEditorWrapper extends Component
{
    public string $content = '';
    public ?string $noteId = null;
    public string $initialContent;

    protected array $rules = [
        'content' => 'nullable|string|max:102400',
    ];

    public function mount(?string $noteId = null, string $initialContent = ''): void
    {
        $this->noteId = $noteId;
        $this->initialContent = $initialContent;
        $this->content = $initialContent;
    }

    public function callControllerMethod(string $action): \Illuminate\Http\RedirectResponse
    {
        if (!$this->noteId) {
            session()->flash('error', __('Please save the note first to perform this action.'));
            return redirect()->back();
        }

        return redirect()->route("notes.{$action}", $this->noteId);
    }

    public function render()
    {
        return view('livewire.note-editor-wrapper');
    }
}