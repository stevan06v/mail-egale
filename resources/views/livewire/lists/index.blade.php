<?php

use App\Models\EmailList;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public ?Collection $emails;

    public function mount()
    {
        $this->emails = EmailList::query()
            ->orderBy(...array_values($this->sortBy))
            ->take(3)
            ->get();
    }
    public function delete($id)
    {
        dd($id);
    }

}; ?>

<div>

    @php
        $emails = EmailList::query()
            ->orderBy(...array_values($this->sortBy))
            ->take(3)
            ->get();

        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'created_at', 'label' => 'Date', 'format' => ['date', 'd/m/Y'],
            ['key'=> 'actions', 'label' => 'Actions']
            ]

        ];
    @endphp
    <x-header title="Email Lists" subtitle="Manage your contacts easily!" separator/>

    <div class="flex">
        <x-button link="lists/create" label="Create" class="btn-outline ml-auto"></x-button>
    </div>

    <x-table :headers="$headers" :rows="$emails" @row-click="alert($event.detail.name)">

        <x-slot:empty>
            <x-icon name="fas.address-book" label="It is empty."/>
        </x-slot:empty>

        @scope('actions', $email)
        <div class="flex-initial flex gap-2">
            <x-button icon="fas.trash-can" wire:click="delete({{ $email->id }})" spinner class="btn-sm"/>
            <x-button icon="fas.pen-to-square" link="lists/{{$email->id}}/edit" spinner class="btn-sm"/>
        </div>
        @endscope


    </x-table>


</div>
