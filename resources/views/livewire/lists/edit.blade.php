<?php

use App\Models\EmailList;
use App\Models\EmailEntry;
use App\Models\User;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public EmailList $email_list;
    public ?string $name;
    public ?string $email_column_name;
    public ?string $name_column_name;
    public array $delimiters = [
        ['id' => 1, 'name' => ','],
        ['id' => 2, 'name' => ';'],
        ['id' => 3, 'name' => '|'],
        ['id' => 4, 'name' => '\t']
    ];
    public int $column_delimiter_id = 0;

    public ?array $emails = [];

    public function mount($id)
    {
        $this->email_list = EmailList::find($id);
        $this->name = $this->email_list->name;
        $this->email_column_name = $this->email_list->email_column_name;
        $this->name_column_name = $this->email_list->name_column_name;
        $this->emails = $this->email_list->email_entries()->get()->toArray();
    }

    public function save()
    {
        $this->email_list->update([
            "name" => $this->name,
            "email_column_name" => $this->email_column_name,
            "name_column_name" => $this->name_column_name,
            "column_delimiter" => $this->delimiters[$this->column_delimiter_id]['name']
        ]);

        EmailEntry::query()
            ->where("email_list_id", "=", $this->email_list->id)
            ->delete();

        // need to update list entries too
        $this->success("Successfully updated the list!", position: 'toast-bottom toast-right');
    }

}; ?>

<div>
    @php
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'name', 'label' => 'Name']
            ];
    @endphp
    <x-header title="Edit Contact List" subtitle="Update a list and import your contacts from a csv-file." separator/>
    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name"/>

        <x-input label="Email-Column Name" wire:model="name_column_name"/>
        <x-input label="Name-Column Name" wire:model="email_column_name"/>

        <div class="flex-initial flex gap-2">
            <x-file wire:model="file" label="CSV list" hint="Only CSV" accept="application/csv"/>
            <x-select label="Delimiter" icon="fas.file-csv" :options="$delimiters"
                      wire:model="column_delimiter_id"/>
        </div>

        <x-slot:actions>
            <x-button label="Back" class="btn-outline" link="/lists" wire:navigate spinner="back"/>
            <x-button label="Update" class="btn-primary" type="submit" spinner="update"/>
        </x-slot:actions>
    </x-form>

    <x-header title="List Entries" size="text-xl"
              subtitle="Your imported CSV-data.  (Limited to 10 entries)"></x-header>
    <x-table :headers="$headers" :rows="$emails">
        <x-slot:empty>
            <x-icon name="fas.person" label="It is empty."/>
        </x-slot:empty>
    </x-table>


    <x-toast position="toast-bottom toast-right "/>

</div>
