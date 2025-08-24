<?php

use App\Models\EmailTemplate;
use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

new class extends Component {
    use WithFileUploads, Toast;

    /*
     * $table->string('name');
            $table->mediumText('html');
     * */

    public string $name;
    public $html;

    public User $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function save(): void
    {

        EmailTemplate::create([
            "name" => $this->name,
            "html" => $this->html,
            "user_id" => $this->user->id
        ]);

        $this->success("Successfully created the email template!", position: 'toast-bottom toast-right');
    }
}; ?>

<div class="max-w-4xl mx-auto p-6 space-y-6">
    <x-header
        title="Create Email Campaign"
        subtitle="Set up your email campaign with configuration, template, and scheduling options."
        separator
    />

    <x-form wire:submit="save" class="space-y-6">
        <x-input label="Template name" wire:model="name"/>
        <x-file wire:model="html" label="HTML CONTENT" hint="Only HTML" accept="application/html"/>

        <div class="flex justify-between items-center pt-4">
            <x-button label="Back" class="btn-outline" link="/templates" spinner="back"/>
            <x-button label="Create" class="btn-primary" type="submit" spinner="create"/>
        </div>
    </x-form>


    <x-toast position="toast-bottom toast-right"/>

</div>
