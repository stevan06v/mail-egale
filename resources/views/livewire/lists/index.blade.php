<?php

use App\Models\EmailList;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public ?Collection $emails;

    public function mount()
    {
        $this->emails = EmailList::query()
            ->orderBy(...array_values($this->sortBy))
            ->get();
    }

    public function delete($id)
    {
        EmailList::query()
            ->where("id", "=", $id)
            ->delete();
    }

}; ?>

<div>

    @php
        $emails = EmailList::query()
                ->orderBy(...array_values($this->sortBy))
                ->paginate(5);

            $headers = [
                ['key' => 'id', 'label' => '#'],
                ['key' => 'name', 'label' => 'Name'],
                ['key' => 'created_at', 'label' => 'Date', 'format' => ['date', 'd/m/Y'],
                ['key'=> 'actions', 'label' => 'Actions']
                ]

            ];
    @endphp
    <x-header title="Contact Lists" subtitle="Manage your contacts easily!" separator/>

    <div class="flex">
        <x-button link="lists/create" label="Create" class="btn-primary ml-auto"></x-button>
    </div>

    <x-table :headers="$headers" :rows="$emails" with-pagination>

        <x-slot:empty>
            <x-icon name="fas.address-book" label="It is empty."/>
        </x-slot:empty>

        @scope('actions', $email)
        <div class="flex-initial flex gap-2">
            <x-button icon="fas.eye" link="lists/{{$email->id}}/show" spinner class="btn-sm"/>
            <x-button icon="fas.pen-to-square" link="lists/{{$email->id}}/edit" spinner class="btn-sm"/>
            <x-button icon="fas.trash-can" wire:click="delete({{ $email->id }})" spinner class="btn-sm btn-primary"/>
        </div>
        @endscope


    </x-table>
    <x-toast position="toast-bottom toast-center"/>


</div>
