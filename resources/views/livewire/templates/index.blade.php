<?php

use App\Models\EmailTemplate;
use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];


    public function delete($emailTemplateId): void
    {
        EmailTemplate::where('id', '=', $emailTemplateId)->delete();
    }

}; ?>

<div>
    @php
        $email_templates  = User::findOrFail(Auth::id())
            ->email_templates()
            ->orderBy(...array_values($this->sortBy))
            ->paginate(5);

                    $headers = [
                            ['key' => 'id', 'label' => '#'],
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'actions', 'label' => '']
                    ];
    @endphp


    <x-header title="Email Templates" subtitle="Manage your email templates easily!" separator/>

    <div class="flex">
        <x-button link="templates/create" label="Create" class="btn-primary ml-auto"></x-button>
    </div>

    <x-table with-pagination :headers="$headers" :rows="$email_templates">

        <x-slot:empty>
            <x-icon name="fas.address-book" label="It is empty."/>
        </x-slot:empty>

        @scope('actions', $template)
        <div class="flex-initial flex gap-2">
            <x-button icon="fas.eye" link="templates/{{$template->id}}" spinner class="btn-sm"/>
            <x-button icon="fas.pen-to-square" link="templates/{{$template->id}}/edit" spinner class="btn-sm"/>
            <x-button icon="fas.trash-can" wire:click="delete({{$template->id}})" spinner class="btn-sm btn-primary"/>
        </div>
        @endscope
    </x-table>
    <x-toast position="toast-bottom toast-center"/>

</div>
