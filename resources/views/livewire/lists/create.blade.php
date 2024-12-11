<?php

use App\Models\EmailEntry;
use App\Models\EmailList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\LazyCollection;
use League\Csv\Reader;
use League\Csv\Statement;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

new class extends Component {
    use Toast, WithFileUploads;

    public ?string $name;

    public ?Collection $email_list;

    public ?array $emails=[];

    public $file;

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $email_list = EmailList::create(
            [
                "name" => $this->name
            ]
        );

        $this->file->store('csv_data');

        $email_entries = Reader::createFromPath($this->file->path(), 'r');
        $email_entries->setHeaderOffset(0);
        $email_entries->setEscape('');

        $stmt = Statement::create();

        $records = $stmt->process($email_entries);

        $email_entries = [];
        foreach ($records as $record) {
            $email_entries[] = [
                'email_list_id' => $email_list->id,
                'name' => $record['name'],
                'email' => $record['email'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        EmailEntry::query()->insert($email_entries);

        $this->emails = $email_list->email_entries()->get()->toArray();

        $this->success("Successfully created entry!", position: 'toast-bottom toast-end');
    }

    public function import()
    {

    }

    public
    function back()
    {
        return Redirect::to('lists');
    }


}; ?>

<div>
    @php
           $headers = [
               ['key' => 'id', 'label' => '#'],
               ['key' => 'name', 'label' => 'Name'],
               ['key' => 'email', 'label' => 'Email']
               ];

    @endphp
    <x-header title="Create Contact List" subtitle="Create a list and import our contacts from a csv-file." separator/>
        <x-form wire:submit="save">
            <x-input label="Name" wire:model="name"/>
            <x-file wire:model="file" label="CSV list" hint="Only CSV" accept="application/csv"/>
            <x-slot:actions>
                <x-button label="Back" class="btn-outline" link="/lists" wire:navigate spinner="back"/>
                <x-button label="Create" class="btn-primary" type="submit" spinner="create"/>
            </x-slot:actions>
        </x-form>

        <x-table :headers="$headers" :rows="$emails">
            <x-slot:empty>
                <x-icon name="fas.person" label="It is empty."/>
            </x-slot:empty>
        </x-table>
</div>
