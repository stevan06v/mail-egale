<?php

use App\Models\EmailList;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public EmailList $emailList;

    public function mount($emailList)
    {
        $this->emailList = $emailList;
    }
}; ?>
<div>
    @php
        $emailEntries = $emailList->email_entries()->paginate(10);
        $headers = [
                ['key' => 'id', 'label' => '#'],
                ['key' => 'email', 'label' => 'Email'],
            ];
    @endphp
    <x-header title="List Entries" size="text-xl"
              subtitle="Your imported CSV-data.  (Limited to 10 entries)"></x-header>
    <x-table lazy with-pagination :headers="$headers" :rows="$emailEntries">
        <x-slot:empty>
            <x-icon name="fas.person" label="It is empty."/>
        </x-slot:empty>
    </x-table>
</div>
