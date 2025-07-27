<div>
    <flux:editor>
        <flux:editor.toolbar>
            <flux:editor.heading />
            <flux:editor.separator />
            <flux:editor.bold />
            <flux:editor.italic />
            <flux:editor.strike />
            <flux:editor.separator />
            <flux:editor.bullet />
            <flux:editor.ordered />
            <flux:editor.blockquote />
            <flux:editor.separator />
            <flux:editor.link />
            <flux:editor.separator />
            <flux:editor.align />
            <flux:editor.spacer />
            <flux:dropdown position="bottom end" offset="-15">
                <flux:editor.button icon="ellipsis-horizontal" tooltip="More" />
                <flux:menu>
                    <flux:menu.item wire:click="callControllerMethod('preview', '{{ $noteId }}')" icon="arrow-top-right-on-square">{{ __('Preview') }}</flux:menu.item>
                    <flux:menu.item wire:click="callControllerMethod('export', '{{ $noteId }}')" icon="arrow-down-tray">{{ __('Export') }}</flux:menu.item>
                    <flux:menu.item wire:click="callControllerMethod('share', '{{ $noteId }}')" icon="share">{{ __('Share') }}</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </flux:editor.toolbar>
        <flux:editor.content wire:model="content" />
    </flux:editor>

    <input type="hidden" name="content" value="{{ $content }}">
</div>