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
use Livewire\WithPagination;
use Mary\Traits\Toast;

new class extends Component
{
    use Toast, WithFileUploads, WithPagination;

    public array $delimiters = [
        ['id' => 1, 'name' => ','],
        ['id' => 2, 'name' => ';'],
        ['id' => 3, 'name' => '|'],
        ['id' => 4, 'name' => '\t']
    ];

    public ?string $name;

    public string $email_column_name;

    public string $name_column_name;

    public int $column_delimiter_id = 0;

    public ?Collection $email_list;

    public ?array $emails = [];

    public $file;

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email_column_name' => 'required|string|max:255',
            'name_column_name' => 'required|string|max:255',
            'column_delimiter_id' => 'required'
        ]);

        $email_list = EmailList::create(
            [
                "name" => $this->name,
                "email_column_name" => $this->email_column_name,
                "name_column_name" => $this->name_column_name,
                "column_delimiter" => $this->delimiters[$this->column_delimiter_id]['name'],
                'user_id' => Auth::user()->id
            ]
        );

        $this->file->store("csv_data");

        $email_entries = Reader::createFromPath($this->file->path(), 'r');
        $email_entries->setHeaderOffset(0);
        $email_entries->setEscape('');
        $email_entries->setDelimiter($this->delimiters[$this->column_delimiter_id]['name']);

        $stmt = Statement::create();

        $records = $stmt->process($email_entries);

        $columns = ['name', 'email'];
        $email_entries = [];
        foreach ($records as $record) {
            try {
                $email_entries[] = [
                    'email_list_id' => $email_list->id,
                    'email' => $record[$email_list->email_column_name],
                    'name' => $record[$email_list->name_column_name],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } catch (Exception $err) {
                $this->warning(title: "Check the columns-names!", position: 'toast-bottom toast-end');
                break;
            }
        }
        // remove duplicates
        $unique_entries = [];
        foreach ($email_entries as $entry) {
            $key = $entry['email_list_id'] . '|' . $entry['email'] . '|' . $entry['name'];
            $unique_entries[$key] = $entry;
        }

        $email_entries = array_values($unique_entries);

        EmailEntry::query()->insert($email_entries);

        $this->emails = $email_list
            ->email_entries()
            ->limit(10)
            ->get()
            ->toArray();

        File::delete($this->file->path());

        $this->success("Successfully created the list!", position: 'toast-bottom toast-right');

        $this->reset();
    }


    public function load_csv()
    {

    }


    public function back()
    {
        return Redirect::to('lists');
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
    <x-header title="Create Contact List" subtitle="Create a list and import your contacts from a csv-file." separator/>
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
            <x-button label="Create" class="btn-primary" type="submit" spinner="create"/>
        </x-slot:actions>
    </x-form>

    <x-header title="List Entries" size="text-xl"
              subtitle="Your imported CSV-data. (View limited to 10 entries)"></x-header>
    <x-table :headers="$headers" :rows="$emails">
        <x-slot:empty>
            <x-icon name="fas.person" label="It is empty."/>
        </x-slot:empty>
    </x-table>


    <x-toast position="toast-bottom toast-right "/>
</div>
