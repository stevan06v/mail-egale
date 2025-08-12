<?php

use App\Models\EmailConfiguration;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public string $name;
    public string $smtp_host;
    public int $port;
    public string $username;
    public string $password;


    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'smtp_host' => 'required|string|max:255',
            'port' => 'required',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        $config = EmailConfiguration::create(
            [
                'name' => $this->name,
                'smtp_host' => $this->smtp_host,
                'port' => $this->port,
                'username' => $this->username,
                'password' => $this->password,
                'user_id' => Auth::id()
            ]
        );

        $this->success("Successfully created the configuration!", position: 'toast-bottom toast-right');
    }


}; ?>
<div class="max-w-3xl mx-auto p-6">
    <x-header
        title="Create Email Configuration"
        subtitle="Create email configurations for your campaigns."
        separator
    />

    <x-form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-input label="Configuration Name" wire:model="name" />
            <x-input label="SMTP Host" wire:model="smtp_host" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-input label="Port" wire:model="port" type="number" />
            <x-input label="Username" wire:model="username" />
        </div>

        <div>
            <x-password label="Password" wire:model="password" />
        </div>

        <div class="flex justify-between items-center pt-4">
            <x-button label="Back" class="btn-outline" link="/profiles" spinner="back" />
            <x-button label="Create" class="btn-primary" type="submit" spinner="create" />
        </div>
    </x-form>

    <x-toast position="toast-bottom toast-right" />
</div>
