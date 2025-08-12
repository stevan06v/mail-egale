<?php

use App\Models\EmailConfiguration;
use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;


    public function delete($id)
    {
        EmailConfiguration::where("id", "=", $id)->delete() ;
    }

}; ?>

<div>
    @php
        $emailConfigs = EmailConfiguration::all()->where('user_id', '=', Auth::id());
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Profile Name'],
            ['key' => 'smtp_host', 'label' => 'SMTP Host'],
            ['key' => 'port', 'label' => 'Port']

        ];
    @endphp

    <x-header title="Create Email-Profiles" subtitle="Manage profiles easily!" separator/>

    <div class="flex">
        <x-button link="profiles/create" label="Create" class="btn-primary ml-auto"></x-button>
    </div>

    <x-table :headers="$headers" :rows="$emailConfigs" >

        <x-slot:empty>
            <x-icon name="fas.screwdriver-wrench" label="It is empty."/>
        </x-slot:empty>

        @scope('actions', $emailConfig)
        <div class="flex-initial flex gap-2">
            <x-button icon="fas.pen-to-square" link="profiles/{{$emailConfig->id}}/edit" spinner class="btn-sm"/>
            <x-button icon="fas.trash-can" wire:click="delete({{$emailConfig->id}})" spinner class="btn-sm btn-primary"/>
        </div>
        @endscope
    </x-table>

</div>
